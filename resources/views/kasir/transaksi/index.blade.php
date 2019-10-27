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
                        <li class="breadcrumb-item active">Transaksi</li>
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
                            <div class="card-title">Data Transaksi</div>
                            <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('transaksi/add') }}"> <i class="fa fa-plus"></i> Tambah Transaksi</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <table id="transaksi" class="table table-hover responsive table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>Kode</th>
                                <th>No Polisi</th>
                                <th>Guide</th>
                                <th>Tipe Pembayaran</th>
                                <th>Total Belanja</th>
                                <th>Jumlah Pembayaran</th>                                
                                <th>Tanggal</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('script')
<script>
function loadTransaksi(){
      var t=  $('#transaksi').DataTable({
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "pageLength":10,
            "ajax":{
                "url":"{{ route('listtransaksi') }}",
                "type":"POST",
                "dataType": "json",
                "data":{
                    _token:'{{ csrf_token() }}',
                    tipe:'{{ $tipe }}'
                }
            },
            "columns":[
                {"data":"id"},
                {"data":"kode"},
                {"data":"nopol"},
                {"data":"guide"},
                {"data":"tipe_byr"},
                {"data":"total"},
                {"data":"jumlah_byr"}, 
                {"data":"tanggal"},               
            ],"columnDefs":[{
                    "targets":[5,6],
                    "render": $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                },{
                    "targets":1,
                    "orderable": false,
                    "render":function(data,type,row){
                        return "<a href='{{ url('transaksi/detail')}}/"+data+"'>"+data+"</a>"
                    }
                }
            ]        
        })
    }
    function detailTrx(id){

    }
    $(document).ready(function(){
        loadTransaksi()
    })
</script>
@endsection