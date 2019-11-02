@extends('layouts.master')

@section('title')
    <title>Dashboard</title>
    @endsection
@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    @endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <!-- Info boxes -->
            @if(Auth::user()->hasRole('admin') or Auth::user()->hasRole('kasir'))
            <div class="row">
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-chart-area"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Transaksi Tertinggi</span>
                            <span class="info-box-number"><a href="{{ url('transaksi/detail/').'/'.$maxtrx->kode }}"> {{ $maxtrx->kode }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Transaksi Bulan Ini</span>
                            <span class="info-box-number"><a href="{{ url('transaksi/t/selesai').'/'.\Carbon\Carbon::now()->startOfMonth()->format('Y-m-d').'/'.\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d') }}">{{ $monthtrx }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <!-- fix for small devices only -->
                <div class="clearfix hidden-md-up"></div>

                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Transaksi Hari Ini</span>
                            <span class="info-box-number"><a href="{{ url('transaksi/t/selesai').'/'.\Carbon\Carbon::now()->format('Y-m-d').'/'.\Carbon\Carbon::now()->format('Y-m-d') }}">{{ $todaytrx==0 ? "Kosong":$todaytrx }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                        <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-cart-arrow-down"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Transaksi Pending</span>
                            <span class="info-box-number"><a href="{{ url('transaksi/t/pending')}}">{{ $pending }}</a></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>           
            <div class="row">
                <!-- Left col -->

                <!-- /.col -->
               
                <div class="col-md-2">
                    <!-- Info Boxes Style 2 -->
                    <h2>Stok < 10</h2>
                    @foreach($hbs as $prd)
                    <div class="info-box mb-3 bg-warning">
                        <span class="info-box-icon"><i class="fas fa-tag"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">{{ $prd->nama }}</span>
                            <span class="info-box-number">{{ $prd->stok }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    @endforeach
                    <!-- /.info-box -->
                    
                    <!-- /.info-box -->


                    <!-- /.card -->

                    <!-- PRODUCT LIST -->

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <!-- Left col -->

                <!-- /.col -->
               
                <div class="col-md-2">
                    <!-- Info Boxes Style 2 -->
                    <h2>Kendaraan</h2>
                    
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kendaraan Masuk</span>
                            <span class="info-box-number">{{ $total }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kendaraan Terakhir</span>
                            <span class="info-box-number">{{ $last ? $last->nopol:'' }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    
                    <!-- /.info-box -->
                    
                    <!-- /.info-box -->


                    <!-- /.card -->

                    <!-- PRODUCT LIST -->

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            @endif
            @if(Auth::user()->hasRole('konter'))
            <div class="row">
                <!-- Left col -->

                <!-- /.col -->
               
                <div class="col-md-2">
                    <!-- Info Boxes Style 2 -->
                    <h2>Kendaraan</h2>
                    
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kendaraan Masuk</span>
                            <span class="info-box-number">{{ $total }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <div class="info-box mb-3 bg-success">
                        <span class="info-box-icon"><i class="fas fa-car"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Kendaraan Terakhir</span>
                            <span class="info-box-number">{{ $last->nopol }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    
                    <!-- /.info-box -->
                    
                    <!-- /.info-box -->


                    <!-- /.card -->

                    <!-- PRODUCT LIST -->

                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            @endif
            <!-- /.row -->
        </div><!--/. container-fluid -->
    </section>
@endsection