@extends('layouts.master')
@section('title')
    <title>Edit Karyawan</title>
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
                        <li class="breadcrumb-item"><a href="{{ url('admin/karyawan') }}">Karyawan</a></li>
                        <li class="breadcrumb-item active">Edit Karyawan</li>
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
                            <div class="card-title">Reset Password</div>
                        </div>
                        <div class="card-body">
                            <div class="col-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Password</h3>
                                    </div>
                                    <div class="card-body">
                                       {{ Form::open(['route'=>'resetpass'])}}
                                       <div class="form-group row">
                                            {!! Form::label('password','Password',['class'=>'col-sm-4 col-form-label']) !!}
                                            {!! Form::password('password', ['class'=>$errors->has('password') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Password'])!!}
                                            @if ($errors->has('password'))
                                                <span class="text-danger offset-4 col-sm-10">
                                                    <p>{{ $errors->first('password') }}</p>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group row">
                                            {!! Form::label('password_confirmation','Konfirmasi Password',['class'=>'col-sm-4 col-form-label']) !!}
                                            {!! Form::password('password_confirmation', ['class'=>$errors->has('password_confirmation') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Konfirmasi Password'])!!}
                                            @if ($errors->has('password_confirmation'))
                                                <span class="text-danger offset-4 col-sm-10">
                                                    <p>{{ $errors->first('password_confirmation') }}</p>
                                                </span>
                                            @endif
                                        </div>
                                    
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-info">Simpan</button>
                                        </div>
                                    {!! Form::close()  !!}
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