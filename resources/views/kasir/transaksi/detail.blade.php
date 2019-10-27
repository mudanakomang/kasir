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
                                        <form>
                                                <div class="form-group row">
                                                    <h3 id="idtransaksi"></h3>
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('nopol','Nomor kendaraan',['class'=>'col-sm-3']) !!}
                                                    {!! Form::select('nopol',[''=>$data->nopol]+\App\Kendaraan::whereDate('created_at', '=', date('Y-m-d'))->pluck('nopol', 'nopol')->all(),$data->nopol, ['class'=>'col-sm-4 form-control select2','id'=>'nopol'])!!}
                                                </div>
                                                <div class="form-group row">
                                                    {!! Form::label('guide_id','Guide',['class'=>'col-sm-3']) !!}
                                                    {!!  Form::select('guide_id',[''=>'Guide']+\App\Guide::pluck('name', 'id')->all(),$data->guide->id, ['class'=>'col-sm-4 form-control select2','id'=>'guide_id'])!!}
                                                </div>
                                                <!-- <div class="form-group row">

                                                    {!! Form::hidden('kode',null,['id'=>'kode']) !!}
                                                    {!! Form::label('produk','Produk',['class'=>'col-sm-3']) !!}
                                                    {!! Form::select('produk',[''=>'Cari Produk']+\App\Produk::where('stok','>',0)->select(DB::raw("CONCAT(kode,' | ',nama) AS nama"),'id')->pluck('nama', 'id')->all(),null, ['class'=>$errors->has('produk') ? 'col-sm-8 form-control is-invalid select2':'col-sm-8 form-control select2','onchange'=>'updateTrx()','id'=>'produk'])!!}

                                                </div> -->
                                            </form>
                                            <table id="detailtransaksi" class="table table-hover table-striped dataTable">
                                                <thead>
                                                <th>No</th>
                                                <th>Produk</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Harga</th>
                                                <th>Diskon</th>
                                                <th>Subtotal</th>                                                
                                                </thead>
                                                <tbody>
                                                    @foreach($data->produk as $key=>$produk)
                                                    <tr>
                                                        <td>{{ $key+1 }}</td>
                                                        <td>{{ $produk->nama }}</td>
                                                        <td>{{ $produk->pivot->jumlah }}</td>
                                                        <td>{{ $produk->satuan }}</td>
                                                        <td>{{ "Rp ".number_format($produk->harga,0,",",".") }}</td>
                                                        <td>{{ $produk->pivot->diskon." %" }}</td>
                                                        <td>{{ "Rp ".number_format($produk->subtotal,0,",",".") }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                                                    <h4><b><p id="totalbelanja">Rp {{ number_format($data->total,0,",",".") }}</p></b></h4>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="tipe_byr">Jenis Pembayaran</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        {!! Form::select('tipe_byr',['cash'=>'Cash','debit'=>'Debit','credit'=>'Credit'],$data->tipe_byr,['class'=>'form-control ','onchange=hitungTotal()','oninput=this.onchange()','id'=>'tipe_byr']) !!}                                                       
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="jumlah_byr">Jumlah Bayar</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="input-group">
                                                        {!! Form::text('jumlah_byr',number_format($data->jumlah_byr,0,",","."),['class'=>'form-control','style'=>'font-weight:bold','id'=>'jumlah_byr','pattern'=>'\d*','onchange=hitungTotal()','oninput=this.onchange()','autocomplete'=>'off','placeholder'=>'Jumlah Bayar']) !!}                                                        
                                                    </div>
                                                </div>
                                            </div>                                           
                                            <hr>
                                            <div class="form-group row">
                                                <div class="col-md-6 col-lg-6">
                                                    <label for="kembali">Kembali</label>
                                                </div>
                                                <div class="col-lg-6 col-md-6">                                                   
                                                    <h4> <b><p id="kembali">Rp {{ number_format($data->jumlah_byr-$data->total,0,",",".")}}</p></b></h4>                                                
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row">
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
                                            </div> -->
                                            <div class="form-group row">
                                            @if($data->status=='pending')
                                            <div class="col-md-3 col-lg-3">
                                                    <button class="btn btn-flat btn-success" id="lanjut">Lanjutkan <i class="fa fa-check"></i> </button>
                                                </div>
                                            @endif
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
@section('script')
<script>
    $('#lanjut').on('click',function(){
        $.ajax({
            url:'{{ route('lanjuttrx') }}',
            type:'POST',
            data:{
                _token:'{{ csrf_token() }}',
                kode:'{{ $data->kode }}',                
            },success:function(d){
                if(d==='ok'){
                location.href='{{ route('addtransaksi') }}';
                }
            }
        })
    })
</script>
@endsection