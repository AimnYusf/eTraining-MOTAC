/**
 * Urusetia Tempat
 */

'use strict';

$(function () {
  const dt_table = $('.datatables');
  let table;

  // Clear input fields
  function clearFormInputs() {
    $('#tem_id').val('');
    $('#tem_keterangan').val('');
    $('#tem_alamat').val('');
    $('#tem_gmaps').val('');
  }

  // Initialize DataTable
  if (dt_table.length) {
    table = dt_table.DataTable({
      ajax: {
        url: '/urusetia/tempat',
        type: 'GET'
      },
      columns: [{ data: 'tem_id' }, { data: 'tem_keterangan' }, { data: '' }],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          className: 'text-center',
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        },
        {
          targets: 1,
          render: (data, type, full) => `
            <span class="edit-record text-uppercase" 
              style="cursor: pointer;" 
              data-bs-toggle="tooltip" 
              title="Lihat" 
              data-id="${full.tem_id}">
              ${data}
            </span>`
        },
        {
          targets: 2,
          searchable: false,
          orderable: false,
          className: 'text-center',
          render: (data, type, full) => `
            <div class="d-inline-block text-nowrap">
              <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light edit-record" 
                data-id="${full.tem_id}" 
                data-bs-toggle="tooltip" 
                title="Edit">
                <i class="ti ti-edit ti-md"></i>
              </button>
            </div>`
        }
      ],
      dom: `
        <"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"
          <"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>
          <"d-flex justify-content-start justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>
          >
        >
        t
        <"row"
          <"col-sm-12 col-md-6"i>
          <"col-sm-12 col-md-6"p>
        >`,
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
          className: 'add-record btn btn-primary ms-2 ms-sm-0 waves-effect waves-light',
          action: () => {
            clearFormInputs();
            $('#tem_tajuk').html('Tambah Tempat Kursus');
            $('#manageRecord').modal('show');
          }
        }
      ],
      drawCallback: function () {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
          new bootstrap.Tooltip(el);
        });
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');
  }

  // Remove small sizing from filter controls
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // Edit Record
  $(document).on('click', '.edit-record', function () {
    const tem_id = $(this).data('id');

    $.get(`/urusetia/tempat/${tem_id}`, function (data) {
      $('#tem_tajuk').html('Edit Tempat Kursus');
      $('#tem_id').val(data.tem_id);
      $('#tem_keterangan').val(data.tem_keterangan);
      $('#tem_alamat').val(data.tem_alamat);
      $('#tem_gmaps').val(data.tem_gmaps);
      $('#manageRecord').modal('show');
    });
  });

  // Form Validation and Submission
  const courseLocationForm = document.querySelector('#courseLocationForm');

  if (courseLocationForm) {
    FormValidation.formValidation(courseLocationForm, {
      fields: {
        tem_keterangan: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan nama tempat'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.col-12'
        }),
        submitButton: new FormValidation.plugins.SubmitButton(),
        autoFocus: new FormValidation.plugins.AutoFocus()
      },
      init: instance => {
        instance.on('plugins.message.placed', function (e) {
          if (e.element.parentElement.classList.contains('input-group')) {
            e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
          }
        });

        instance.on('core.form.valid', function () {
          $.ajax({
            data: $('#courseLocationForm').serialize(),
            url: '/urusetia/tempat',
            type: 'POST',
            success: () => {
              Swal.fire({
                icon: 'success',
                title: $('#tem_id').val() == '' ? 'Berjaya Ditambah!' : 'Berjaya Dikemaskini!',
                customClass: {
                  title: 'm-0',
                  confirmButton: 'btn btn-primary waves-effect waves-light'
                }
              }).then(() => {
                $('#manageRecord').modal('hide');
                table.ajax.reload();
              });
            }
          });
        });
      }
    });
  }
});
