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
                        <li class="breadcrumb-item active">Produk</li>
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
                            <div class="card-title">Produk</div>
                            <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('admin/produk/add') }}"> <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="produk" class="table table-hover table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Produk</th>
                                <th>Kategori</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Tipe Komisi</th>
                                <th>Komisi</th>
                                <th>#</th>
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
                ajax:{
                    url:'{{ route('listproduk') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                    }
                },
                columns:[
                    {data:'id'},
                    {data:'kode'},
                    {data:'nama'},
                    {data:'kategori_id'},
                    {data:'stok'},
                    {data:'satuan'},
                    {data:'harga'},
                    {data:'tipe_komisi'},
                    {data:'komisi'},
                    {data:null}
                ],
                columnDefs:[{
                    targets:9,
                    render:function(data,type,row){
                        return "<a href='#' id='"+data.produkid+"' title='Hapus' onclick='event.preventDefault();  deleteProduk(this.id)'><i class='fa fa-trash text-danger'></i> </a>"+
                            "  <a href='{{ url('admin/produk/edit')}}/"+data.produkid+"'><i class='fa fa-edit text-success'></i></a>"
                    }
                },{
                    targets:6,
                    render: $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                },{
                    targets:8,
                    render:function (data,type,row) {
                      if(row['tipe_komisi']==='persen'){
                          return data+' %'
                      }else {
                        var  display = $.fn.dataTable.render.number( ',', '.', 0, 'Rp. ' ).display
                          return display(data)
                      }
                    }
                },{
                    targets:7,
                    render:function (data) {
                        return data.charAt(0).toUpperCase() + data.slice(1)
                    }
                },{
                    targets:4,
                    render:function(data,type,row){
                        var id=row['id']                        
                        return data  + "+ <input type=number name=jumlah style=width:45px id="+id+" value='' autocomplete='off' onchange='updateStok(this.id,this.value)'  min=0 >"
                    }
                }]
            })
        }
        $(document).ready(function () {
            loadProduk()
        })

        function updateStok(id,val){
            $.ajax({
                url:'{{ route('updatestok') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    id:id,
                    val:val
                },success:function(d){
                    $('#produk').DataTable().ajax.reload();
                }
            })
        }
        function deleteProduk(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan menghapus data produk ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:"{{route('deleteproduk')}}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },
                        success:function (data) {
                            if(data==='success'){
                                $('#produk').DataTable().clear().destroy()
                                loadProduk()
                                Swal.fire(
                                    'Berhasil!',
                                    'Data produk telah dihapus',
                                    'success'
                                )

                            }
                        }
                    })

                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Batal',
                        'Data produk batal dihapus',
                        'error'
                    )
                }
            })
        }

    </script>
@endsection