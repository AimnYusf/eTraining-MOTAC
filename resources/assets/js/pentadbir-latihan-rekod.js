/**
 * Urusetia Tempat
 */

'use strict';

$(function () {
  const dt_table = $('.datatables');
  let table;

  // Initialize DataTable
  if (dt_table.length) {
    table = dt_table.DataTable({
      ajax: {
        url: '/rekod-pegawai',
        type: 'GET'
      },
      columns: [
        { data: '' },
        { data: 'nama' },
        { data: 'jawatan' },
        { data: 'gred' },
        { data: 'kumpulan' },
        { data: 'jumlah_hari' },
        { data: 'jumlah_hari' }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          className: 'text-center',
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        },
        {
          targets: 1,
          render: (data, type, full) =>
            `<span class="text-uppercase view-record" style="cursor: pointer"  data-id="${full.id}" data-bs-toggle="tooltip" title="Papar Perincian">${data}</span>`
        },
        {
          targets: [2, 3],
          className: 'text-center',
          width: '10%'
        },
        {
          target: 4,
          className: 'text-center',
          width: '10%',
          render: function (data) {
            const map = {
              JUSA: 'JUSA',
              'Pengurusan & Profesional': 'P&P',
              Pelaksana: 'P'
            };
            return map[data];
          }
        },
        {
          target: 5,
          className: 'text-center',
          width: '10%',
          render: data => `<span class="badge bg-label-danger">${data}</span>`
        },
        {
          // progress
          targets: -1,
          className: 'text-center',
          width: '30%',
          render: function (data, type, full, meta) {
            var $peratus = (data / 5) * 100;
            var $color = $peratus < 40 ? 'danger' : $peratus > 80 ? 'success' : 'warning';
            return `
              <div class="d-flex align-items-center">
                <div class="progress w-100" style="height: 10px;">
                  <div class="progress-bar progress-bar-striped progress-bar-animated bg-${$color}" role="progressbar" style="width: ${$peratus}%;"></div>
                </div>
              </div>
            `;
          }
        }
      ],
      dom: `
        <"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"
          <"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>
          <"d-flex justify-content-start justify-content-md-end align-items-baseline"
            <"dt-action-buttons mt-6 mb-6"B>
          >
        >
      `,
      paging: false,
      language: {
        sLengthMenu: '_MENU_',
        search: '',
        searchPlaceholder: 'Carian'
      },
      buttons: [
        {
          extend: 'collection',
          className: 'btn btn-label-primary dropdown-toggle waves-effect waves-light border-none',
          text: '<i class="ti ti-file-export ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">Eksport</span>',
          buttons: [
            {
              extend: 'print',
              text: '<i class="ti ti-printer me-1" ></i>Cetak',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5]
              },
              title: '<h4 class="text-uppercase fw-bold" style="text-align: center;">Rekod Pegawai</h4>'
            },
            {
              extend: 'excel',
              text: '<i class="ti ti-file-spreadsheet me-1"></i>Excel',
              className: 'dropdown-item',
              exportOptions: {
                columns: [1, 2, 3, 4, 5]
              }
            }
          ]
        }
      ],
      drawCallback: function () {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
          new bootstrap.Tooltip(el);
        });
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');
  }

  // Remove small sizing from filter controls
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);

  // View Record
  $(document).on('click', '.view-record', function () {
    const pen_id = $(this).data('id');
    console.log(pen_id);

    // Use URLSearchParams for clean and safe URL parameter handling
    const url = new URL('/rekod-pegawai', window.location.origin);
    url.searchParams.set('pid', pen_id);

    window.location.href = url.toString();
  });
});
