'use strict';

$(function () {
  // Variables
  const dateFields = ['#isy_tkhmula', '#isy_tkhtamat'];
  const dt_table = $('.datatables');
  const statusObj = ['Baru', 'Pengesahan', 'Tidak Lulus', 'Berjaya', 'Tidak Berjaya', 'KIV'];
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
          render: data => `<span class="text-uppercase">${data}</span>`
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
            `<span class="badge bg-label-${full.epro_status.stp_class}" style="white-space: normal;">${full.epro_status.stp_ketring}</span>`
        },
        {
          targets: -1,
          searchable: false,
          orderable: false,
          render: (data, type, full) =>
            `<div class="d-inline-block text-nowrap">
              <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.isy_id} data-bs-toggle="tooltip" title="Lihat">
                <i class="ti ti-eye ti-md"></i>
              </button>
            </div>`
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
            $('#isy_tajuk').html('Tambah Rekod Kursus');
            $('.close-btn').html('Batal');
            $('.submit-btn').removeClass('d-none');
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
              '<select id="filterStatus" class="selectpicker" data-style="btn-default" title="Status"></select>'
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

  // View Record
  table.on('click', '.view-record', function () {
    const isy_id = $(this).data('id');

    $.get(`/isytihar/${isy_id}`, data => {
      dateFields.forEach(selector => {
        const instance = $(selector)[0]._flatpickr;
        if (instance) instance.destroy();
      });

      ['isy_nama', 'isy_tkhmula', 'isy_tkhtamat', 'isy_jam', 'isy_tempat', 'isy_anjuran', 'isy_kos'].forEach(field => {
        const value = ['isy_tkhmula', 'isy_tkhtamat'].includes(field) ? formatDate(data[field]) : data[field];
        $(`#${field}`).val(value).prop('readonly', true);
      });

      $('#isy_tajuk').html('Maklumat Kursus');
      $('.close-btn').html('Tutup');
      $('.submit-btn').addClass('d-none');
      $('#manageRecord').modal('show');
    });
  });

  // Form Validation & Submission
  if (formAuthentication) {
    fv = FormValidation.formValidation(formAuthentication, {
      fields: {
        isy_nama: {
          validators: {
            notEmpty: { message: 'Sila masukkan nama kursus' }
          }
        },
        isy_tkhmula: {
          validators: {
            notEmpty: { message: 'Sila pilih tarikh mula kursus' }
          }
        },
        isy_tkhtamat: {
          validators: {
            notEmpty: { message: 'Sila pilih tarikh tamat kursus' }
          }
        },
        isy_tempat: {
          validators: {
            notEmpty: { message: 'Sila masukkan tempat kursus' }
          }
        },
        isy_anjuran: {
          validators: {
            notEmpty: { message: 'Sila masukkan penganjur kursus' }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.validate'
        }),
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
          $.ajax({
            data: $(formAuthentication).serialize(),
            url: 'isytihar',
            type: 'POST',
            success: () => {
              Swal.fire({
                title: 'Berjaya ditambah!',
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
