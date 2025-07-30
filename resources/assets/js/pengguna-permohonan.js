/**
 * urusetia-kursus
 */

'use strict';

// Datatable (jquery)
$(function () {
  // Variable declaration
  var dt_table = $('.datatables');

  const statusObj = [];

  window.statusData.forEach(item => {
    statusObj.push(item.stp_keterangan);
  });

  // Status Permohonan datatable
  if (dt_table.length) {
    var table = dt_table.DataTable({
      ajax: {
        url: '/permohonan',
        type: 'GET'
      },
      columns: [
        { data: 'per_id' },
        { data: 'epro_kursus.kur_nama' },
        { data: 'per_tkhmohon' },
        { data: 'per_status' },
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
            return `<span class="text-uppercase cursor-pointer view-record" data-id=${full.epro_kursus.kur_id} data-bs-toggle="tooltip" title="Papar Perincian Kursus">${data}</span>`;
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
          width: '20%',
          render: function (data, type, full, meta) {
            return `<span class="badge bg-label-${full.etra_status.stp_class}" style="white-space: normal;">${full.etra_status.stp_keterangan}</span>`;
          }
        },
        {
          // Actions
          targets: -1,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block text-nowrap">' +
              `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.epro_kursus.kur_id} data-bs-toggle="tooltip" title="Papar Perincian Kursus"><i class="ti ti-eye ti-md"></i></button>` +
              '</div>'
            );
          }
        },
        {
          targets: [0, 2, 3, 4],
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
      initComplete: function () {
        this.api()
          .columns(3)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="filterStatus" class="selectpicker" data-style="btn-default" title="Status"><option value="">Semua</option></select>'
            )
              .appendTo('.dt-action-buttons')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + statusObj[d - 1] + '">' + statusObj[d - 1] + '</option>');
              });
          });

        // Bootstrap Select
        $('.selectpicker').selectpicker();
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
      let dateText =
        data.kur_tkhmula === data.kur_tkhtamat
          ? formatDate(data.kur_tkhmula)
          : `${formatDate(data.kur_tkhmula)} hingga ${formatDate(data.kur_tkhtamat)}`;

      $('#kur_id').val(data.kur_id);
      $('#kur_nama').html(data.kur_nama);
      $('#kur_kategori').html(data.etra_kategori.kat_keterangan);
      $('#kur_tarikh').html(`: ${dateText}`);
      $('#kur_tempat').html(`: ${data.etra_tempat.tem_keterangan}`);
      $('#kur_bilpeserta').html(`: ${data.kur_bilpeserta}`);
      $('#kur_kumpulan').html(`: ${data.etra_kumpulan.kum_ketpenu}`);
      $('#kur_penganjur').html(`: ${data.etra_penganjur.pjr_keterangan}`);
      $('#kur_objektif').html(data.kur_objektif);

      $('.btn-close-modal').removeClass('d-none');
      $('#viewRecord').modal('show');
    });
  });

  // Format date to DD/MM/YYYY
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }
});
