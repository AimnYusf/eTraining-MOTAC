/**
 * Profil
 */

'use strict';

document.addEventListener('DOMContentLoaded', function (e) {
  // Get common elements
  const formAuthentication = document.querySelector('#formAuthentication');
  const jabatanSelect = document.getElementById('pen_idjabatan');
  const bahagianSelect = document.getElementById('pen_idbahagian');
  const bahagianInput = document.getElementById('pen_bahagianlain');

  // Elements for toggling visibility
  const bahagianSelectRow = document.getElementById('bahagianSelectRow');
  const bahagianInputRow = document.getElementById('bahagianInputRow');

  // Function to toggle visibility of Bahagian fields
  function toggleBahagianFields() {
    if (jabatanSelect.value === '1') {
      // Assuming '1' is the value for the specific Kementerian
      bahagianSelectRow.style.display = 'flex'; // Show select
      bahagianInputRow.style.display = 'none'; // Hide input
      bahagianInput.value = ''; // Clear input if it was visible
    } else {
      bahagianSelectRow.style.display = 'none'; // Hide select
      bahagianInputRow.style.display = 'flex'; // Show input

      // Clear selectpicker if it was visible and initialized
      if ($(bahagianSelect).data('selectpicker')) {
        $(bahagianSelect).selectpicker('val', '');
      }
    }
  }

  // Initial call to set the correct state on page load
  toggleBahagianFields();

  // Add event listener for changes to the Kementerian/Jabatan/Agensi select
  jabatanSelect.addEventListener('change', toggleBahagianFields);

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
        // Conditional validation for pen_idbahagian and pen_bahagianlain
        pen_idbahagian: {
          validators: {
            callback: {
              message: 'Sila pilih bahagian',
              callback: function (input) {
                const jabatanValue = jabatanSelect.value;
                // Validate pen_idbahagian only if pen_idjabatan is '1'
                return jabatanValue === '1' ? input.value !== '' : true;
              }
            }
          }
        },
        pen_bahagianlain: {
          validators: {
            callback: {
              message: 'Sila masukkan bahagian',
              callback: function (input) {
                const jabatanValue = jabatanSelect.value;
                // Validate pen_bahagianlain only if pen_idjabatan is NOT '1'
                return jabatanValue !== '1' ? input.value !== '' : true;
              }
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
            },
            regexp: {
              regexp:
                /^[a-zA-Z0-9._%+-]+@(tourism\.gov\.my|kraftangan\.gov\.my|aswara\.edu\.my|artgallery\.gov\.my|motac\.gov\.my|jkkn\.gov\.my|heritage\.gov\.my|matic\.gov\.my|istanabudaya\.gov\.my)$/,
              message: 'Emel mesti merupakan emel rasmi Kementerian/Jabatan/Agensi.'
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

    // Revalidate bahagian fields when pen_idjabatan changes (after fv is defined)
    jabatanSelect.addEventListener('change', function () {
      fv.revalidateField('pen_idbahagian');
      fv.revalidateField('pen_bahagianlain');
    });
  }
});
