/**
 * urusetia-kursus
 */

'use strict';

$(function () {
  const dtTable = $('.datatables');

  // Utility: Format date from YYYY-MM-DD to DD/MM/YYYY
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }

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
        { data: 'epro_tempat.tem_keterangan' },
        { data: 'kur_tkhmula' },
        { data: 'kur_tkhtutup' }
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          render: (data, type, full, meta) => `<span>${meta.row + 1}</span>`
        },
        {
          targets: 1,
          render: (data, type, full) =>
            `<span class="view-record" style="cursor: pointer;" data-bs-toggle="tooltip" title="Lihat" data-id="${full.kur_id}">${data}</span>`
        },
        {
          targets: 3,
          render: (data, type) =>
            type === 'display'
              ? `<span class="badge bg-label-success my-1" style="white-space: normal;">${formatDate(data)}</span>`
              : data
        },
        {
          targets: 4,
          render: (data, type) =>
            type === 'display'
              ? `<span class="badge bg-label-danger" style="white-space: normal;">${formatDate(data)}</span>`
              : data
        },
        {
          targets: [0, 2, 3, 4],
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
      drawCallback: function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');

    // Bind view record click
    table.on('click', '.view-record', function () {
      const kurId = $(this).data('id');
      window.location.href = getUrl(kurId);
    });
  }

  // Normalize form controls for multilingual compatibility
  setTimeout(() => {
    $('.dataTables_filter .form-control').removeClass('form-control-sm');
    $('.dataTables_length .form-select').removeClass('form-select-sm');
  }, 300);
});
