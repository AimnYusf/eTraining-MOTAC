'use strict';

$(function () {
  const dtTable = $('.datatables');
  const kur_id = $('#kur_id').val();
  let table;

  // Initialize flatpickr for the attendance date input
  const kehTkhmasukElement = document.querySelector('#keh_tkhmasuk');
  if (kehTkhmasukElement) {
    flatpickr(kehTkhmasukElement, {
      dateFormat: 'd/m/Y'
    });
  }

  // Handles successful QR code scans
  let isProcessingScan = false;

  function onScanSuccess(decodedText) {
    if (isProcessingScan) {
      return;
    }

    isProcessingScan = true;

    $('#keh_idusers').selectpicker('val', decodedText);
    recordAttendance();
  }

  // Initialize Html5Qrcode for QR code scanning
  const html5QrCode = new Html5Qrcode('reader');
  html5QrCode
    .start(
      { facingMode: 'environment' },
      {
        fps: 10,
        qrbox: 250
      },
      onScanSuccess
    )
    .catch(err => {
      console.error('QR scanning error:', err);
    });

  function generateDateColumns(start, end) {
    const dateColumns = [];
    const current = new Date(start);
    const last = new Date(end);

    while (current <= last) {
      const isoDate = current.toISOString().split('T')[0];
      const display = current.toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' });

      dateColumns.push({
        title: display,
        data: null,
        className: 'text-center',
        render: function (data, type, row) {
          const attendances = row.epro_pengguna.epro_kehadiran || [];
          const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
          return attended
            ? '<span class="badge badge-center rounded-pill bg-success"><i class="ti ti-check"></i></span>'
            : '<span class="badge badge-center rounded-pill bg-danger"><i class="ti ti-x"></i></span>';
        },
        exportOptions: {
          format: {
            body: function (inner, row, column) {
              const attendances = row.epro_pengguna.epro_kehadiran || [];
              const displayDate = table.column(column).header().textContent;

              // Convert to YYYY-MM-DD for comparison
              const parts = displayDate.split('/');
              const isoDate = `${parts[2]}-${parts[1]}-${parts[0]}`;

              const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
              return attended ? '1' : '0';
            }
          }
        }
      });

      current.setDate(current.getDate() + 1);
    }

    return dateColumns;
  }

  // Get course start and end dates from hidden inputs
  const kur_tkhmula = $('#kur_tkhmula').val();
  const kur_tkhtamat = $('#kur_tkhtamat').val();
  const dynamicDateColumns = generateDateColumns(kur_tkhmula, kur_tkhtamat);

  // Initialize DataTable if the element exists
  if (dtTable.length) {
    table = dtTable.DataTable({
      ajax: {
        url: `/urusetia/kehadiran?kid=${kur_id}`,
        type: 'GET',
        data: d => ({
          ...d,
          filter: $('#filter').val()
        })
      },
      columns: [
        { data: 'per_id' },
        { data: 'epro_pengguna.pen_nama' },
        { data: 'epro_pengguna.epro_kumpulan.kum_ketpenu', visible: false, title: 'Kumpulan' }, // Added title for export
        {
          data: 'epro_pengguna.pen_jantina',
          visible: false,
          title: 'Jantina', // Added title for export
          exportOptions: {
            format: {
              body: function (data, rowIdx, colIdx, node) {
                // Convert 1 to 'Lelaki' and 2 to 'Perempuan'
                return data === 1 ? 'Lelaki' : data === 2 ? 'Perempuan' : '';
              }
            }
          }
        },
        ...dynamicDateColumns
      ],
      columnDefs: [
        {
          targets: 0,
          searchable: false,
          className: 'text-center',
          render: (data, type, full, meta) => `${meta.row + 1}`
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
            // Include ALL columns, regardless of visibility
            columns: ':visible, :hidden',
            format: {
              body: function (data, rowIdx, colIdx, node) {
                const column = table.column(colIdx);
                const columnData = column.dataSrc(); // Get the data source of the column

                // Check if it's the 'pen_jantina' column
                if (columnData === 'epro_pengguna.pen_jantina') {
                  const rowData = table.row(rowIdx).data();
                  const jantinaValue = rowData.epro_pengguna.pen_jantina;
                  return jantinaValue === 1 ? 'Lelaki' : jantinaValue === 2 ? 'Perempuan' : '';
                }

                // Check if it's one of the dynamic date columns
                // We need to compare column titles for dynamic columns
                const columnTitle = column.header().textContent;
                const kurTkhMula = new Date($('#kur_tkhmula').val());
                const kurTkhTamat = new Date($('#kur_tkhtamat').val());
                const current = new Date(kurTkhMula);
                let isDynamicDateColumn = false;

                while (current <= kurTkhTamat) {
                  const display = current.toLocaleDateString('ms-MY', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                  });
                  if (columnTitle === display) {
                    isDynamicDateColumn = true;
                    break;
                  }
                  current.setDate(current.getDate() + 1);
                }

                if (isDynamicDateColumn) {
                  const rowData = table.row(rowIdx).data();
                  const attendances = rowData.epro_pengguna.epro_kehadiran || [];
                  const parts = columnTitle.split('/');
                  const isoDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                  const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
                  return attended ? '1' : '0';
                }

                return data; // For other columns, return the original data
              },
              // For header, ensure hidden columns get their title
              header: function (data, columnIdx, node) {
                const column = table.column(columnIdx);
                return column.header().textContent;
              }
            }
          }
        }
      ],
      drawCallback: () => {
        const tooltipElements = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipElements.forEach(el => new bootstrap.Tooltip(el));
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');

    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  }

  // request record attendance
  $('#submit-form').on('click', recordAttendance);

  // function to send an AJAX request
  function recordAttendance() {
    const formData = $('#kehadiranForm').serialize();
    $.ajax({
      url: 'kehadiran',
      type: 'POST',
      data: formData,
      success: function () {
        Swal.fire({
          title: 'Berjaya !',
          icon: 'success',
          timer: 2500,
          timerProgressBar: true,
          customClass: {
            title: 'm-0',
            confirmButton: 'btn btn-primary waves-effect waves-light'
          },
          buttonsStyling: false
        }).then(() => {
          table.ajax.reload();
          isProcessingScan = false;
        });
      },
      error: function (xhr) {
        Swal.fire({
          title: 'Ralat!',
          text: 'Gagal merekod kehadiran.',
          icon: 'error'
        });
        console.error(xhr.responseText);
      }
    });
  }
});
