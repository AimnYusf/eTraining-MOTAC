/**
 * urusetia-kursus
 */

'use strict';

$(function () {
  // Initialize DataTable
  const dtTable = $('.datatables');
  const kur_id = $('#kur_id').val();

  // Generate date range columns
  function generateDateColumns(start, end) {
    const dateColumns = [];
    const current = new Date(start);
    const last = new Date(end);

    while (current <= last) {
      const isoDate = current.toISOString().split('T')[0];
      const display = current.toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: '2-digit' });

      dateColumns.push({
        title: display,
        data: null,
        className: 'text-center',
        render: function (data, type, row) {
          const attendances = row.user.epro_kehadiran || [];
          const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
          return attended
            ? '<span class="badge bg-label-success" style="white-space: normal;">1</span>'
            : '<span class="badge bg-label-danger" style="white-space: normal;">1</span>';
        }
      });

      current.setDate(current.getDate() + 1);
    }

    return dateColumns;
  }

  const kur_tkhmula = $('#kur_tkhmula').val();
  const kur_tkhtamat = $('#kur_tkhtamat').val();
  const dynamicDateColumns = generateDateColumns(kur_tkhmula, kur_tkhtamat);

  if (dtTable.length) {
    const table = dtTable.DataTable({
      ajax: {
        url: `/urusetia/kehadiran?kid=${kur_id}`,
        type: 'GET',
        data: d => ({
          ...d,
          filter: $('#filter').val()
        })
      },
      columns: [{ data: 'per_id' }, { data: 'user.name' }, ...dynamicDateColumns],

      columnDefs: [
        {
          targets: 0,
          searchable: false,
          className: 'text-center',
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        }
      ],
      dom: `
        <"card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"
          <"me-5 ms-n4 pe-5 mb-n6 mb-md-0"f>
          <"d-flex justify-content-start justify-content-md-end align-items-baseline"
            <"dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-4 gap-sm-0 flex-sm-row"l>
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
        $('#kur_tarikh').text(`${kursus.kur_tkhmula} hingga ${kursus.kur_tkhtamat}`);
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
        $('#per_tkhmohon').text(permohonan.per_tkhmohon);

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
