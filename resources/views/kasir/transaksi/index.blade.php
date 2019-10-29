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
                        <div class="form-group col-3">
                            <label>Filter Tanggal</label>

                            <div class="input-group">                           
                            <input type="text" autocomplete="off" class="form-control pull-right" id="filtertgl">
                            </div>
                            <!-- /.input group -->
                        </div>                       
                        
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
                                <th>Kasir</th>
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
function loadTransaksi(startdate='',enddate=''){
      var t=  $('#transaksi').DataTable({
            "dom": 'lBfrtip',
            "buttons": [{
                extend:'excel',
                title:'Transaksi-'+ moment().format('YYYYMMDD')        
            },{
                extend:'pdf',
                title:'Transaksi-'+ moment().format('YYYYMMDD')        
            },{
                extend:'csv',
                title:'Transaksi-'+ moment().format('YYYYMMDD')        
            }
               // , 'pdf','csv','copy'
            ],
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "pageLength":10,
            "lengthMenu": [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ], scrollY: 370,
           
            "ajax":{
                "url":"{{ route('listtransaksi') }}",
                "type":"POST",
                "dataType": "json",
                "data":{
                    _token:'{{ csrf_token() }}',
                    tipe:'{{ $tipe }}',
                    startdate:startdate,enddate:enddate,
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
                {"data":"kasir"},           
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
        $('#filtertgl').daterangepicker({
            autoUpdateInput: false,
            opens:'right',
             locale: {
                cancelLabel: 'Clear'
            }
        })
        $('#filtertgl').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        });

        $('#filtertgl').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });
        $('#filtertgl').on('apply.daterangepicker', function(ev, picker) {
            $('#transaksi').DataTable().destroy();
           var startdate=picker.startDate.format('YYYY-MM-DD');
           var enddate=picker.endDate.format('YYYY-MM-DD');
            loadTransaksi(startdate,enddate)
        });
        loadTransaksi('{{$startdate}}','{{$enddate}}')
    })
</script>
@endsection