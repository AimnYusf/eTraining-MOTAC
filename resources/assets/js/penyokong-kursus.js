/** Pegawai Penyokong **/

import Swal from 'sweetalert2';

('use strict');

// $(document).ready(function () {
//   $.ajaxSetup({
//     headers: {
//       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });

//   //login button
//   $('.log-in').on('click', function () {
//     // window.location.href = '/';
//     console.log($('.needs-validation').serializeArray());
//   });

//   //validation
//   var forms = document.querySelectorAll('.needs-validation');

//   Array.prototype.slice.call(forms).forEach(function (form) {
//     form.addEventListener(
//       'submit',
//       function (event) {
//         if (!form.checkValidity()) {
//           event.preventDefault();
//           event.stopPropagation();
//         } else {
//           event.preventDefault();
//         }
//         form.classList.add('was-validated');
//       },
//       false
//     );
//   });
// });

const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          per_status: {
            validators: {
              notEmpty: {
                message: 'Sila pilih tindakan'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-3'
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
            Swal.fire({
              icon: 'question',
              title: 'Teruskan pengesahan?',
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
                  data: $('#formAuthentication').serialize(),
                  url: '/pengesahan',
                  type: 'POST',
                  success: function () {
                    Swal.fire({
                      icon: 'success',
                      title: 'Pengesahan Berjaya!',
                      customClass: {
                        title: 'm-0',
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                      }
                    });
                  }
                });
              }
            });
          });
        }
      });
    }
  })();
});
