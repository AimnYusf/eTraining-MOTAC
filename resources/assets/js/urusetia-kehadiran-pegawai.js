// resources/assets/js/urusetia-kehadiran-pegawai.js
'use strict';

$(function () {
  const dtTable = $('#attendanceTable');
  const kur_id = $('#kur_id').val();
  let dataTable;

  // Initialize flatpickr for the attendance date input
  const attendanceDateInput = document.querySelector('#keh_tkhmasuk');
  if (attendanceDateInput) {
    flatpickr(attendanceDateInput, {
      dateFormat: 'd/m/Y'
    });
  }

  let isProcessingScan = false;
  let html5QrCode = null; // Declare html5QrCode here so it's accessible globally within the scope

  // Handles successful QR code scans
  function onScanSuccess(decodedText) {
    if (isProcessingScan) {
      return;
    }

    isProcessingScan = true;

    $('#keh_idusers').selectpicker('val', decodedText);
    recordAttendance();
  }

  // Function to start the QR code reader
  function startQrReader() {
    if (!html5QrCode) {
      html5QrCode = new Html5Qrcode('reader');
    }

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
  }

  // Function to stop the QR code reader
  function stopQrReader() {
    if (html5QrCode && html5QrCode.isScanning) {
      html5QrCode
        .stop()
        .then(() => {
          console.log('QR scanning stopped.');
        })
        .catch(err => {
          console.error('Failed to stop QR scanning.', err);
        });
    }
  }

  // Attach event listeners to the collapse element
  $('#crudCollapse').on('shown.bs.collapse', function () {
    // When the collapse section is shown, start the QR reader
    startQrReader();
  });

  $('#crudCollapse').on('hidden.bs.collapse', function () {
    // When the collapse section is hidden, stop the QR reader
    stopQrReader();
  });

  // Generates dynamic date columns for the DataTable
  function generateDateColumns(startDateStr, endDateStr) {
    const dateColumns = [];
    const current = new Date(startDateStr);
    const last = new Date(endDateStr);

    while (current <= last) {
      const isoDate = current.toISOString().split('T')[0];
      const displayDate = current.toLocaleDateString('ms-MY', { day: '2-digit', month: '2-digit', year: 'numeric' });

      dateColumns.push({
        title: displayDate,
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
            body: function (inner, rowData, columnIdx) {
              const attendances = rowData.epro_pengguna.epro_kehadiran || [];
              const columnHeader = dataTable.column(columnIdx).header().textContent;
              const parts = columnHeader.split('/');
              const exportIsoDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
              const attended = attendances.some(item => item.keh_tkhmasuk === exportIsoDate);
              return attended ? '1' : '0';
            }
          }
        }
      });
      current.setDate(current.getDate() + 1);
    }
    return dateColumns;
  }

  const kur_tkhmula = $('#kur_tkhmula').val();
  const kur_tkhtamat = $('#kur_tkhtamat').val();
  const dynamicDateColumns = generateDateColumns(kur_tkhmula, kur_tkhtamat);

  // Initialize DataTable for "Papar Kehadiran" tab
  if (dtTable.length) {
    dataTable = dtTable.DataTable({
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
        { data: 'epro_pengguna.etra_kumpulan.kum_ketpenu', visible: false, title: 'Kumpulan' },
        {
          data: 'epro_pengguna.pen_jantina',
          visible: false,
          title: 'Jantina',
          exportOptions: {
            format: {
              body: function (data) {
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
        <"card-header d-flex rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start"
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
          className: 'btn btn-label-primary waves-effect waves-light border-none me-2',
          text: '<i class="ti ti-file-spreadsheet ti-xs me-sm-1"></i> <span class="d-none d-sm-inline-block">Excel</span>',
          exportOptions: {
            columns: ':visible, :hidden',
            format: {
              body: function (data, rowIdx, colIdx) {
                const column = dataTable.column(colIdx);
                const columnDataSrc = column.dataSrc();
                const rowData = dataTable.row(rowIdx).data();

                if (columnDataSrc === 'epro_pengguna.pen_jantina') {
                  return rowData.epro_pengguna.pen_jantina === 1
                    ? 'Lelaki'
                    : rowData.epro_pengguna.pen_jantina === 2
                      ? 'Perempuan'
                      : '';
                }

                const columnTitle = column.header().textContent;
                const kurTkhMula = new Date($('#kur_tkhmula').val());
                const kurTkhTamat = new Date($('#kur_tkhtamat').val());
                let currentDate = new Date(kurTkhMula);
                let isDynamicDateCol = false;

                while (currentDate <= kurTkhTamat) {
                  const displayDate = currentDate.toLocaleDateString('ms-MY', {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                  });
                  if (columnTitle === displayDate) {
                    isDynamicDateCol = true;
                    break;
                  }
                  currentDate.setDate(currentDate.getDate() + 1);
                }

                if (isDynamicDateCol) {
                  const attendances = rowData.epro_pengguna.epro_kehadiran || [];
                  const parts = columnTitle.split('/');
                  const isoDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                  const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
                  return attended ? '1' : '0';
                }

                return data;
              },
              header: function (data, columnIdx) {
                return dataTable.column(columnIdx).header().textContent;
              }
            }
          }
        },
        // Add the "Rekod Baru" button here
        {
          text: '<i class="ti ti-plus me-1"></i> <span class="d-none d-sm-inline-block">Rekod Baru</span>',
          className: 'btn btn-primary',
          action: function () {
            $('#crudCollapse').collapse('toggle'); // Toggles the collapse section
          }
        }
      ],
      drawCallback: () => {
        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => new bootstrap.Tooltip(el));
      }
    });

    $('.dataTables_length').addClass('mx-n2');
    $('.dt-buttons').addClass('d-flex flex-wrap mb-6 mb-sm-0');

    setTimeout(() => {
      $('.dataTables_filter .form-control').removeClass('form-control-sm');
      $('.dataTables_length .form-select').removeClass('form-select-sm');
    }, 300);
  }

  $('#submit-form').on('click', recordAttendance);

  function recordAttendance() {
    const formData = $('#kehadiranForm').serialize();
    $.ajax({
      url: 'kehadiran',
      type: 'POST',
      data: formData,
      success: function () {
        Swal.fire({
          title: 'Berjaya!',
          icon: 'success',
          timer: 2500,
          timerProgressBar: true,
          customClass: {
            title: 'm-0',
            confirmButton: 'btn btn-primary waves-effect waves-light'
          },
          buttonsStyling: false
        }).then(() => {
          dataTable.ajax.reload();
          isProcessingScan = false;
        });
      },
      error: function (xhr) {
        Swal.fire({
          title: 'Ralat!',
          text: 'Gagal merekod kehadiran.',
          icon: 'error'
        });
        console.error('Attendance record error:', xhr.responseText);
        isProcessingScan = false;
      }
    });
  }

  // Handle toggle all checkboxes in a row based on the row checkbox
  document.querySelectorAll('.select-row-checkbox').forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
      const userId = this.getAttribute('data-user-id');
      const rowCheckboxes = document.querySelectorAll(`.attendance-checkbox[data-user-id="${userId}"]`);
      rowCheckboxes.forEach(cb => (cb.checked = this.checked));
    });
  });

  // Clicking on column 0 or 1 toggles the row checkbox
  document.querySelectorAll('.pilih-seluruh-ruangan').forEach(function (cell) {
    cell.addEventListener('click', function (e) {
      if (e.target.tagName.toLowerCase() === 'input') return;

      const userId = this.getAttribute('data-user-id');
      const checkbox = document.querySelector(`.select-row-checkbox[data-user-id="${userId}"]`);
      if (checkbox) {
        checkbox.checked = !checkbox.checked;
        checkbox.dispatchEvent(new Event('change'));
      }
    });
  });

  // Optional: Console log for selected checkboxes when submitting the "Isi Kehadiran" form
  const attendanceForm = document.getElementById('attendanceForm');
  const courseName = document.getElementById('courseName')?.value ?? '';

  attendanceForm?.addEventListener('submit', function () {
    const selected = [];
    attendanceForm.querySelectorAll('.attendance-checkbox').forEach(box => {
      if (box.checked) {
        const row = box.closest('tr');
        const name = row?.querySelector('.participant-name')?.value ?? '';
        selected.push({
          kur_nama: courseName,
          pen_nama: name,
          selected_date_column: box.dataset.date
        });
      }
    });
    console.log('Collected Attendance Data for submission:', selected);
  });
});
