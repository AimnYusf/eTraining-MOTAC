'use strict';

// Datatable (jquery)
$(function () {
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }
  function getPageLengthByResolution() {
    return window.innerWidth <= 1440 ? 6 : 8;
  }

  var table = $('.data-list').DataTable({
    ajax: {
      url: '/kursus',
      type: 'GET',
      dataSrc: function (json) {
        // Check if no data was returned
        if (!json.data || json.data.length === 0) {
          $('#no-data-message').show();
          $('.course-table').hide();
        }

        // Always return the data array (even if empty)
        return json.data;
      }
    },
    order: [[1, 'desc']],
    columns: [
      {
        data: null,
        render: function (data, type, row) {
          const today = new Date();
          const releaseDate = new Date(row.kur_tkhbuka);
          const closeDate = new Date(row.kur_tkhtutup);

          let statusText = '';
          let statusClass = '';

          if (today > closeDate) {
            statusText = 'Tutup';
            statusClass = 'bg-danger';
          } else if (today < releaseDate) {
            statusText = 'Belum Dibuka';
            statusClass = 'inactive-status bg-danger';
          } else {
            statusText = 'Dibuka';
            statusClass = 'active-status bg-success';
          }

          let dateText =
            data.kur_tkhmula === data.kur_tkhtamat
              ? formatDate(data.kur_tkhmula)
              : `${formatDate(data.kur_tkhmula)} hingga ${formatDate(data.kur_tkhtamat)}`;

          return `
          <style>
            .badge-status {
              font-size: 0.9rem;
              padding: 0.5em 1em;
              border-radius: 1rem;
              transition: all 0.3s ease-in-out;
              display: inline-block;
              position: relative;
            }

            .active-status {
              color: white;
              animation: pulse 1.5s infinite;
            }

            .inactive-status {
              color: white;
              opacity: 0.7;
              animation: fadein 0.5s;
            }

            @keyframes pulse {
              0% {
                transform: scale(1);
              }
              70% {
                transform: scale(1.1);
              }
              100% {
                transform: scale(1);
              }
            }

            @keyframes fadein {
              from {
                opacity: 0;
              }
              to {
                opacity: 0.7;
              }
            }
          </style>

          <div class="card shadow-lg border-0 h-100 d-flex flex-column p-0" data-status="${statusText}">
            <div class="position-relative rounded-top overflow-hidden" style="aspect-ratio: 1 / 1.414; width: 100%; max-width: 600px; margin: auto;">
              <a href="/kursus?kid=${row.kur_id}">
                <img src="${row.kur_poster}" alt="${row.kur_nama}" class="img-fluid w-100 h-100 object-fit-cover transition" style="transform: scale(1); transition: transform 0.3s ease-in-out;">
              </a>
              <span class="badge badge-status ${statusClass} position-absolute top-0 start-0 m-2 px-3 py-2 shadow-sm fs-6">${statusText}</span>
            </div>

            <div class="card-body d-flex flex-column p-4">
              <h6 class="fw-bold text-primary text-uppercase mb-0">${row.kur_nama}</h6>
              <hr class="my-3">
              
              <div class="mb-3">
                <h6 class="mb-1 text-muted"><i class="ti ti-calendar-event me-2 text-primary"></i>Tarikh</h6>
                <p class="mb-0 fw-bold">${dateText}</p>
              </div>

              <div class="mb-3">
                <h6 class="mb-1 text-muted"><i class="ti ti-user-cog me-2 text-primary"></i>Anjuran</h6>
                <p class="mb-0 fw-bold">${row.etra_penganjur.pjr_keterangan}</p>
              </div>

              <div class="mt-auto">
                <a class="btn btn-primary w-100 d-flex align-items-center justify-content-center gap-2" href="/kursus?kid=${row.kur_id}">
                  <span>Maklumat Lanjut</span>
                  <i class="ti ti-chevron-right"></i>
                </a>
              </div>
            </div>
          </div>
          `;
        }
      },
      {
        data: 'kur_tkhmula',
        visible: false,
        searchable: false
      }
    ],
    dom:
      '<"row mb-5"' +
      '<"col-md-2"<"ms-n2">>' +
      '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-6 mb-md-0 mt-n6 mt-md-0">>' +
      '>t' +
      '<"row"' +
      '<"col-sm-12 col-md-6"i>' +
      '<"col-sm-12 col-md-6"p>' +
      '>',
    pageLength: getPageLengthByResolution(),
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
      // Remove the default thead
      $('.data-list thead').remove();

      var api = this.api();
      const targetContainer = $('.status_kursus').length ? $('.status_kursus') : $('.custom-filter-container');
      const statusFilterDropdown = $(`
    <select id="statusFilter" class="selectpicker" data-style="btn-default">
      <option value="">Semua Status</option>
      <option value="Dibuka">Dibuka</option>
      <option value="Belum Dibuka">Belum Dibuka</option>
      <option value="Tutup">Tutup</option>
    </select>
  `);

      statusFilterDropdown.appendTo(targetContainer).on('change', function () {
        api.draw();
      });

      // Set "Semua Status" as selected and trigger a draw immediately on load
      statusFilterDropdown.val('').trigger('change');

      $('.selectpicker').selectpicker();

      // --- Check for no data after each draw ---
      api.on('draw.dt', function () {
        if (api.rows({ filter: 'applied' }).count() === 0) {
          $('#no-data-message').show();
          $('.course-table').hide();
        } else {
          $('#no-data-message').hide();
          $('.course-table').show();
        }
      });
    },
    rowCallback: function (row, data, index) {
      $(row)
        .find('td')
        .each(function () {
          $(this).contents().appendTo($(row));
        });
      $(row).find('td').remove();
      $(row).addClass('mb-6');
    }
  });

  // Custom filtering for the data-status attribute
  $.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
    // Ensure this filter only applies to the specific DataTables instance
    if (settings.nTable !== $('.data-list')[0]) {
      return true;
    }

    var statusFilter = $('#statusFilter').val();
    var rowNode = settings.aoData[dataIndex].nTr;
    var rowStatus = $(rowNode).find('.card').data('status');

    // If "Semua Status" is selected (empty string) OR the row's status matches the filter
    if (statusFilter === '' || rowStatus === statusFilter) {
      return true; // Show the row
    }

    return false; // Hide the row
  });
});
