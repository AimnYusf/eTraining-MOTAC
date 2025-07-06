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
          const attendances = row.user.epro_kehadiran || [];
          const attended = attendances.some(item => item.keh_tkhmasuk === isoDate);
          return attended
            ? '<span class="badge badge-center rounded-pill bg-success"><i class="ti ti-check"></i></span>'
            : '<span class="badge badge-center rounded-pill bg-danger"><i class="ti ti-x"></i></span>';
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
