/**
 * urusetia-kursus
 */

'use strict';

$(function () {
  // CSRF Token setup for all AJAX requests
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  const dtTable = $('.datatables');
  const kursusId = $('#kur_id').val();
  const statusObj = [
    'Menunggu Sokongan Pegawai Penyelia',
    'Menunggu Kelulusan Urusetia',
    'Tidak Disokong Pegawai Penyelia',
    'Berjaya',
    'Tidak Berjaya'
  ];

  // Format date from YYYY-MM-DD to DD/MM/YYYY
  const formatDate = dateStr => {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  };

  // Initialize DataTable
  if (dtTable.length) {
    const table = dtTable.DataTable({
      ajax: {
        url: `/urusetia/permohonan?kid=${kursusId}`,
        type: 'GET',
        data: d => ({
          ...d,
          filter: $('#filter').val()
        })
      },
      columns: [
        { data: 'per_id' },
        { data: 'epro_pengguna.pen_nama' },
        { data: 'epro_pengguna.pen_jawatan', visible: false },
        { data: 'epro_pengguna.epro_jabatan.jab_ketring' },
        { data: 'epro_pengguna.pen_nokp', visible: false },
        { data: 'epro_pengguna.pen_emel', visible: false },
        { data: 'per_tkhmohon' },
        { data: 'per_status' },
        { data: '' }
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
          render: (data, type, full) => `
            <span class="text-uppercase">
              ${data}
            </span>
          `
        },
        {
          targets: 2,
          render: (data, type, full) => `${full.epro_pengguna.pen_jawatan} / ${full.epro_pengguna.pen_gred}`
        },
        {
          targets: 3,
          className: 'text-center',
          render: (data, type, full) => {
            if (data === 'MOTAC') {
              return `${full.epro_pengguna.epro_bahagian.bah_ketpenu}`;
            }
            return data;
          }
        },
        {
          targets: -3,
          className: 'text-center',
          render: (data, type) => {
            return formatDate(data);
          }
        },
        {
          targets: -2,
          className: 'text-center',
          width: '20%',
          render: function (data, type, full, meta) {
            return `<span class="badge bg-label-${full.epro_status.stp_class}" style="white-space: normal;">${full.epro_status.stp_ketring}</span>`;
          }
        },
        {
          targets: -1,
          className: 'text-center',
          render: (data, type, full) => `
            <div class="d-inline-block">
              <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light view-record" data-id=${full.per_id} data-bs-toggle="tooltip" title="Papar Perincian Pengguna"><i class="ti ti-eye ti-md"></i></button>
              <a href="javascript:;" class="btn btn-sm btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="ti ti-dots-vertical ti-md"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-end m-0">
                <button class="update-record dropdown-item" data-id="${full.per_id}" data-status="4">Berjaya</button>
                <button class="update-record dropdown-item" data-id="${full.per_id}" data-status="5">Tidak Berjaya</button>
              </div>
            </div>
          `
        }
      ],
      dom: `
        <"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"
          <"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>
          <"d-flex justify-content-start justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"lB>
          >
        >t
        <"row"
          <"col-sm-12 col-md-6"i>
          <"col-sm-12 col-md-6"p>
        >
      `,
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
      buttons: [
        {
          extend: 'excel',
          className: 'btn btn-label-primary waves-effect waves-light border-none',
          text: '<i class="ti ti-file-spreadsheet ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">Excel</span>',
          exportOptions: {
            columns: [0, 1, 2, 3, 4, 5, 7]
          }
        }
      ],
      initComplete: function () {
        this.api()
          .columns(-2)
          .every(function () {
            var column = this;
            var select = $(
              '<select id="filterStatus" class="selectpicker" data-style="btn-default" title="Status"></select>'
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
      drawCallback: () => {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
      }
    });

    // Adjust DataTables UI spacing
    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');

    // View Record handler
    dtTable.on('click', '.view-record', function () {
      const permohonanId = $(this).data('id');

      $.get(`/urusetia/permohonan/${permohonanId}`, ({ kursus, pengguna, permohonan }) => {
        $('#per_id').val(permohonan.per_id);
        $('#kur_nama').text(kursus.kur_nama);
        $('#kur_tarikh').text(`${formatDate(kursus.kur_tkhmula)} hingga ${formatDate(kursus.kur_tkhtamat)}`);
        $('#kur_tempat').text(kursus.epro_tempat.tem_alamat);

        $('#pen_nama').text(pengguna.pen_nama);
        $('#pen_nokp').text(pengguna.pen_nokp);
        $('#pen_jawatan').text(`${pengguna.pen_jawatan} ${pengguna.pen_gred}`);
        $('#pen_agensi').text(pengguna.epro_jabatan.jab_ketpenu);
        $('#pen_bahagian').text(pengguna.epro_bahagian.bah_ketpenu);
        $('#pen_notel').text(pengguna.pen_notel);
        $('#pen_nohp').text(pengguna.pen_nohp);
        $('#pen_nofaks').text(pengguna.pen_nofaks);
        $('#pen_emel').text(pengguna.pen_emel);
        $('#per_tkhmohon').text(formatDate(permohonan.per_tkhmohon));

        $('#per_status').val(permohonan.per_status);
        $('#viewRecord').modal('show');
      });
    });

    // Update Record handler
    dtTable.on('click', '.update-record', function () {
      const perId = $(this).data('id');
      const status = $(this).data('status');
      updateRecord(perId, status);
    });

    $('#locationForm').on('submit', function (e) {
      e.preventDefault();
      const perId = $('#per_id').val();
      const status = $('#per_status').val();
      updateRecord(perId, status);
    });

    // Update record function
    const updateRecord = (id, status) => {
      $.ajax({
        url: `/urusetia/permohonan/${id}`,
        type: 'PUT',
        data: { per_status: status },
        success: () => {
          Swal.fire({
            title: 'Berjaya dikemaskini!',
            icon: 'success',
            customClass: {
              title: 'm-0',
              confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false
          }).then(() => {
            $('#viewRecord').modal('hide');
            table.ajax.reload();
          });
        }
      });
    };

    // Remove small class from DataTable form controls
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  }
});
