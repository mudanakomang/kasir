{{ Form::model($data,['action'=>$action,'id'=>'formproduk']) }}
<div class="form-group row">
    {!! Form::label('kode','Kode',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('kode',null, ['class'=>'col-sm-6 form-control ','disabled', 'placeholder'=>'Kode'])!!}
</div>
<div class="form-group row">
    {!! Form::label('nama','Nama Produk',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('nama',$data->nama, ['class'=>$errors->has('nama') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Nama Produk'])!!}
    @if ($errors->has('nama'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('nama') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('kategori_id','Kategori Produk',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::select('kategori_id',[''=>'Pilih Kategori']+\App\Kategori::pluck('nama','id')->all(),$data->kategori_id, ['class'=>$errors->has('kategori_id') ? 'col-sm-6 form-control is-invalid select2':'col-sm-6 form-control select2'])!!}
    @if ($errors->has('kategori_id'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('kategori_id') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('stok','Jumlah',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('stok',$data->stok, ['class'=>$errors->has('stok') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Jumlah'])!!}
    @if ($errors->has('stok'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('stok') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('satuan','Satuan',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('satuan',$data->satuan, ['class'=>$errors->has('satuan') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Satuan'])!!}
    @if ($errors->has('satuan'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('satuan') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('harga','Harga',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('harga',$data->harga, ['class'=>$errors->has('harga') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Harga'])!!}
    @if ($errors->has('harga'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('harga') }}</p>
              </span>
    @endif
</div>

<div class="form-group row">
    {!! Form::label('tipe_komisi','Tipe Komisi',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::select('tipe_komisi',[''=>'Pilih Tipe Komisi','fix'=>'Fix','persen'=>'Persen'],$data->tipe_komisi, ['class'=>$errors->has('tipe_komisi') ? 'col-sm-6 form-control is-invalid select2':'col-sm-6 form-control select2'])!!}
    @if ($errors->has('tipe_komisi'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('tipe_komisi') }}</p>
              </span>
    @endif
</div>
<div class="form-group row">
    {!! Form::label('komisi','Komisi',['class'=>'col-sm-4 col-form-label']) !!}
    {!!  Form::text('komisi',$data->komisi, ['class'=>$errors->has('komisi') ? 'col-sm-6 form-control is-invalid':'col-sm-6 form-control', 'placeholder'=>'Komisi'])!!}
    @if ($errors->has('komisi'))
        <span class="text-danger offset-4 col-sm-10">
                  <p>{{ $errors->first('komisi') }}</p>
              </span>
    @endif
</div>
<div class="card-footer">
    <button id="btnproduk" type="submit" class="btn btn-info">Simpan</button>
</div>
{{ Form::close() }}
@section('script')
    <script>
        $('#btnproduk').click(function (e) {
            e.preventDefault()

            var form=$('#formproduk')
            form.append('<input type="hidden" name="kodebaru" value="'+$('#kode').val()+'" />');
            var formData = new FormData(document.getElementById("formproduk"))

            form.submit();
        })
        $(document).ready(function () {
            var kode="{{ $data->kode }}";
            if(kode===''){
                $.ajax({
                    url:'{{ route('getkodeproduk') }}',
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

        var options =  {
            reverse:true,
            onKeyPress: function(cep, e, field, options) {
                var masks = ['#.##0', '000.000.000.000.000'];
                var mask = (cep.length>7) ? masks[1] : masks[0];
                $("#harga,#komisi").mask(mask, options);
            }};
        $("#harga,#komisi").mask('#.##0', options);
    </script>
    @endsection