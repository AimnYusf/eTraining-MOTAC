'use strict';

(function () {
  // Flatpickr date fields
  const dateFields = ['#isy_tkhmula', '#isy_tkhtamat'];

  dateFields.forEach(selector => {
    const element = document.querySelector(selector);
    if (element) {
      flatpickr(element, {
        dateFormat: 'd/m/Y'
      });
    }
  });

  // Form validation
  const formAddRecord = document.querySelector('#formAddRecord');

  document.addEventListener('DOMContentLoaded', function () {
    if (formAddRecord) {
      const fv = FormValidation.formValidation(formAddRecord, {
        fields: {
          isy_idusers: {
            validators: {
              notEmpty: {
                message: 'Sila pilih pegawai'
              }
            }
          },
          isy_nama: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan nama kursus'
              }
            }
          },
          isy_tkhmula: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan tarikh mula'
              },
              date: {
                format: 'DD/MM/YYYY',
                message: 'Tarikh tidak sah'
              }
            }
          },
          isy_tkhtamat: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan tarikh tamat'
              },
              date: {
                format: 'DD/MM/YYYY',
                message: 'Tarikh tidak sah'
              }
            }
          },
          isy_tempat: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan tempat kursus'
              }
            }
          },
          isy_anjuran: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan penganjur kursus'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-5'
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
            // Convert dates from DD/MM/YYYY to YYYY-MM-DD
            function formatDate(dateStr) {
              const [day, month, year] = dateStr.split('/');
              return `${year}-${month}-${day}`;
            }

            // Set converted date values back into the form fields
            $('#isy_tkhmula').val(formatDate($('#isy_tkhmula').val()));
            $('#isy_tkhtamat').val(formatDate($('#isy_tkhtamat').val()));

            const formData = new FormData(formAddRecord);
            Swal.fire({
              icon: 'question',
              title: 'Tambah rekod pegawai?',
              showCancelButton: true,
              confirmButtonText: 'Ya',
              cancelButtonText: 'Batal',
              customClass: {
                title: 'm-0',
                confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                cancelButton: 'btn btn-label-secondary waves-effect waves-light'
              },
              buttonsStyling: false
            }).then(function (result) {
              if (result.value) {
                $.ajax({
                  data: formData,
                  url: 'rekod-baru',
                  type: 'POST',
                  processData: false,
                  contentType: false,
                  success: function () {
                    Swal.fire({
                      title: 'Berjaya ditambah!',
                      icon: 'success',
                      customClass: {
                        title: 'm-0',
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                      },
                      buttonsStyling: false
                    }).then(result => {
                      location.reload();
                    });
                  }
                });
              }
            });
          });
        }
      });
    }
  });
})();
