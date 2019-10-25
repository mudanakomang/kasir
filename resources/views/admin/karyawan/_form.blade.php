
@if($action=='edit')
    {!! Form::model($data,['action' => ['KaryawanController@update', 'id'=>$data->id],'method'=>'put'],['class'=>'form-horizontal'])  !!}
@else
    {!!  Form::model($data,['action'=>'KaryawanController@store'],['class'=>'form-horizontal'])  !!}
@endif
    <div class="form-group row">
        {!! Form::label('name','Nama Karyawan',['class'=>'col-sm-4 col-form-label']) !!}
        {!!  Form::text('name',$data->name, ['class'=>$errors->has('name') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Nama Karyawan'])!!}
        @if ($errors->has('name'))
            <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('name') }}</p>
              </span>
        @endif
    </div>
    <div class="form-group row">
        {!! Form::label('username','Nama Pengguna',['class'=>'col-sm-4  col-form-label']) !!}
        {!!  Form::text('username',$data->username, ["class"=> $errors->has('username') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Nama Pengguna'])!!}
        @if ($errors->has('username'))
            <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('username') }}</p>
              </span>
        @endif
    </div>
    <div class="form-group row">
        {!! Form::label('role','Role Pengguna',['class'=>'col-sm-4 col-form-label']) !!}
        {!!  Form::select('role',[''=>'Pilih Role']+\App\Role::pluck('description','id')->all(),$action=='edit' ? $data->roles[0]->id:null, ['class'=>$errors->has('role') ? 'col-sm-6 form-control is-invalid select2':'col-sm-6 form-control select2'])!!}
        @if ($errors->has('role'))
            <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('role') }}</p>
              </span>
        @endif
    </div>
    @if($action!=='edit')
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
    @endif
    <div class="card-footer">
        <button type="submit" class="btn btn-info">Simpan</button>
    </div>
{!! Form::close()  !!}