<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link d-flex align-items-center justify-content-center">
        <span class="brand-text font-weight-light"><i class="fab fa-laravel fa-2x"></i>
            {{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p> Home </p>
                    </a>
                </li>
                <li class="nav-header">Koperasi</li>
                <li class="nav-item">
                    <a href="{{ route('pinjaman.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-money-bill-alt"></i>
                        <p> Pinjaman </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('simpanan.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p> Simpanan </p>
                    </a>
                </li>
                @if (auth()->user()->is_admin)
                <li class="nav-item">
                    <a href="{{ route('anggota.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p> Anggota </p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>