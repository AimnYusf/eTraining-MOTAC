/**
 *  Profil
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          pen_nama: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan nama penuh'
              }
            }
          },
          pen_nokp: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan no. kad pengenalan'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Hanya nombor dibenarkan tanpa (-)'
              },
              stringLength: {
                max: 12,
                message: 'Nombor mestilah tidak lebih 12 aksara'
              }
            }
          },
          pen_jantina: {
            validators: {
              notEmpty: {
                message: 'Sila pilih jantina'
              }
            }
          },
          pen_emel: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan emel'
              },
              emailAddress: {
                message: 'Emel tidak sah'
              }
            }
          },
          pen_notel: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan no. telefon'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Hanya nombor'
              },
              stringLength: {
                max: 12,
                message: 'Nombor mestilah tidak lebih 12 aksara'
              }
            }
          },
          pen_nohp: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan no. telefon bimbit'
              },
              regexp: {
                regexp: /^[0-9]+$/,
                message: 'Hanya nombor'
              },
              stringLength: {
                max: 12,
                message: 'Nombor mestilah tidak lebih 12 aksara'
              }
            }
          },
          pen_idbahagian: {
            validators: {
              notEmpty: {
                message: 'Sila pilih bahagian'
              }
            }
          },
          pen_jawatan: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan jawatan'
              }
            }
          },
          pen_gred: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan gred'
              }
            }
          },
          pen_idkumpulan: {
            validators: {
              notEmpty: {
                message: 'Sila pilih kumpulan'
              }
            }
          },
          pen_idjabatan: {
            validators: {
              notEmpty: {
                message: 'Sila pilih jabatan'
              }
            }
          },
          pen_kjemel: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan emel ketua jabatan'
              }
            }
          },
          pen_ppnama: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan nama pegawai penyokong'
              }
            }
          },
          pen_ppemel: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan emel pegawai penyokong'
              }
            }
          },
          pen_ppgred: {
            validators: {
              notEmpty: {
                message: 'Sila pilih gred pegawai penyokong'
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

          // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
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
              data: $('#formAuthentication').serialize(),
              url: '/profil',
              type: 'POST',
              success: function () {
                Swal.fire({
                  title: 'Kemaskini Berjaya!',
                  icon: 'success',
                  customClass: {
                    title: 'm-0',
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                  },
                  buttonsStyling: false
                }).then(result => {
                  window.location.href = '/profil';
                });
              }
            });
          });
        }
      });
    }
  })();
});
