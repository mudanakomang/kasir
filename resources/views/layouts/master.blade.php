<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

@yield('title')

<!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!--Datatable -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables/buttons.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/css/bootstrap-datetimepicker.min.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('css/google.css') }}" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            {{--<li class="nav-item d-none d-sm-inline-block">--}}
            {{--<a href="index3.html" class="nav-link">Home</a>--}}
            {{--</li>--}}
            {{--<li class="nav-item d-none d-sm-inline-block">--}}
            {{--<a href="#" class="nav-link">Contact</a>--}}
            {{--</li>--}}
        </ul>

        <!-- SEARCH FORM -->
    {{--<form class="form-inline ml-3">--}}
    {{--<div class="input-group input-group-sm">--}}
    {{--<input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">--}}
    {{--<div class="input-group-append">--}}
    {{--<button class="btn btn-navbar" type="submit">--}}
    {{--<i class="fas fa-search"></i>--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</form>--}}

    <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Messages Dropdown Menu -->
        {{--<li class="nav-item dropdown">--}}
        {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
        {{--<i class="far fa-comments"></i>--}}
        {{--<span class="badge badge-danger navbar-badge">3</span>--}}
        {{--</a>--}}
        {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
        {{--<a href="#" class="dropdown-item">--}}
        {{--<!-- Message Start -->--}}
        {{--<div class="media">--}}
        {{--<img src="../../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">--}}
        {{--<div class="media-body">--}}
        {{--<h3 class="dropdown-item-title">--}}
        {{--Brad Diesel--}}
        {{--<span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>--}}
        {{--</h3>--}}
        {{--<p class="text-sm">Call me whenever you can...</p>--}}
        {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- Message End -->--}}
        {{--</a>--}}
        {{--<div class="dropdown-divider"></div>--}}
        {{--<a href="#" class="dropdown-item">--}}
        {{--<!-- Message Start -->--}}
        {{--<div class="media">--}}
        {{--<img src="../../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
        {{--<div class="media-body">--}}
        {{--<h3 class="dropdown-item-title">--}}
        {{--John Pierce--}}
        {{--<span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>--}}
        {{--</h3>--}}
        {{--<p class="text-sm">I got your message bro</p>--}}
        {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- Message End -->--}}
        {{--</a>--}}
        {{--<div class="dropdown-divider"></div>--}}
        {{--<a href="#" class="dropdown-item">--}}
        {{--<!-- Message Start -->--}}
        {{--<div class="media">--}}
        {{--<img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">--}}
        {{--<div class="media-body">--}}
        {{--<h3 class="dropdown-item-title">--}}
        {{--Nora Silvester--}}
        {{--<span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>--}}
        {{--</h3>--}}
        {{--<p class="text-sm">The subject goes here</p>--}}
        {{--<p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<!-- Message End -->--}}
        {{--</a>--}}
        {{--<div class="dropdown-divider"></div>--}}
        {{--<a href="#" class="dropdown-item dropdown-footer">See All Messages</a>--}}
        {{--</div>--}}
        {{--</li>--}}
        <!-- Notifications Dropdown Menu -->
            {{--<li class="nav-item dropdown">--}}
            {{--<a class="nav-link" data-toggle="dropdown" href="#">--}}
            {{--<i class="far fa-bell"></i>--}}
            {{--<span class="badge badge-warning navbar-badge">15</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">--}}
            {{--<span class="dropdown-item dropdown-header">15 Notifications</span>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<a href="#" class="dropdown-item">--}}
            {{--<i class="fas fa-envelope mr-2"></i> 4 new messages--}}
            {{--<span class="float-right text-muted text-sm">3 mins</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<a href="#" class="dropdown-item">--}}
            {{--<i class="fas fa-users mr-2"></i> 8 friend requests--}}
            {{--<span class="float-right text-muted text-sm">12 hours</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<a href="#" class="dropdown-item">--}}
            {{--<i class="fas fa-file mr-2"></i> 3 new reports--}}
            {{--<span class="float-right text-muted text-sm">2 days</span>--}}
            {{--</a>--}}
            {{--<div class="dropdown-divider"></div>--}}
            {{--<a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>--}}
            {{--</div>--}}
            {{--</li>--}}
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('images/user.png') }}" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline"> {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">

                        <p>
                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                            <small>{{ \Illuminate\Support\Facades\Auth::user()->roles[0]->description }}</small>
                        </p>
                    </li>
                    <li class="user-footer">
                        {{--<a href="#" class="btn btn-default btn-flat">Profile</a>--}}
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
            {{--<li class="nav-item">--}}
            {{--<a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">--}}
            {{--<i class="fas fa-th-large"></i>--}}
            {{--</a>--}}
            {{--</li>--}}
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ url('/')}}" class="brand-link">
            <img src="{{ asset('images/bs.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">Intan Sari</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ \Illuminate\Support\Facades\Auth::user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
        @include(Auth::user()->roles[0]->name.'._sidebar')
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @yield('breadcrumb')
    <!-- /.content-header -->

        <!-- Main content -->
    @yield('content')
    <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>Copyright &copy; 2014-2019 <a href="http://adminlte.io">AdminLTE.io</a>.</strong>
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 3.0.0-rc.3
        </div>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/jquery/jquery.mask.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>

<!-- overlayScrollbars -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>

<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('plugins/datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/buttons.print.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
{{--<script src="{{ asset('dist/js/demo.js') }}"></script>--}}

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="{{ asset('plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/jquery.mapael.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-mapael/maps/usa_states.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment-with-locales.min.js') }}"></script>
<script src="{{ asset('js/daterangepicker.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/js.cookie.min.js') }}"></script>
<script src="{{ asset('js/jquery.number.min.js') }}"></script>
<!-- PAGE SCRIPTS -->
{{--<script src="{{ asset('dist/js/pages/dashboard2.js') }}"></script>--}}
<script>
    $(function () {

        $('nav').find('a').each(function () {
            $(this).removeClass('active')
            var parent=$(this).parent().parent().parent()
            if(parent.hasClass('has-treeview')){
                parent.removeClass('menu-open')
            }
        })
        var loc = location.pathname.split('/').pop();
        $('nav').find('a').each(function () {
            var active=$(this).attr('href').substring(this.href.lastIndexOf('/') + 1)
            if(loc==active){
                $(this).addClass('active')
                var parent=$(this).parent().parent().parent()
                if(parent.hasClass('has-treeview')){
                    parent.addClass('menu-open')
                }
            }
        })
    })

</script>
@yield('script')
</body>
</html>