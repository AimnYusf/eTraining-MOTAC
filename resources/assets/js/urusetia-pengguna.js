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
  const roleObj = {
    user: { badge: 'bg-label-success', text: 'Pengguna' },
    supervisor: { badge: 'bg-label-info', text: 'Pegawai Latihan Bahagian' },
    administrator: { badge: 'bg-label-primary', text: 'Urusetia' }
  };

  // Initialize DataTable
  if (dtTable.length) {
    const table = dtTable.DataTable({
      ajax: {
        url: `/urusetia/pengguna`,
        type: 'GET',
        data: d => ({
          ...d,
          filter: $('#filter').val()
        })
      },
      columns: [
        { data: 'pen_id' },
        { data: 'pen_nama' },
        { data: 'pen_emel' },
        { data: 'epro_bahagian.bah_ketring' },
        { data: 'user.role' },
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
            <span class="text-uppercase"">
              ${data}
            </span>
          `
        },
        {
          targets: 3,
          className: 'text-center'
        },
        {
          targets: 4,
          className: 'text-center',
          render: (data, type, full) => {
            const badgeClass = roleObj[data].badge;
            const roleText = roleObj[data].text;
            return `<span class="badge ${badgeClass} mt-2 mb-2 table-badges">${roleText}</span>`;
          }
        },
        {
          targets: 5,
          className: 'text-center',
          render: (data, type, full) => `
            <div class="d-inline-block text-nowrap">
            <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light edit-record" data-id=${full.pen_id} data-bs-toggle="tooltip" title="Edit"><i class="ti ti-edit ti-md"></i></button>
            </div>
          `
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
    dtTable.on('click', '.edit-record', function () {
      const pen_id = $(this).data('id');

      $.get(`/urusetia/pengguna/${pen_id}`, data => {
        $('#pen_id').val(data.pen_id);
        $('#pen_nama').text(data.pen_nama);
        $('#pen_nokp').text(data.pen_nokp);
        $('#pen_jawatan').text(`${data.pen_jawatan} ${data.pen_gred}`);
        $('#pen_agensi').text(`${data.epro_jabatan.jab_ketpenu}, ${data.epro_jabatan.jab_ketring}`);
        $('#pen_bahagian').text(data.epro_bahagian.bah_ketring);
        $('#pen_notel').text(data.pen_notel);
        $('#pen_nohp').text(data.pen_nohp);
        $('#pen_emel').text(data.pen_emel);

        $('#role').val(data.user.role);
        $('#editRecord').modal('show');
      });
    });

    // Update Record handler
    $('#userForm').on('submit', function (e) {
      e.preventDefault();
      const id = $('#pen_id').val();
      const role = $('#role').val();
      $.ajax({
        url: `/urusetia/pengguna/${id}`,
        type: 'PUT',
        data: { role: role },
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
            $('#editRecord').modal('hide');
            table.ajax.reload();
          });
        }
      });
    });

    // Remove small class from DataTable form controls
    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  }
});
