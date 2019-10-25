@extends('layouts.master')
@section('title')
    <title>Nomor Kendaraan</title>
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
                        <li class="breadcrumb-item active">Nomor Kendaraan</li>
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
                            <div class="card-title">Nomor Kendaraan</div>

                        </div>
                        <div class="card-body">
                            {{ Form::open(['url'=>'kendaraan/add']) }}
                            <div class="input-group input-group-lg col-lg-2">
                                {!! Form::text('nopol',null,['class'=>'form-control ','style'=>'text-transform: uppercase','id'=>'nopol','placeholder'=>'No Polisi','autocomplete'=>'off']) !!}
                                <div class="input-group-append">
                                    <button class="btn btn-success"  id="btnnopol" type="button"><i class="fa fa-check"></i> </button>
                                </div>
                            </div>
                            <div id="errors"></div>

                            {{ Form::close() }}
                            <hr>
                            <table id="nopolisi" class="table table-hover table-striped dataTable">
                                <thead>
                                <th>No</th>
                                <th>No Polisi</th>
                                <th>Tanggal Masuk</th>
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
        $('#btnnopol').on('click',function (e) {
            $.ajax({
                url:'{{ route('savenopol') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    nopol:$('#nopol').val()
                },
                success:function (data) {
                    if(data==='success'){
                        $('#nopol').removeClass('is-invalid')
                        $('#errorspan ').remove()
                        $('#nopolisi').DataTable().clear().destroy()
                        loadNopol()
                        Swal.fire(
                            'Berhasil!',
                            'Data nomor polisi telah disampan',
                            'success'
                        )
                        $('#nopol').val("")
                    }else{
                        $('#nopol').addClass('is-invalid')
                        $('#errorspan ').remove()
                        $('#errors').append('<span id="errorspan" class="text-danger offset-4 col-sm-10">' +'<p>'+data.nopol+'</p>' +'</span>')
                    }
                }
            })
        })
        $('#nopol').bind('keypress keydown keyup', function(e){
            if(e.keyCode === 13) {
                e.preventDefault()
                $('#btnnopol').click()
            }
        });
        function loadNopol() {
            $('#nopolisi').DataTable({
                serverSide:true,
                ordering:true,
                processing:true,
                ajax:{
                    url:'{{ route('listnopol') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                    }
                },
                columns:[
                    {data:'id'},
                    {data:'nopol'},
                    {data:'tgl_masuk'},
                    {data:null}
                ],
                columnDefs:[{
                    targets:3,
                    render:function(data,type,row){
                        return "  <a href='javascript:void(0)' onclick='editNopol(\"" + data.nopolid + "\",\"" + data.nopol + "\")'><i class='fa fa-edit text-success'></i></a>"
                    }
                },{
                    targets:2,
                    render:function(data,type,row){
                        return moment(data).format('DD MMMM YYYY h:mm')
                    }
                }]
            })
        }
        $(document).ready(function () {
            moment.locale('id')
            loadNopol()
        })
        function editNopol(id,nopol) {
            $('#nopol').val(nopol).focus()
            $.ajax({
                url:"{{ route('deletenopol') }}",
                type:"POST",
                data:{
                    _token:"{{ csrf_token() }}",
                    id:id
                }
            })
        }
    </script>
    @endsection