<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="{{ url('/kasir') }}" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right"></i>
                </p>
            </a>
        </li>
        <li class="nav-header">TRANSAKSI</li>
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                    Transaksi
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ url('transaksi/t/selesai') }}" class="nav-link">
                        <i class="far fa-check-circle nav-icon"></i>
                        <p>Transaksi Selesai</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('transaksi/t/pending') }}" class="nav-link">
                        <i class="far fa-stop-circle nav-icon"></i>
                        <p>Transaksi Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('transaksi/laporan') }}" class="nav-link">
                        <i class="far fa-file-excel nav-icon"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</nav>