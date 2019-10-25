@extends('layouts.master')
@section('title')
    <title>Karyawan</title>
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
                        <li class="breadcrumb-item active">Karyawan</li>
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
                            <div class="card-title">Karyawan</div>
                            <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('admin/karyawan/add') }}"> <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="karyawan" class="table table-hover table-striped dataTable">
                                <thead>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Nama Pengguna</th>
                                    <th>Role</th>
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
            function loadUser() {
                $('#karyawan').DataTable({
                    serverSide:true,
                    ordering:true,
                    processing:true,
                    ajax:{
                        url:'{{ route('listkaryawan') }}',
                        type:'POST',
                        data:{
                            _token:'{{ csrf_token() }}',
                        }
                    },
                    columns:[
                        {data:'id'},
                        {data:'name'},
                        {data:'username'},
                        {data:'role'},
                        {data:null}
                    ],
                    columnDefs:[{
                        targets:4,
                        render:function(data,type,row){
                            return "<a href='#' id='"+data.userid+"' title='Hapus' onclick='event.preventDefault();  deleteUser(this.id)'><i class='fa fa-trash text-danger'></i> </a>"+
                                    "  <a href='{{ url('admin/karyawan/edit')}}/"+data.userid+"'><i class='fa fa-edit text-success'></i></a>"
                        }
                    }]
                })
            }
            $(document).ready(function () {
               loadUser()
            })

            function deleteUser(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Anda akan menghapus data karyawan ini!',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus!',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url:"{{route('deleteuser')}}",
                            type:"POST",
                            data:{
                                _token:"{{ csrf_token() }}",
                                id:id
                            },
                            success:function (data) {
                                if(data==='success'){
                                    $('#karyawan').DataTable().clear().destroy()
                                    loadUser()
                                    Swal.fire(
                                        'Berhasil!',
                                        'Data karyawan telah dihapus',
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
                            'Data karyawan batal dihapus',
                            'error'
                        )
                    }
                })
            }
            function editUser(id){
                console.log(id)
            }
        </script>
    @endsection