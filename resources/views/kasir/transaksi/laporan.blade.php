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
                                <th>Produk</th>  
                                <th>Tipe Pembayaran</th>
                                <th>Harga Satuan</th>  
                                <th>Diskon</th>                              
                                <th>Total Belanja</th>    
                                <th>Handle</th>  
                                <th>Kasir</th>
                                <th>Tanggal</th>                                                                                                        
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th style="text-align:right">Total Cash</th>
                                        <th style="text-align:left"></th> 
                                        <th style="text-align:right">Total Debit</th>
                                        <th style="text-align:left"></th> 
                                        <th style="text-align:right">Total</th>
                                        <th style="text-align:left"></th>  
                                                                              
                                    </tr>
                                </tfoot>
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
                text:'<i class="far fa-file-excel"></i> EXCEL',
                exportOptions:{orthogonal:'export'},
                title:'Laporan Transaksi-'+ moment().format('YYYYMMDD'),
                footer:true       
            },{
                extend:'pdf',
                exportOptions:{orthogonal:'export'},
                text:'<i class="far fa-file-pdf"></i> PDF',
                title:'Laporan Transaksi-'+ moment().format('YYYYMMDD'),
                orientation: 'landscape',
                footer:true      
            },{
                extend:'csv',
                exportOptions:{orthogonal:'export'},
                text:'<i class="fa fa-file-csv"></i> CSV',
                title:'Laporan Transaksi-'+ moment().format('YYYYMMDD') ,
                footer:true      
            }
               // , 'pdf','csv','copy'
            ],
            "footerCallback":function(row,data,start,end,display){
                  var api=this.api();data;
                  var intVal=function(i){
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                  };
                  totalcash =api.column(7).data().reduce( function (a, b, idx) {                      
                    if(api.column(4).data()[idx] == 'cash'){
                        return intVal(a) + intVal(b);
                    } else {
                        return a
                    }                  
                  }, 0 ); 
                  totaldebit =api.column(7).data().reduce( function (a, b, idx) {                   
                    if(api.column(4).data()[idx] == 'debit'){
                        return intVal(a) + intVal(b);
                    } else {
                        return a
                    }                  
                  }, 0 );
                  total =api.column(7).data().reduce( function (a, b) { 
                    return intVal(a) + intVal(b);
                  }, 0 );  
                  $(api.column(5).footer()).html(
                    $.number(totalcash,0,'.',',')
                  );   
                  $(api.column(7).footer()).html(
                    $.number(totaldebit,0,'.',',')
                  );                   
                  $(api.column(9).footer()).html(
                    $.number(total,0,'.',',')
                  );
                  
            },
            "autoWidth": true,
            "processing": true,
            "serverSide": true,
            "pageLength":10,
            "lengthMenu": [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ], scrollY: 370,
           
            "ajax":{
                "url":"{{ route('laporantrx') }}",
                "type":"POST",
                "dataType": "json",
                "data":{
                    _token:'{{ csrf_token() }}',                   
                    startdate:startdate,enddate:enddate,
                }
            },
            "columns":[
                {"data":"id"},
                {"data":"kode"},
                {"data":"nopol"},  
                {"data":"produk",render:function(data,type,row){                    
                    return type==='export' ? data: " "+data
                  }
                },
                {"data":"tipe_byr"},   
                {"data":"harga",render:function(data,type,row){
                    return type==='export' ? data: " "+data
                }},  
                {"data":"diskon",render:function(data,type,row){
                    return type==='export' ? data: " "+data
                }},                
                {"data":"total"},
                {"data":"guide"},
                {"data":"kasir"},
                {"data":"tanggal"}
             
            ],"columnDefs":[{
                    "targets":7,
                    "render": $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                },{
                    "targets":1,
                    "orderable": false,
                    "render":function(data,type,row){
                        return "<a href='{{ url('transaksi/detail')}}/"+data+"'>"+data+"</a>"
                    }
                },{
                    "targets":3,
                    "orderable": false,
                }
            ]        
        })
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