'use strict';

// Datatable (jquery)
$(function () {
  function formatDate(dateStr) {
    const [year, month, day] = dateStr.split('-');
    return `${day}/${month}/${year}`;
  }

  var table = $('.data-list').DataTable({
    ajax: {
      url: '/kursus',
      type: 'GET',
      dataSrc: function (json) {
        // Check if data is empty
        if (!json.data || json.data.length === 0) {
          $('#no-data-message').show();
          $('.course-table').hide();
        } else {
          $('#no-data-message').hide();
          $('.course-table').show();
        }
        return json.data;
      }
    },
    columns: [
      {
        data: 'category',
        render: function (data, type, row) {
          return `
          <div class="card p-2 h-100 shadow-none border">
            <div class="rounded-2 text-center mb-4" style="aspect-ratio: 1 / 1.414; width: 100%; max-width: 600px; margin: auto;">
              <a href="">
                <img class="img-fluid w-100 h-100 object-fit-cover" src="${row.kur_poster}" alt="tutor image 1" />
              </a>
            </div>
            <div class="card-body p-4 pt-2">
              <h5>${row.kur_nama}</h5>
              <hr>
              <h6 class="mb-1 fw-bold">
                <i class="ti ti-calendar-event me-2 align-top"></i> Tarikh
              </h6>
              <p>${formatDate(row.kur_tkhmula)} - ${formatDate(row.kur_tkhtamat)}</p>
              <h6 class="mb-1 fw-bold">
                <i class="ti ti-user-cog me-2 align-top"></i> Anjuran
              </h6>
              <p>${row.epro_penganjur.pjr_keterangan}</p>
              <a class="w-100 btn btn-label-primary d-flex align-items-center" href="/kursus?kid=${row.kur_id}">
                <span class="me-2">Maklumat Lanjut</span>
                <i class="ti ti-chevron-right ti-xs scaleX-n1-rtl"></i>
              </a>
            </div>
          </div>
          `;
        }
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
    pageLength: 4,
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
});
