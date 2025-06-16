/**
 * urusetia-kursus
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration
  var dt_table = $('.datatables'),
    statusObj = {
      0: { title: 'Tidak Aktif', badge: 'bg-label-danger' },
      1: { title: 'Aktif', badge: 'bg-label-success' }
    };

  // Katalog Kursus datatable
  if (dt_table.length) {
    var table = dt_table.DataTable({
      ajax: {
        url: '/kursus',
        type: 'GET',
        data: function (d) {
          return $.extend({}, d, {
            filter: $('#filter').val()
          });
        }
      },
      columns: [
        { data: 'kur_id' },
        { data: 'kur_nama' },
        { data: 'kur_tkhmula' },
        { data: 'epro_kategori.kat_keterangan' },
        { data: 'kur_tkhtutup' },
        { data: '' }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          render: function (data, type, full, meta) {
            return '<span>' + (meta.row + 1) + '</span>';
          }
        },
        {
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span class="view-record text-uppercase">${data}</span>`;
          }
        },
        {
          targets: 2,
          render: function (data, type, full, meta) {
            const rawDate = data;

            if (type === 'display') {
              const [y, m, d] = rawDate.split('-');
              return `${d}/${m}/${y}`;
            }

            return rawDate;
          }
        },

        {
          targets: 3,
          autoWidth: false,
          render: function (data, type, full, meta) {
            return `<span class="badge bg-label-warning" style="white-space: normal;">${data}</span>`;
          }
        },
        {
          targets: 4,
          render: function (data, type, full, meta) {
            const rawDate = data;

            if (type === 'display') {
              const [y, m, d] = rawDate.split('-');
              return `${d}/${m}/${y}`;
            }

            return rawDate;
          }
        },
        {
          // Actions
          targets: -1,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block text-nowrap">' +
              `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.kur_id} data-bs-toggle="tooltip" title="Mohon"><i class="ti ti-send ti-md"></i></button>` +
              '</div>'
            );
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
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"l>>' +
        '>t' +
        '<"row"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      lengthMenu: [10, 25, 50, 100], //for length of menu
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
      drawCallback: function () {
        // Initialize tooltip
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });
      }
    });
    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');
  }

  // Filter form control to default size
  // ? setTimeout used for multilingual table initialization
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // View record
  table.on('click', '.view-record', function () {
    const kur_id = $(this).data('id');

    $.get(`/kursus/${kur_id}`, function (data) {
      $('#kur_id').val(data.kur_id);
      $('#kur_nama').html(data.kur_nama);
      $('#kur_kategori').html(data.epro_kategori.kat_keterangan);
      $('#kur_tarikh').html(': ' + formatDate(data.kur_tkhmula) + ' hingga ' + formatDate(data.kur_tkhtamat));
      $('#kur_tempat').html(': ' + data.epro_tempat.tem_keterangan);
      $('#kur_bilpeserta').html(': ' + data.kur_bilpeserta);
      $('#kur_kumpulan').html(': ' + data.epro_kumpulan.kum_keterangan);
      $('#kur_penganjur').html(': ' + data.epro_penganjur.pjr_keterangan);
      $('#kur_objektif').html(data.kur_objektif);
    });

    $('#viewRecord').modal('show');
  });

  // Apply record
  $('.apply-record').on('click', function () {
    const kur_id = $('#kur_id').val();
    console.log($('#courseForm').serializeArray());

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
          data: $('#courseForm').serialize(),
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
              window.location.href = '/';
            });
          }
        });
      }
    });
  });

  // Format date to DD/MM/YYYY
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }
});
