@extends('layouts.master')
@section('title')
    <title>Produk</title>
@endsection
@section('breadcrumb')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('admin/produk') }}">Produk</a></li>
                        <li class="breadcrumb-item active">Manajemen Produk</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
@endsection
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">Manajemen Produk</div>
                        </div>
                        <div class="card-body">
                            <div class="col-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Data Produk</h3>
                                    </div>
                                    <div class="card-body">
                                        @include('admin.produk._form')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection