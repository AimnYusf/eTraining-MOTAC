@php
  use Illuminate\Support\Facades\Auth;
  use Illuminate\Support\Facades\Route;
  $containerNav = $containerNav ?? 'container-fluid';
  $navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
@if(isset($navbarDetached) && $navbarDetached == 'navbar-detached')
  <nav
    class="layout-navbar {{$containerNav}} navbar navbar-expand-xl {{$navbarDetached}} align-items-center bg-navbar-theme"
    id="layout-navbar">
  @endif
  @if(isset($navbarDetached) && $navbarDetached == '')
    <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="{{$containerNav}}">
  @endif

      <!-- ! Not required for layout-without-menu -->
      @if(!isset($navbarHideToggle))
      <div
      class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0{{ isset($menuHorizontal) ? ' d-xl-none ' : '' }} {{ isset($contentNavbar) ? ' d-xl-none ' : '' }}">
      <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
        <i class="ti ti-menu-2 bx-md"></i>
      </a>
      </div>
    @endif

      <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
        <!-- Filter -->
        <div class="navbar-nav align-items-center">
          <div class="nav-item d-flex align-items-center">
            <select id="role_filter" class="form-select">
              <option value="guest" {{ Auth::user()->role == 'guest' ? 'selected' : '' }}>Pengguna Baru</option>
              <option value="user" {{ Auth::user()->role == 'user' ? 'selected' : '' }}>Pengguna</option>
              <option value="supervisor" {{ Auth::user()->role == 'supervisor' ? 'selected' : '' }}>Pegawai Latihan
                Bahagian</option>
              <option value="administrator" {{ Auth::user()->role == 'administrator' ? 'selected' : '' }}>Urusetia
              </option>
            </select>
          </div>
        </div>
        <!-- /Filter -->
        <ul class="navbar-nav flex-row align-items-center ms-auto">
          <!-- User -->
          <li class="nav-item navbar-dropdown dropdown-user dropdown">
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
              <i class="ti ti-settings ti-md ms-2"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li>
                <a class="dropdown-item" href="/profil">
                  <i class="ti ti-user me-3 ti-md"></i><span class="align-middle">Profil</span>
                </a>
              </li>
              <li>
                <div class="d-grid px-2 pt-2 pb-1">
                  <a class="btn btn-sm btn-danger d-flex" href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                    <small class="align-middle">Log Keluar</small>
                    <i class="ti ti-login ms-2 ti-14px"></i>
                  </a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                  </form>
                </div>
              </li>
            </ul>
          </li>
          <!--/ User -->
        </ul>
      </div>

      @if(!isset($navbarDetached))
    </div>
  @endif
  </nav>
  <!-- / Navbar -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $('#role_filter').on('change', function () {
      let filter = $(this).val();

      $.ajax({
        type: 'PUT',
        url: '/update-role',
        data: {
          role: filter,
          _token: '{{ csrf_token() }}'
        },
        success: function (response) {
          window.location.href = '/';
        },
        error: function (xhr) {
          alert('Failed to update role.');
        }
      });
    })
  </script>