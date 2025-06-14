/**
 *  Pages Authentication
 */

'use strict';
const formAuthentication = document.querySelector('#formAuthentication');

document.addEventListener('DOMContentLoaded', function (e) {
  (function () {
    // Form validation for Add new record
    if (formAuthentication) {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          name: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan nama'
              }
            }
          },
          email: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan emel'
              },
              emailAddress: {
                message: 'Emel tidak sah'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Sila masukkan kata laluan'
              }
            }
          },
          confirm_password: {
            validators: {
              notEmpty: {
                message: 'Sila sahkan kata laluan'
              },
              identical: {
                compare: function () {
                  return formAuthentication.querySelector('[name="password"]').value;
                },
                message: 'Kata laluan tidak sepadan'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleValidClass: '',
            rowSelector: '.mb-6'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),

          defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', function (e) {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });
    }
  })();
});
