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
                        <li class="breadcrumb-item active">Produk Terjual</li>
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
                            <div class="card-title">Produk Terjual</div>
                            <!-- <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('admin/produk/add') }}"> <i class="fa fa-plus"></i> Tambah Data</a>
                            </div> -->
                        </div>
                        <div class="card-body">
                            <table id="produk" class="table table-hover table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Transaksi</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Tipe Komisi</th>
                                <th>Komisi</th>                                
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
        function loadProduk() {
            $('#produk').DataTable({
                serverSide:true,
                ordering:true,
                processing:true,
                pageLength:10,
                info:false,
                ajax:{
                    url:'{{ route('produkterjual') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                    }
                },
                columns:[
                    {data:'id'},
                    {data:'kode'},
                    {data:'nama'},
                    {data:'trx'},
                    {data:'kategori_id'},
                    {data:'jumlah'},
                    {data:'satuan'},
                    {data:'harga'},
                    {data:'tipe_komisi'},
                    {data:'komisi'},
                    
                ],
                columnDefs:[{
                    "searchable": false,
                    "orderable": false,
                    "targets": 0,
                    render:function(data,type,row,m) {
                        return m.row+1
                    }
                },{
                    targets:7,
                    render: $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                },{
                    targets:9,
                    render:function (data,type,row) {
                      if(row['tipe_komisi']==='persen'){
                          return data+' %'
                      }else {
                        var  display = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ).display
                          return display(data)
                      }
                    }
                },{
                    targets:8,
                    render:function (data) {
                        return data.charAt(0).toUpperCase() + data.slice(1)
                    }
                }]
            })
        }
        $(document).ready(function () {
            loadProduk()
        })

    </script>
@endsection