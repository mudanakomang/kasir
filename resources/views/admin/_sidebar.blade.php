<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="{{ url('/admin') }}" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right"></i>
                </p>
            </a>
        </li>
        <li class="nav-header">KARYAWAN</li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users"></i>
                <p>
                    Karyawan
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/karyawan') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Karyawan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/guide') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Guide</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">TRANSASKI</li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>
                    Transaksi
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('transaksi') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Data Transaksi</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('transaksi/pending') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Transaksi Pending</p>
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-header">PRODUK</li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-luggage-cart"></i>
                <p>
                    Produk
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('admin/produk/kategori') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Kategori Produk</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('admin/produk') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Produk</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item ">
            <a href="{{ url('kendaraan') }}" class="nav-link ">
                <i class="nav-icon fas fa-car"></i>
                <p>
                    Nomor Kendaraan
                    <i class="right"></i>
                </p>
            </a>
        </li>
    </ul>
</nav>