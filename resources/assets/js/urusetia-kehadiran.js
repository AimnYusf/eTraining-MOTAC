'use strict';

$(function () {
  const dtTable = $('.datatables');

  // Initialize DataTable
  if (dtTable.length) {
    const table = dtTable.DataTable({
      ajax: {
        url: '/urusetia/permohonan',
        type: 'GET',
        data: d => ({
          ...d,
          filter: $('#filter').val()
        })
      },
      columns: [
        { data: 'kur_id' },
        { data: 'kur_nama' },
        { data: 'etra_kategori.kat_keterangan' },
        { data: 'kur_tkhmula' },
        { data: 'kur_tkhtamat' },
        { data: '' }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        },
        {
          targets: 1,
          render: function (data, type, full, meta) {
            return `<span class="text-uppercase cursor-pointer view-record" data-id=${full.kur_id} data-bs-toggle="tooltip" title="Lihat">${data}</span>`;
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
          // Actions
          targets: -1,
          searchable: false,
          orderable: false,
          render: function (data, type, full, meta) {
            return (
              '<div class="d-inline-block text-nowrap">' +
              `<button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.kur_id} data-bs-toggle="tooltip" title="Lihat"><i class="ti ti-eye ti-md"></i></button>` +
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
        '<"d-flex justify-content-start justify-content-md-end align-items-baseline"' +
        '<"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"l>>' +
        '>t' +
        '<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
      lengthMenu: [10, 25, 50, 100],
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
        const api = this.api();

        // --- Helper Functions (defined at the top for scope) ---
        // Helper function to parse YYYY-MM-DD strings (for raw table data)
        const parseDateFromYMD = str => {
          if (!str) return null;
          // Directly create Date object from YYYY-MM-DD string
          return new Date(str);
        };

        // Helper function to parse DD/MM/YYYY strings (for Flatpickr inputs)
        const parseDateFromDMY = str => {
          if (!str) return null;
          const [d, m, y] = str.split('/');
          return new Date(`${y}-${m}-${d}`);
        };
        // --- End Helper Functions ---

        // --- Month Filter ---
        const months = [
          'Januari',
          'Februari',
          'Mac',
          'April',
          'Mei',
          'Jun',
          'Julai',
          'Ogos',
          'September',
          'Oktober',
          'November',
          'Disember'
        ];

        $('.bulan_kursus').html(`
        <select id="filterMonth" class="selectpicker w-100" data-style="btn-default" title="Bulan">
          <option value="">Semua Bulan</option> ${months.map((month, index) => `<option value="${index + 1}">${month}</option>`).join('')}
        </select>
    `);

        $('#filterMonth').on('change', function () {
          api.draw(); // This triggers all $.fn.dataTable.ext.search functions
          displayClearButton();
        });

        // Add custom month filter to DataTables
        $.fn.dataTable.ext.search.push((settings, data) => {
          const selectedMonth = parseInt($('#filterMonth').val(), 10);
          const dateString = data[3]; // 'kur_tkhmula' column (raw YYYY-MM-DD)

          // If "Semua Bulan" is selected or value is invalid, show all rows
          if (isNaN(selectedMonth)) {
            // Using isNaN as value is "" for "All Months"
            return true;
          }

          // Parse the raw date from 'YYYY-MM-DD' format
          if (dateString) {
            const [year, month, day] = dateString.split('-'); // Raw data is YYYY-MM-DD
            const recordMonth = parseInt(month, 10);
            return recordMonth === selectedMonth;
          }
          return false; // If dateString is empty or invalid for a specific month filter
        });
        // --- End Month Filter ---

        // --- Year Filter ---
        const currentYear = new Date().getFullYear();
        const years = [];
        for (let i = currentYear - 2; i <= currentYear + 2; i++) {
          years.push(i);
        }

        $('.tahun_kursus').html(`
        <select id="filterYear" class="selectpicker w-100" data-style="btn-default" title="Tahun">
          <option value="">Semua Tahun</option>
          ${years.map(year => `<option value="${year}">${year}</option>`).join('')}
        </select>
    `);

        $('#filterYear').on('change', function () {
          api.draw(); // This triggers all $.fn.dataTable.ext.search functions
          displayClearButton();
        });

        // Add custom year filter to DataTables
        $.fn.dataTable.ext.search.push((settings, data) => {
          // console.log('Year filter is running'); // This log should now appear!

          const selectedYear = parseInt($('#filterYear').val(), 10);
          const dateString = data[3]; // 'kur_tkhmula' column (raw YYYY-MM-DD)
          // console.log('Raw dateString:', dateString, 'Selected Year:', selectedYear);

          // If "Semua Tahun" is selected or value is invalid, show all rows
          if (isNaN(selectedYear)) {
            // Using isNaN as value is "" for "All Years"
            return true;
          }

          // Parse the raw date from 'YYYY-MM-DD' format
          if (dateString) {
            const [y, m, d] = dateString.split('-'); // Raw data is YYYY-MM-DD
            const recordYear = parseInt(y, 10);
            return recordYear === selectedYear;
          }
          return false; // If dateString is empty or invalid for a specific year filter
        });
        // --- End Year Filter ---

        // --- Date Range Filter ---
        $('.tarikh_kursus').html(`
        <div class="d-flex gap-2">
          <input type="text" id="minDate" class="form-control" placeholder="Tarikh Mula (DD/MM/YYYY)">
          <input type="text" id="maxDate" class="form-control" placeholder="Tarikh Tamat (DD/MM/YYYY)">
        </div>
    `);

        // Init Flatpickr with sync min/max
        const minPicker = flatpickr('#minDate', {
          dateFormat: 'd/m/Y', // User input format
          onChange: ([date]) => maxPicker.set('minDate', date || null)
        });
        const maxPicker = flatpickr('#maxDate', {
          dateFormat: 'd/m/Y', // User input format
          onChange: ([date]) => minPicker.set('maxDate', date || null)
        });

        $('#minDate, #maxDate').on('change', function () {
          api.draw(); // This triggers all $.fn.dataTable.ext.search functions
          displayClearButton();
        });

        // Add custom date range filter to DataTables
        $.fn.dataTable.ext.search.push((settings, data) => {
          // Parse inputs from Flatpickr (DD/MM/YYYY)
          const min = parseDateFromDMY($('#minDate').val());
          const max = parseDateFromDMY($('#maxDate').val());
          // Parse raw table data (YYYY-MM-DD)
          const date = parseDateFromYMD(data[3]); // Column index for 'kur_tkhmula' (raw YYYY-MM-DD)

          if (!date) return false;
          if (min && date < min) return false;
          if (max && date > max) return false;
          return true;
        });
        // --- End Date Range Filter ---

        // Bootstrap Select
        $('.selectpicker').selectpicker();
      },
      drawCallback: function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');

    // Clear filter button functionality
    $('.clear-filter').on('click', function () {
      // Reset date fields
      $('#minDate').val('');
      $('#maxDate').val('');

      // Reset selectpickers
      $('#filterMonth').selectpicker('val', '');
      $('#filterYear').selectpicker('val', '');

      $('.datatables').DataTable().search('').columns().search('').draw();

      displayClearButton();
    });

    function displayClearButton() {
      const hasMonth = $('#filterMonth').val();
      const hasYear = $('#filterYear').val();
      const hasMinDate = $('#minDate').val();
      const hasMaxDate = $('#maxDate').val();

      if (hasMonth || hasYear || hasMinDate || hasMaxDate) {
        $('.clear-filter').removeClass('d-none');
      } else {
        $('.clear-filter').addClass('d-none');
      }
    }

    // Bind view record click
    table.on('click', '.view-record', function () {
      const kurId = $(this).data('id');
      window.location.href = `/urusetia/kehadiran?kid=${kurId}`;
    });
  }

  // Normalize form controls for multilingual compatibility
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
