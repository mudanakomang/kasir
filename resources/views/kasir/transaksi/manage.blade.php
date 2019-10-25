@extends('layouts.master')
@section('title')
    <title>Transaksi</title>
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
                        <li class="breadcrumb-item"><a href="{{ url('transaksi') }}">Transaksi</a></li>
                        <li class="breadcrumb-item active">Detail Transaksi</li>
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
                            <div class="card-title">Transaksi</div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Transaksi</h3>
                                        </div>
                                        <div class="card-body">
                                            @include('kasir.transaksi._form')
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">Pembayaran</h3>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="totalbelanja">Total Belanja</label>
                                                </div>
                                                <div class="col-md-6 col-lg-6">
                                                    <h4><b><p id="totalbelanja">Rp 0</p></b></h4>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="tipe_byr">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        {!! Form::select('tipe_byr',['cash'=>'Cash','debit'=>'Debit','credit'=>'Credit'],null,['class'=>'form-control ','onchange=hitungTotal()','oninput=this.onchange()','id'=>'tipe_byr']) !!}                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="jumlah_byr">Jumlah Bayar</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        {!! Form::text('jumlah_byr',null,['class'=>'form-control','style'=>'font-weight:bold','id'=>'jumlah_byr','pattern'=>'\d*','onchange=hitungTotal()','oninput=this.onchange()','autocomplete'=>'off','placeholder'=>'Jumlah Bayar']) !!}                                                        
                                                    </div>
                                                </div>
                                            </div>                                           
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="kembali">Kembali</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">                                                   
                                                    <h4> <b><p id="kembali">Rp 0</p></b></h4>                                                
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-3 col-lg-3">
                                                 <button class="btn btn-flat btn-info" id="pending">Pending <i class="fa fa-save"></i> </button>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                 <a href="{{ url('transaksi/printtrx/') }}" class="btn btn-flat btn-success" id="print">Cetak <i class="fa fa-print"></i> </a>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <button class="btn btn-flat btn-danger" id="batal">Batalkan <i class="fa fa-times-circle"></i> </button>
                                                </div>
                                                <div class="col-md-3 col-lg-3">
                                                    <button class="btn btn-flat btn-success" id="selesai">Selesai <i class="fa fa-check"></i> </button>
                                                </div>
                                            </div>
                                        </div>
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