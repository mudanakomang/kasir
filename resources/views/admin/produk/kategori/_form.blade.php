{{ Form::model($data,['action'=>$action,'id'=>'formkategori']) }}
<div class="form-group row">
    {!! Form::label('kode','Kode',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('kode',null, ['class'=>'col-sm-6 form-control ','disabled', 'placeholder'=>'Kode'])!!}
</div>
<div class="form-group row">
    {!! Form::label('nama','Kategori',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('nama',$data->nama, ['class'=>$errors->has('nama') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Kategori'])!!}
    @if ($errors->has('nama'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('nama') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('keterangan','Keterangan',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('keterangan',$data->keterangan, ['class'=>$errors->has('keterangan') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Keterangan'])!!}
    @if ($errors->has('keterangan'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('keterangan') }}</p>
              </span>
    @endif
</div>
<div class="card-footer">
    <button id="btnkategori" type="submit" class="btn btn-info">Simpan</button>
</div>
{{ Form::close() }}
@section('script')
    <script>

        $('#btnkategori').click(function (e) {
            e.preventDefault()

            var form=$('#formkategori')
            form.append('<input type="hidden" name="kodebaru" value="'+$('#kode').val()+'" />');
            var formData = new FormData(document.getElementById("formkategori"))

            form.submit();
        })

     $(document).ready(function () {
         var kode="{{ $data->kode }}";
         if(kode===''){
             $.ajax({
                 url:'{{ route('getkategorikode') }}',
                 type:'POST',
                 data:{
                     _token:'{{ csrf_token() }}'
                 },success:function (d) {
                     $('#kode').val(d)
                 }
             });

         }else {
             $('#kode').val(kode);
         }
     })

    </script>
    @endsection