{{ Form::model($data,['action'=>$action]) }}
<div class="form-group row">
    {!! Form::label('name','Nama Guide',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('name',$data->name, ['class'=>$errors->has('name') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Nama Guide'])!!}
    @if ($errors->has('name'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('name') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('telp','Nomor Telepon ',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('telp',$data->telp, ['class'=>$errors->has('telp') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Nomor Telepon'])!!}
    @if ($errors->has('telp'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('telp') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('tgl_masuk','Tanggal Masuk ',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('tgl_masuk',$data->tgl_masuk, ['class'=>$errors->has('tgl_masuk') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Tanggal Masuk'])!!}
    @if ($errors->has('tgl_masuk'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('tgl_masuk') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('honor','Honor ',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('honor',$data->honor, ['class'=>$errors->has('honor') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Honor'])!!}
    @if ($errors->has('honor'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('honor') }}</p>
              </span>
    @endif
</div>
<div class="card-footer">
    <button type="submit" class="btn btn-info">Simpan</button>
</div>
{{ Form::close() }}
@section('script')
    <script>
        $(function () {
            $('#tgl_masuk').val("")
            var dt= '{{ empty($data->tgl_masuk) ? "":$data->tgl_masuk  }}'
            if(dt==""){
                var obj=moment()
            }else {
                var obj=moment(dt)
            }
            $('#tgl_masuk').datetimepicker({

                format: 'DD MMMM YYYY',
                locale: 'id',
                viewMode: 'years',
                defaultDate:obj,
            })
        })

        var options =  {
            reverse:true,
            onKeyPress: function(cep, e, field, options) {
                var masks = ['#.##0', '000.000.000.000.000'];
                var mask = (cep.length>7) ? masks[1] : masks[0];
                $('#honor').mask(mask, options);
            }};
        $('#honor').mask('#.##0', options);

    </script>
    @endsection