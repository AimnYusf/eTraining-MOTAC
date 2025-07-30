'use strict';

$(function () {
  // Variables
  const dateFields = ['#isy_tkhmula', '#isy_tkhtamat'];
  const dt_table = $('.datatables');

  const statusObj = [];
  window.statusData.forEach(item => {
    statusObj.push(item.stp_keterangan);
  });

  let fv;
  const formAuthentication = document.querySelector('#courseForm');

  // Functions
  function initializePicker() {
    dateFields.forEach(selector => {
      $(selector).flatpickr({
        monthSelectorType: 'static',
        dateFormat: 'd/m/Y'
      });
    });
  }

  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }

  // Datatable Setup
  if (dt_table.length) {
    var table = dt_table.DataTable({
      ajax: {
        url: '/isytihar',
        type: 'GET'
      },
      columns: [
        { data: 'isy_id' },
        { data: 'isy_nama' },
        { data: 'isy_tkhmula' },
        { data: 'isy_tkhtamat' },
        { data: 'isy_status' },
        { data: '' }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        },
        {
          targets: 1,
          render: (data, type, full, meta) => `<span class="text-uppercase">${data}</span>`
        },
        {
          targets: 2,
          render: data => formatDate(data)
        },
        {
          targets: 3,
          render: data => formatDate(data)
        },
        {
          targets: 4,
          autoWidth: false,
          render: (data, type, full) =>
            `<span class="badge bg-label-${full.etra_status.stp_class}" style="white-space: normal;">${full.etra_status.stp_keterangan}</span>`
        },
        {
          targets: -1,
          searchable: false,
          orderable: false,
          render: function (data, type, full) {
            var button;
            if (full.isy_status == 6) {
              button = `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light edit-record" data-id=${full.isy_id} data-bs-toggle="tooltip" title="Edit">
                  <i class="ti ti-edit ti-md"></i>
                </button>`;
            } else {
              button = `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.isy_id} data-bs-toggle="tooltip" title="Papar Perincian Kursus">
                  <i class="ti ti-eye ti-md"></i>
                </button>`;
            }

            return `<div class="d-inline-block text-nowrap">
              ${button}
            </div>`;
          }
        },
        {
          targets: [0, 2, 3, 4, 5],
          className: 'text-center'
        }
      ],
      dom:
        '<"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"' +
        '<"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>' +
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"' +
        '<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [10, 25, 50, 100],
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Carian',
        info: 'Memaparkan _START_ hingga _END_ daripada _TOTAL_ entri',
        paginate: {
          next: '<i class="ti ti-chevron-right ti-sm"></i>',
          previous: '<i class="ti ti-chevron-left ti-sm"></i>'
        }
      },
      buttons: [
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Rekod Baru</span>',
          className: 'add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light',
          action: function () {
            initializePicker();
            $('#courseForm')[0].reset();
            $('#isy_id').val('');
            $('#message').removeClass('d-none');
            $('#isy_tajuk').html('Tambah Rekod Kursus');
            $('.submit-btn').removeClass('d-none');
            $('.close-btn').addClass('d-none');
            $('#manageRecord').modal('show');
          }
        }
      ],
      initComplete: function () {
        this.api()
          .columns(4)
          .every(function () {
            const column = this;
            const select = $(
              '<select id="filterStatus" class="selectpicker" data-style="btn-default" title="Status"><option value="">Semua</option></select>'
            )
              .insertBefore('.dt-action-buttons .dt-buttons')
              .on('change', function () {
                const val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d) {
                select.append(`<option value="${statusObj[d - 1]}">${statusObj[d - 1]}</option>`);
              });
          });

        $('.selectpicker').selectpicker();
      },
      drawCallback: function () {
        [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')).map(el => new bootstrap.Tooltip(el));
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');
  }

  // UI Adjustments
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  function getRecord(isy_id, isViewMode) {
    $.get(`/isytihar/${isy_id}`, data => {
      if (isViewMode) {
        dateFields.forEach(selector => {
          $(selector)[0]._flatpickr?.destroy();
        });
      }

      ['isy_id', 'isy_nama', 'isy_tkhmula', 'isy_tkhtamat', 'isy_jam', 'isy_tempat', 'isy_anjuran'].forEach(field => {
        const value = ['isy_tkhmula', 'isy_tkhtamat'].includes(field) ? formatDate(data[field]) : data[field];
        $(`#${field}`).val(value).prop('readonly', isViewMode);
      });

      $('#isy_tajuk').html('Maklumat Kursus');

      // Manage button visibility based on mode
      $('.submit-btn').toggleClass('d-none', isViewMode);
      $('.close-btn').toggleClass('d-none', !isViewMode);

      $('#manageRecord').modal('show');
    });
  }

  table.on('click', '.edit-record', function () {
    $('#message').removeClass('d-none');
    getRecord($(this).data('id'), false);
  });

  table.on('click', '.view-record', function () {
    $('#message').addClass('d-none');
    getRecord($(this).data('id'), true);
  });

  // Form Validation & Submission
  // Form Validation & Submission
  if (formAuthentication) {
    fv = FormValidation.formValidation(formAuthentication, {
      fields: {
        isy_nama: { validators: { notEmpty: { message: 'Sila masukkan nama kursus' } } },
        isy_tkhmula: { validators: { notEmpty: { message: 'Sila pilih tarikh mula kursus' } } },
        isy_tkhtamat: { validators: { notEmpty: { message: 'Sila pilih tarikh tamat kursus' } } },
        isy_tempat: { validators: { notEmpty: { message: 'Sila masukkan tempat kursus' } } },
        isy_anjuran: { validators: { notEmpty: { message: 'Sila masukkan penganjur kursus' } } }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({ eleValidClass: '', rowSelector: '.validate' }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', e => {
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });

        instance.on('core.form.valid', () => {
          const isy_status = $(formAuthentication)
            .find('button[type="submit"][name="isy_status"][value="7"]')
            .is(':focus')
            ? '7'
            : '6';

          if (isy_status === '7') {
            Swal.fire({
              icon: 'question',
              title: 'Hantar permohonan?',
              showCancelButton: true,
              confirmButtonText: 'Ya',
              cancelButtonText: 'Batal',
              customClass: {
                title: 'm-0',
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
              },
              buttonsStyling: false
            }).then(result => {
              if (result.isConfirmed) {
                performAjaxSubmission(isy_status);
              }
            });
          } else {
            performAjaxSubmission(isy_status);
          }
        });
      }
    });
  }

  function performAjaxSubmission(statusValue) {
    const formData = $(formAuthentication).serializeArray();
    let statusFound = false;
    for (let i = 0; i < formData.length; i++) {
      if (formData[i].name === 'isy_status') {
        formData[i].value = statusValue;
        statusFound = true;
        break;
      }
    }
    if (!statusFound) {
      formData.push({ name: 'isy_status', value: statusValue });
    }

    $.ajax({
      data: $.param(formData),
      url: 'isytihar',
      type: 'POST',
      success: () => {
        Swal.fire({
          title:
            $('#isy_id').val() == ''
              ? 'Berjaya ditambah!'
              : statusValue == 6
                ? 'Berjaya dikemaskini!'
                : 'Berjaya dihantar!',
          icon: 'success',
          customClass: {
            title: 'm-0',
            confirmButton: 'btn btn-primary waves-effect waves-light'
          },
          buttonsStyling: false
        }).then(() => {
          table.ajax.reload();
          $('#manageRecord').modal('hide');
        });
      }
    });
  }

  // Modal Cleanup
  $('#manageRecord').on('hide.bs.modal', function () {
    if (fv) fv.resetForm(true);
    $('#courseForm')[0].reset();
    $('#courseForm input').prop('readonly', false);
  });
});
