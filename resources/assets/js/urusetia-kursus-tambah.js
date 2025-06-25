'use strict';

(function () {
  // Flatpickr date fields
  const dateFields = ['#kur_tkhmula', '#kur_tkhtamat', '#kur_tkhbuka', '#kur_tkhtutup'];

  dateFields.forEach(selector => {
    const element = document.querySelector(selector);
    if (element) {
      flatpickr(element, {
        dateFormat: 'd/m/Y'
      });
    }
  });

  // Timepicker fields
  const timeFields = ['#kur_msamula', '#kur_msatamat'];

  timeFields.forEach(selector => {
    const $element = $(selector);
    if ($element.length) {
      $element.timepicker({
        showMeridian: false, // Use 24-hour format
        defaultTime: false, // Let user select time manually
        orientation: typeof isRtl !== 'undefined' && isRtl ? 'r' : 'l'
      });
    }
  });
})();

// Form validation
const formAuthentication = document.querySelector('#formAuthentication');
const quillObjektif = new Quill('#kur_objektif', {
  modules: {
    toolbar: '.objektif-toolbar'
  },
  theme: 'snow'
});

// Set initial content if exists
var oldValue = $('#kur_objektif_input').val();
if (oldValue) {
  quillObjektif.root.innerHTML = oldValue;
}

// Initialize dropzone for poster
const previewTemplate = `<div class="dz-preview dz-file-preview">
<div class="dz-details">
  <div class="dz-thumbnail">
    <img data-dz-thumbnail>
    <span class="dz-nopreview">No preview</span>
    <div class="dz-success-mark"></div>
    <div class="dz-error-mark"></div>
    <div class="dz-error-message"><span data-dz-errormessage></span></div>
    <div class="progress">
      <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" data-dz-uploadprogress></div>
    </div>
  </div>
  <div class="dz-filename" data-dz-name></div>
  <div class="dz-size" data-dz-size></div>
</div>
</div>`;

// ? Start your code from here

// Basic Dropzone

const dropzoneBasic = document.querySelector('#dropzone-basic');
let myDropzone;
if (dropzoneBasic) {
  myDropzone = new Dropzone(dropzoneBasic, {
    previewTemplate: previewTemplate,
    parallelUploads: 1,
    maxFilesize: 5,
    acceptedFiles: '.jpg,.jpeg,.png,.gif',
    addRemoveLinks: true,
    maxFiles: 1
  });
}

// Sync Quill content to hidden input
quillObjektif.on('text-change', function () {
  const html = quillObjektif.root.innerHTML.trim();
  document.querySelector('#kur_objektif_input').value = html;
});

document.addEventListener('DOMContentLoaded', function () {
  if (formAuthentication) {
    const fv = FormValidation.formValidation(formAuthentication, {
      fields: {
        kur_nama: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan nama kursus'
            }
          }
        },
        kur_tkhmula: {
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
        kur_msamula: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan masa mula'
            }
          }
        },
        kur_tkhtamat: {
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
        kur_msatamat: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan masa tamat'
            }
          }
        },
        kur_idtempat: {
          validators: {
            notEmpty: {
              message: 'Sila pilih tempat kursus'
            }
          }
        },
        kur_objektif: {
          validators: {
            callback: {
              message: '&nbsp',
              callback: function (input) {
                // Remove empty tags and check if it actually has content
                const content = input.value.replace(/<(.|\n)*?>/g, '').trim();

                if (content.length > 0) {
                  $('#objektifError').addClass('d-none');
                  return true;
                } else {
                  $('#objektifError').removeClass('d-none');
                  return false;
                }
              }
            }
          }
        },
        kur_poster: {
          validators: {
            callback: {
              message: 'Sila masukkan poster',
              callback: function () {
                return myDropzone.getAcceptedFiles().length > 0;
              }
            }
          }
        },
        kur_bilhari: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan bilangan hari'
            },
            integer: {
              message: 'Hanya nombor dibenarkan'
            }
          }
        },
        kur_bilpeserta: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan bilangan peserta'
            },
            integer: {
              message: 'Hanya nombor dibenarkan'
            }
          }
        },
        kur_idkategori: {
          validators: {
            notEmpty: {
              message: 'Sila pilih kategori kursus'
            }
          }
        },
        kur_idpenganjur: {
          validators: {
            notEmpty: {
              message: 'Sila pilih penganjur'
            }
          }
        },
        kur_idkumpulan: {
          validators: {
            notEmpty: {
              message: 'Sila pilih kumpulan pegawai'
            }
          }
        },
        kur_tkhbuka: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan tarikh buka permohonan'
            },
            date: {
              format: 'DD/MM/YYYY',
              message: 'Tarikh tidak sah'
            }
          }
        },
        kur_tkhtutup: {
          validators: {
            notEmpty: {
              message: 'Sila masukkan tarikh tutup permohonan'
            },
            date: {
              format: 'DD/MM/YYYY',
              message: 'Tarikh tidak sah'
            }
          }
        },
        kur_status: {
          validators: {
            notEmpty: {
              message: 'Sila pilih status'
            }
          }
        }
      },
      plugins: {
        trigger: new FormValidation.plugins.Trigger(),
        bootstrap5: new FormValidation.plugins.Bootstrap5({
          eleValidClass: '',
          rowSelector: '.mb-4'
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
          function formatDate(input) {
            if (!input) return '';
            const parts = input.split('/');
            if (parts.length === 3) {
              return `${parts[2]}-${parts[1]}-${parts[0]}`; // YYYY-MM-DD
            }
            return input; // fallback
          }

          // Set converted date values back into the form fields
          $('#kur_tkhmula').val(formatDate($('#kur_tkhmula').val()));
          $('#kur_tkhtamat').val(formatDate($('#kur_tkhtamat').val()));
          $('#kur_tkhbuka').val(formatDate($('#kur_tkhbuka').val()));
          $('#kur_tkhtutup').val(formatDate($('#kur_tkhtutup').val()));

          // Optional: also convert hidden Quill content if you're using a hidden input
          $('#kur_objektif_input').val(quillObjektif.root.innerHTML);

          const formData = new FormData(formAuthentication);
          $.ajax({
            data: formData,
            url: 'kursus',
            type: 'POST',
            processData: false,
            contentType: false,
            success: function () {
              Swal.fire({
                title: $('#kur_id').val() ? 'Berjaya dikemaskini!' : 'Berjaya ditambah!',
                icon: 'success',
                customClass: {
                  title: 'm-0',
                  confirmButton: 'btn btn-primary waves-effect waves-light'
                },
                buttonsStyling: false
              }).then(result => {
                window.location.href = '/urusetia/kursus';
              });
            }
          });
        });
      }
    });

    // Trigger revalidation for selectpicker dropdowns
    ['kur_idtempat', 'kur_idkategori', 'kur_idpenganjur', 'kur_idkumpulan'].forEach(field => {
      document.getElementById(field).addEventListener('change', function (e) {
        fv.revalidateField(field);
      });
    });

    // Trigger revalidation for flatpickr
    ['kur_tkhmula', 'kur_tkhtamat', 'kur_tkhbuka', 'kur_tkhtutup'].forEach(field => {
      flatpickr(`#${field}`, {
        dateFormat: 'd/m/Y',
        onChange: () => {
          fv.revalidateField(field);
        }
      });
    });
  }
});
