<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item ">
            <a href="{{ url('/konter') }}" class="nav-link ">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                    Dashboard
                    <i class="right"></i>
                </p>
            </a>
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