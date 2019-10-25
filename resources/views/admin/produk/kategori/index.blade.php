@extends('layouts.master')
@section('title')
    <title>Kategori Produk</title>
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
                        <li class="breadcrumb-item active">Kategori Produk</li>
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
                            <div class="card-title">Kategori Produk</div>
                            <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('admin/produk/kategori/add') }}"> <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="kategori" class="table table-hover table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Kategori</th>
                                <th>Keterangan</th>
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
        function loadKategori() {
            $('#kategori').DataTable({
                serverSide:true,
                ordering:true,
                processing:true,
                ajax:{
                    url:'{{ route('listkategori') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                    }
                },
                columns:[
                    {data:'id'},
                    {data:'kode'},
                    {data:'nama'},
                    {data:'keterangan'},
                    {data:null}
                ],
                columnDefs:[{
                    targets:4,
                    render:function(data,type,row){
                        return "<a href='#' id='"+data.kategoriid+"' title='Hapus' onclick='event.preventDefault();  deleteKategori(this.id)'><i class='fa fa-trash text-danger'></i> </a>"+
                            "  <a href='{{ url('admin/produk/kategori/edit')}}/"+data.kategoriid+"'><i class='fa fa-edit text-success'></i></a>"
                    }
                }]
            })
        }
        $(document).ready(function () {
            loadKategori()
        })

        function deleteKategori(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan menghapus data kategori ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:"{{route('deletekategori')}}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },
                        success:function (data) {
                            if(data==='success'){
                                $('#kategori').DataTable().clear().destroy()
                                loadKategori()
                                Swal.fire(
                                    'Berhasil!',
                                    'Data kategori telah dihapus',
                                    'success'
                                )

                            }
                        }
                    })

                    // For more information about handling dismissals please visit
                    // https://sweetalert2.github.io/#handling-dismissals
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    Swal.fire(
                        'Batal',
                        'Data kategori batal dihapus',
                        'error'
                    )
                }
            })
        }

    </script>
@endsection