<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="/admin/dashboard" class="brand-link">
        <span class="brand-icon"><i class="fas fa-cash-register"></i></span>
        <span class="brand-text">Kasir Pintar</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-header">Menu Utama</li>

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/admin/dashboard"
                       class="nav-link {{ request()->is('admin/dashboard') || request()->is('admin') ? 'active' : '' }}"
                       @if(request()->is('admin/dashboard') || request()->is('admin')) aria-current="page" @endif>
                        <i class="nav-icon fas fa-th"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(auth()->user()?->isAdmin())

                    <!-- User -->
                    <li class="nav-item">
                        <a href="/admin/user"
                           class="nav-link {{ request()->is('admin/user*') ? 'active' : '' }}"
                           @if(request()->is('admin/user*')) aria-current="page" @endif>
                            <i class="nav-icon fas fa-users"></i>
                            <p>User</p>
                        </a>
                    </li>

                    <!-- Kategori -->
                    <li class="nav-item">
                        <a href="/admin/kategori"
                           class="nav-link {{ request()->is('admin/kategori*') ? 'active' : '' }}"
                           @if(request()->is('admin/kategori*')) aria-current="page" @endif>
                            <i class="nav-icon fas fa-list"></i>
                            <p>Kelola Kategori</p>
                        </a>
                    </li>

                    <!-- Produk -->
                    <li class="nav-item">
                        <a href="/admin/produk"
                           class="nav-link {{ request()->is('admin/produk*') ? 'active' : '' }}"
                           @if(request()->is('admin/produk*')) aria-current="page" @endif>
                            <i class="nav-icon fas fa-box"></i>
                            <p>Kelola Produk</p>
                        </a>
                    </li>

                @endif

                <!-- Transaksi -->
                <li class="nav-item">
                    <a href="/admin/transaksi"
                       class="nav-link {{ request()->is('admin/transaksi*') ? 'active' : '' }}"
                       @if(request()->is('admin/transaksi*')) aria-current="page" @endif>
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>Kelola Transaksi</p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->

    </div>
    <!-- /.sidebar -->

</aside>

<div class="content-wrapper">
