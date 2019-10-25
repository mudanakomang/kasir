@extends('layouts.master')
@section('title')
    <title>Guide</title>
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
                        <li class="breadcrumb-item active">Guide</li>
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
                            <div class="card-title">Guide</div>
                            <div class="card-tools">
                                <a class="btn btn-info" href="{{ url('admin/guide/add') }}"> <i class="fa fa-plus"></i> Tambah Data</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="guide" class="table table-hover table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Tanggal Masuk</th>
                                <th>Honor</th>
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
        function loadGuide() {
            $('#guide').DataTable({
                serverSide:true,
                ordering:true,
                processing:true,
                ajax:{
                    url:'{{ route('listguide') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                    }
                },
                columns:[
                    {data:'id'},
                    {data:'name'},
                    {data:'telp'},
                    {data:'tgl_masuk'},
                    {data:'honor'},
                    {data:null}
                ],
                columnDefs:[{
                    targets:5,
                    render:function(data,type,row){
                        return "<a href='#' id='"+data.guideid+"' title='Hapus' onclick='event.preventDefault();  deleteGuide(this.id)'><i class='fa fa-trash text-danger'></i> </a>"+
                            "  <a href='{{ url('admin/guide/edit')}}/"+data.guideid+"'><i class='fa fa-edit text-success'></i></a>"
                    }
                },{
                    targets:3,
                    render:function(data,type,row){
                        return moment(data).format('DD MMMM YYYY')
                    }
                },{
                    targets:4,
                    render: $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                }]
            })
        }
        $(document).ready(function () {
            moment.locale('id')
            loadGuide()
        })

        function deleteGuide(id) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Anda akan menghapus data guide ini!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: 'Batalkan'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url:"{{route('deleteguide')}}",
                        type:"POST",
                        data:{
                            _token:"{{ csrf_token() }}",
                            id:id
                        },
                        success:function (data) {
                            if(data==='success'){
                                $('#guide').DataTable().clear().destroy()
                                loadGuide()
                                Swal.fire(
                                    'Berhasil!',
                                    'Data guide telah dihapus',
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
                        'Data guide batal dihapus',
                        'error'
                    )
                }
            })
        }

    </script>
@endsection