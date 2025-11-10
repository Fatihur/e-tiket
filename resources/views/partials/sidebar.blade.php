<!-- Sidebar Start -->
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="{{ route('dashboard') }}" class="text-nowrap logo-img">
        <img src="{{ asset('assets/images/logos/dark-logo.svg') }}" width="180" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">MENU UTAMA</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('dashboard') }}" aria-expanded="false">
            <span>
              <i class="ti ti-layout-dashboard"></i>
            </span>
            <span class="hide-menu">Dashboard</span>
          </a>
        </li>

        @if(auth()->user()->isAdmin())
        <!-- Admin Menu -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">MANAJEMEN</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.users') }}" aria-expanded="false">
            <span>
              <i class="ti ti-users"></i>
            </span>
            <span class="hide-menu">Manajemen User</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.petugas.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-user-check"></i>
            </span>
            <span class="hide-menu">Manajemen Petugas</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.packages') }}" aria-expanded="false">
            <span>
              <i class="ti ti-package"></i>
            </span>
            <span class="hide-menu">Paket Wisata</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.bookings') }}" aria-expanded="false">
            <span>
              <i class="ti ti-ticket"></i>
            </span>
            <span class="hide-menu d-flex align-items-center justify-content-between">
              <span>Booking</span>
              @if(isset($pendingBookingsCount) && $pendingBookingsCount > 0)
                <span class="badge rounded-pill bg-warning text-dark ms-2" style="font-size: 0.7rem; min-width: 20px; padding: 2px 6px;">{{ $pendingBookingsCount }}</span>
              @endif
            </span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">LAPORAN</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.reports') }}" aria-expanded="false">
            <span>
              <i class="ti ti-file-description"></i>
            </span>
            <span class="hide-menu">Laporan Penjualan</span>
          </a>
        </li>
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">SISTEM</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('admin.settings.index') }}" aria-expanded="false">
            <span>
              <i class="ti ti-settings"></i>
            </span>
            <span class="hide-menu">Pengaturan</span>
          </a>
        </li>
        @endif

        @if(auth()->user()->isPetugas())
        <!-- Petugas Menu -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">VALIDASI TIKET</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('petugas.scanner') }}" aria-expanded="false">
            <span>
              <i class="ti ti-qrcode"></i>
            </span>
            <span class="hide-menu">Scanner QR Code</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('petugas.validated.tickets') }}" aria-expanded="false">
            <span>
              <i class="ti ti-list-check"></i>
            </span>
            <span class="hide-menu">Riwayat Scan</span>
          </a>
        </li>
        @endif

        @if(auth()->user()->isBendahara())
        <!-- Bendahara Menu -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">KEUANGAN</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('bendahara.transactions') }}" aria-expanded="false">
            <span>
              <i class="ti ti-receipt"></i>
            </span>
            <span class="hide-menu">Transaksi</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('bendahara.reports') }}" aria-expanded="false">
            <span>
              <i class="ti ti-chart-bar"></i>
            </span>
            <span class="hide-menu">Laporan Keuangan</span>
          </a>
        </li>
        @endif

        @if(auth()->user()->isOwner())
        <!-- Owner Menu -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">ANALISIS</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('owner.reports') }}" aria-expanded="false">
            <span>
              <i class="ti ti-report"></i>
            </span>
            <span class="hide-menu">Laporan Penjualan</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('owner.package.analysis') }}" aria-expanded="false">
            <span>
              <i class="ti ti-chart-pie"></i>
            </span>
            <span class="hide-menu">Analisis Paket</span>
          </a>
        </li>
        @endif

        <!-- Common Menu -->
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">LAINNYA</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="{{ route('landing.index') }}" target="_blank" aria-expanded="false">
            <span>
              <i class="ti ti-world"></i>
            </span>
            <span class="hide-menu">Lihat Website</span>
          </a>
        </li>
        <li class="sidebar-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="sidebar-link btn btn-link text-start w-100 text-decoration-none" style="padding: 0.75rem 1rem;">
              <span>
                <i class="ti ti-logout"></i>
              </span>
              <span class="hide-menu">Logout</span>
            </button>
          </form>
        </li>
      </ul>
    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>
<!--  Sidebar End -->


