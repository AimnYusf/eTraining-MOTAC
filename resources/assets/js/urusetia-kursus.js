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

  // E-commerce Products datatable

  if (dt_table.length) {
    var table = dt_table.DataTable({
      ajax: {
        url: '/urusetia/kursus',
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
        { data: 'epro_kategori.kat_keterangan' },
        { data: 'kur_tkhmula' },
        { data: 'kur_tkhtutup' },
        { data: 'kur_status' },
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
            return `<span class="view-record text-uppercase" style="cursor: pointer;" data-bs-toggle="tooltip" title="Lihat" data-id="${full.kur_id}" >${data}</span>`;
          }
        },
        {
          targets: 2,
          autoWidth: false,
          render: function (data, type, full, meta) {
            return `<span class="badge bg-label-warning"  style="white-space: normal;">${data}</span>`;
          }
        },
        {
          targets: 3,
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
          targets: 5,
          render: function (data, type, full, meta) {
            const { title, badge } = statusObj[data];
            return `<span class="badge ${badge} mt-2 mb-2 table-badges">${title}</span>`;
          }
        },
        {
          // Actions
          targets: 6,
          title: 'Actions',
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block text-nowrap">' +
              `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.kur_id} data-bs-toggle="tooltip" title="Lihat"><i class="ti ti-eye ti-md"></i></button>` +
              `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light edit-record" data-id=${full.kur_id} data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit ti-md"></i></button>` +
              '</div>'
            );
          }
        },
        {
          targets: [0, 2, 3, 4, 5, 6],
          className: 'text-center'
        }
      ],
      dom:
        '<"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"' +
        '<"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>' +
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>>' +
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
      // Buttons
      buttons: [
        {
          text: '<i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span class="d-none d-sm-inline-block">Rekod Baru</span>',
          className: 'add-new btn btn-primary ms-2 ms-sm-0 waves-effect waves-light',
          action: function () {
            window.location.href = getUrl('?');
          }
        }
      ],
      initComplete: function () {
        // Adding date filter once table initialized
        const api = this.api();

        // Add date filter inputs
        $('.tarikh_kursus').html(`
          <div class="d-flex gap-2">
            <input type="text" id="minDate" class="form-control" placeholder="Tarikh Mula (DD/MM/YYYY)">
            <input type="text" id="maxDate" class="form-control" placeholder="Tarikh Tamat (DD/MM/YYYY)">
          </div>
        `);

        // Init Flatpickr with sync min/max
        const minPicker = flatpickr('#minDate', {
          dateFormat: 'd/m/Y',
          onChange: ([date]) => maxPicker.set('minDate', date || null)
        });
        const maxPicker = flatpickr('#maxDate', {
          dateFormat: 'd/m/Y',
          onChange: ([date]) => minPicker.set('maxDate', date || null)
        });

        // Re-filter table on date change
        // $('#minDate, #maxDate').on('change', () => api.draw());
        $('#minDate, #maxDate').on('change', function () {
          api.draw();
          displayClearButton();
        });

        // Convert dd/mm/yyyy to Date
        const parseDate = str => {
          if (!str) return null;
          const [d, m, y] = str.split('/');
          return new Date(`${y}-${m}-${d}`);
        };

        // Add custom filter to DataTables
        $.fn.dataTable.ext.search.push((settings, data) => {
          const min = parseDate($('#minDate').val());
          const max = parseDate($('#maxDate').val());
          const date = parseDate(data[3]); // Adjust index if needed

          if (!date) return false;
          if (min && date < min) return false;
          if (max && date > max) return false;
          return true;
        });

        // Adding category filter once table initialized
        this.api()
          .columns(2)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="filterKategori" class="selectpicker w-100" data-style="btn-default" title="Kategori"></select>'
            )
              .appendTo('.kategori_kursus')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
                displayClearButton();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + d + '">' + d + '</option>');
              });
          });

        // Adding status filter once table initialized
        this.api()
          .columns(-2)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="filterStatus" class="selectpicker w-100" data-style="btn-default" title="Status"></select>'
            )
              .appendTo('.status_kursus')
              .on('change', function () {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
                displayClearButton();
              });

            column
              .data()
              .unique()
              .sort()
              .each(function (d, j) {
                select.append('<option value="' + statusObj[d].title + '">' + statusObj[d].title + '</option>');
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

  // Clear filter button functionality
  $('.clear-filter').on('click', function () {
    // Reset date fields
    $('#minDate').val('');
    $('#maxDate').val('');

    // Reset selectpickers
    $('#filterStatus').selectpicker('val', '');
    $('#filterKategori').selectpicker('val', '');

    $('.datatables').DataTable().search('').columns().search('').draw();

    displayClearButton();
  });

  function displayClearButton() {
    const hasStatus = $('#filterStatus').val();
    const hasKategori = $('#filterKategori').val();
    const hasMinDate = $('#minDate').val();
    const hasMaxDate = $('#maxDate').val();

    if (hasStatus || hasKategori || hasMinDate || hasMaxDate) {
      $('.clear-filter').removeClass('d-none');
    } else {
      $('.clear-filter').addClass('d-none');
    }
  }

  // View record
  table.on('click', '.view-record', function () {
    const kur_id = $(this).data('id');

    $.get(`/urusetia/kursus/${kur_id}`, function (data) {
      $('#kur_nama').html(data.kur_nama);
      $('#kur_kategori').html(data.epro_kategori.kat_keterangan);
      $('#kur_tarikh').html(': ' + formatDate(data.kur_tkhmula) + ' hingga ' + formatDate(data.kur_tkhtamat));
      $('#kur_tempat').html(': ' + data.epro_tempat.tem_keterangan);
      $('#kur_bilpeserta').html(': ' + data.kur_bilpeserta);
      $('#kur_kumpulan').html(': ' + data.epro_kumpulan.kum_keterangan);
      $('#kur_penganjur').html(': ' + data.epro_penganjur.pjr_keterangan);
      $('#kur_objektif').html(data.kur_objektif);

      $('.btn-close-modal').removeClass('d-none');
      $('#viewRecord').modal('show');
    });
  });

  // Edit record
  table.on('click', '.edit-record', function () {
    const kur_id = $(this).data('id');
    window.location.href = getUrl(kur_id);
  });

  // Format date to DD/MM/YYYY
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }
});
