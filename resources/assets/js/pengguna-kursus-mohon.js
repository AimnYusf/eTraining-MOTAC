'use strict';

$(function () {
  // Apply record
  $('.apply-record').on('click', function () {
    const kur_id = $(this).data('id');

    Swal.fire({
      icon: 'question',
      title: 'Teruskan permohonan?',
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
          data: {
            kur_id: kur_id
          },
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: '/kursus',
          type: 'POST',
          success: function () {
            Swal.fire({
              icon: 'success',
              title: 'Permohonan Berjaya!',
              customClass: {
                title: 'm-0',
                confirmButton: 'btn btn-primary waves-effect waves-light'
              }
            }).then(function (result) {
              window.location.href = '/kursus';
            });
          }
        });
      }
    });
  });
});
