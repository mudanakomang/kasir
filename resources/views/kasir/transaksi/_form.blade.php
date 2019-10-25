<form>
    <div class="form-group row">
        <h3 id="idtransaksi"></h3>
    </div>

    <div class="form-group row">
        {!! Form::label('nopol','Nomor kendaraan',['class'=>'col-sm-3']) !!}
        {!!  Form::select('nopol',[''=>'Cari Nomor Kendaraan']+\App\Kendaraan::pluck('nopol', 'nopol')->all(),null, ['class'=>'col-sm-4 form-control select2','id'=>'nopol','onchange'=>'updateNopol(this.value)'])!!}
    </div>
    <div class="form-group row">
        {!! Form::label('guide_id','Guide',['class'=>'col-sm-3']) !!}
        {!!  Form::select('guide_id',[''=>'Guide']+\App\Guide::pluck('name', 'id')->all(),null, ['class'=>'col-sm-4 form-control select2','id'=>'guide_id','onchange'=>'updateGuide(this.value)'])!!}
    </div>
    <div class="form-group row">

        {!! Form::hidden('kode',null,['id'=>'kode']) !!}
        {!! Form::label('produk','Produk',['class'=>'col-sm-3']) !!}
        {!! Form::select('produk',[''=>'Cari Produk']+\App\Produk::select(DB::raw("CONCAT(kode,' | ',nama) AS nama"),'id')->pluck('nama', 'id')->all(),null, ['class'=>$errors->has('produk') ? 'col-sm-8 form-control is-invalid select2':'col-sm-8 form-control select2','onchange'=>'updateTrx()','id'=>'produk'])!!}

    </div>
</form>
<table id="detailtransaksi" class="table table-hover table-striped dataTable">
    <thead>
    <th>No</th>
    <th>Produk</th>
    <th>Jumlah</th>
    <th>Satuan</th>
    <th>Harga</th>
    <th>Diskon</th>
    <th>Subtotal</th>
    <th>#</th>
    </thead>
</table>
@section('script')
    <script>
         
            $('#selesai').on('click',function(e){
                var kode=$('#kode').val();
                $.ajax({
                    url:'{{ route('finish') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        kode:kode,
                    },success:function(d){
                        if(d==='ok'){
                            location.reload()
                        }
                    }
                })  
            })
            $('#print').on('click',function(e){
                e.preventDefault()
                var kode=$('#kode').val()
                var tipe=$('#tipe_byr').val()
                console.log(tipe)
                var byr=parseInt($('#jumlah_byr').val().replace(/\,/g,'').replace(/\./g,''))                
                var total=parseInt($('#totalbelanja').text().replace('Rp ','').replace(/\,/g,'').replace(/\./g,''))                           
                if(tipe==='' || byr==0 || isNaN(byr) || byr<total){
                    Swal.fire('Gagal','Belum melakukan pembayaran','error')
                }else{                   
                   $.ajax({
                       url:'{{ route('printtrx') }}',
                       type:'POST',
                       data:{
                           _token:'{{ csrf_token() }}',
                           kode:kode,
                           tipe:tipe,
                           byr:byr,
                           total:total,
                       },success:function(e){
                            console.log(e);
                       }
                   })
                }
            });
            $('#batal').on('click',function () {
                $.ajax({
                    url:'{{ route('canceltrx') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        kode:$('#kode').val()
                    },success:function(data){
                        if(data==='ok'){
                          location.reload()
                        }
                    }
                })
            })
            $('#pending').on('click',function(){
                $.ajax({
                    url:'{{ route('pendingtrx') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        kode:$('#kode').val()
                    },success:function(data){
                        if(data==='ok'){
                            loadtable()
                        }
                    }
                })
            })
            function hitungTotal(){
                $('#kembali').html("Rp 0")               
               var tipe = $('#tipe_byr').val()
               var byr=parseInt($('#jumlah_byr').val().replace(/\,/g,'').replace(/\./g,''))               
               var total=parseInt($('#totalbelanja').text().replace('Rp ','').replace(/\,/g,'').replace(/\./g,''))                           
               if(tipe==='cash' || tipe===''){
                   console.log(byr +  ' '+total)
                    if(byr>total){
                        var kembali=byr-total;
                            $('#kembali').html("Rp "+ $.number(kembali,0,'.'))
                    }else{
                         $('#kembali').html("Rp 0")
                    }
               }else{
                $('#kembali').html("Rp 0")
                $('#jumlah_byr').val($.number(total,0,','))
               }
               
            }
            $('#nopol').select2({
                theme:'bootstrap4',
                placeholder:"Pilih nomor kendaraan"
            })
            $('#guide_id').select2({
                theme:'bootstrap4',               
                placeholder:"Pilih Guide"
            })
            $('#tipe_byr').select2({
                theme:'bootstrap4',
               
                placeholder:"Tipe Pembayaran"
            })


            $(document).ready(function () {
               
                loadtable()                              
             })

            function updateGuide(v) {
                $.ajax({
                    url:'{{ route('updateguideid') }}',
                    type:'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        guide_id:v,
                        kode: $('#kode').val()
                    },success:function(d){
                        $("#guide_id").select2({
                         placeholder: "Pilih Guide",
                         theme:'bootstrap4',
                         allowClear:true,
                         initSelection: function(element, callback) {
                             if(d.guide){
                             callback({id: d.guide.id,text:d.guide.name });
                             }
                         }
                     });
                    }
                })
            }
            function updateNopol(v) {
               $.ajax({
                   url:'{{ route('updatenopol') }}',
                   type:'POST',
                   data:{
                       _token:'{{ csrf_token() }}',
                       nopol:v,
                       kode: $('#kode').val()
                   },success:function(d){
                           $("#nopol").select2({
                               placeholder: "Pilih Guide",
                               theme:'bootstrap4',
                               allowClear:true,
                               initSelection: function(element, callback) {
                                   if(d.nopol){
                                       callback({id: d.nopol,text:d.nopol });
                                   }
                               }
                        });
                   }
               })
            }
         function updateTrx() {               
            $('#kembali').html("Rp 0")     
             $.ajax({
                 url: '{{ route('updatetrx') }}',
                 type: 'POST',
                 data: {
                     _token: '{{ csrf_token() }}',
                     kode:$('#kode').val(),
                     //nopol: $('#nopol').val(),
                     produk: $('#produk').val(),                     
                     total:parseFloat($('#totalbelanja').text().replace('Rp ','').replace(/\,/g,'').replace(/\./g,'')),
                     //tipe_byr:$('#tipe_byr').select2().val()
                 }, success: function (data) {                     
                     loadtable()  
                                                         
                     $("#produk").select2({
                         placeholder: "Pilih produk",
                         theme:'bootstrap4',
                         initSelection: function(element, callback) {

                         }
                     });
                     $("#nopol").select2({
                         placeholder: "Pilih nomor kendaraan",
                         theme:'bootstrap4',
                         initSelection: function(element, callback) {
                             callback({id: data.nopol, text: data.nopol });
                         }
                     });
                     $("#guide_id").select2({
                         placeholder: "Pilih Guide",
                         theme:'bootstrap4',
                         initSelection: function(element, callback) {
                             if(data.guide){
                             callback({id: data.guide.id,text:data.guide.name });
                             }
                         }
                     });


                     $("#produk").select2("val","");

                 }
             })
         }
        function loadtable() {
            $.ajax({
                url:'{{ route('loadtrx') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
//                    kode:Cookies.get('kode'),
                },success:function (data) {
                    if (data === 'error') {
                            $.ajax({
                                url:'{{ route('getkodetrx') }}',
                                type:'POST',
                                data:{
                                    _token:'{{ csrf_token() }}'
                                },success:function (d) {
                                    // $('#totalbelanja').html("Rp 0")
                                  //  Cookies.set('kode',d.kode,{ expires : 60 })
                                    $('#idtransaksi').html("Kode Transaksi: "+ d.kode)
                                    $('#kode').val(d.kode)   
                                                                   
                                    $("#nopol").select2({
                                        placeholder: "Pilih nomor kendaraan",
                                        theme:'bootstrap4',
                                        //allowClear:true,
                                        initSelection: function(element, callback) {

                                        }
                                    });
                                    $("#guide_id").select2({
                                        placeholder: "Pilih Guide",
                                        theme:'bootstrap4',
                                       // allowClear:true,
                                        initSelection: function(element, callback) {

                                        }
                                    });
                                   $("#produk").select2({
                                        placeholder: "Pilih Guide",
                                        theme:'bootstrap4',
                                        initSelection: function(element, callback) {

                                        }
                                    });
                                }
                            });

                    } else {                        
                        $('#jumlah_byr').val($.number(data.jumlah_byr,0,','))
                        $('#tipe_byr').select2({
                            placeholder: "Jenis Pembayaran",
                            theme:'bootstrap4',
                           // allowClear:true,
                            initSelection: function(element, callback) {
                                if(data.tipe_byr){
                                    console.log(data.tipe_byr)
                                    callback({id: data.tipe_byr, text: data.tipe_byr.charAt(0).toUpperCase() + data.tipe_byr.slice(1) });
                                }                               
                            }
                        })
                        $("#nopol").select2({
                            placeholder: "Pilih nomor kendaraan",
                            theme:'bootstrap4',
                           // allowClear:true,
                            initSelection: function(element, callback) {
                                callback({id: data.nopol, text: data.nopol });
                            }
                        });
                        $("#guide_id").select2({
                         placeholder: "Pilih Guide",
                         theme:'bootstrap4',
						 // allowClear:true,
                         initSelection: function(element, callback) {
                             if(data.guide){
                             callback({id: data.guide.id,text:data.guide.name });
                             }
                         }
                     });

                        $('#detailtransaksi').DataTable().destroy();
                        $('#idtransaksi').html("Kode Transaksi: "+ data.kode)
                        $('#kode').val(data.kode) 
                                      
                      
                        $('#totalbelanja').html("Rp "+ $.number(data.total,0,'.'))
                        var dataset=JSON.parse(JSON.stringify(data.produk))
                        var table = $('#detailtransaksi').DataTable({
                        data:dataset,
                        searching:false,
                        paging:   false,
                        ordering: false,
                        dataType:'json',
                        info:false,
                        columns:[
                            {data:null},
                            {data:'nama'},
                            {data:null},
                            {data:'satuan'},
                            {data:'harga'},
                            {data:null},
                            {data:'subtotal'},
                            {data:null},
                        ],columnDefs:[{
                            targets:0,
                            render:function (data,t,r,m) {
                                return m.row+1
                            }
                        },{
                            targets:2,
                            render:function (data) {                              
                                return "<input type=number name=jumlah style=width:45px id="+data.id+" value="+data.pivot.jumlah+" autocomplete='off' onchange='updateJumlah(this.id,this.value)' oninput='this.onchange()'   >"
                            }
                        },{
                            targets:[4,6],
                            render: $.fn.dataTable.render.number( '.', ',', 0,'Rp. ' )
                        },{
                            targets:5,
                            render:function(data){                             
                                return "<input type=number name=diskon style=width:45px step=5 id="+data.id+" value="+data.diskon+" autocomplete='off' onchange='updateDiskon(this.id,this.value)' oninput='this.onchange()'   > %"
                            }
                        },{
                                targets:7,
                                render:function (data) {
                                    return "<a href='javascript:void(0)' onclick='hapusProduk(this.id)' id='"+data.id+"'><i class='fa fa-times-circle text-danger'></i> </a>"
                                }
                            }]
                    });
                    }
                }
            })
            $('#produk').select2({
                theme:'bootstrap4',
                placeholder:"Pilih produk"
            })
        }
        function hapusProduk(id) {
            $.ajax({
                url:'{{ route('hapusproduk') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    produk:id,
                    kode:$('#kode').val()
                },success:function (d) {
                    if(d==='ok'){
                        loadtable()                      
                    }
                }
            })
        }
        function updateDiskon(id,disk){
            $.ajax({
                url:'{{ route('updatediskon') }}',
                type:'POST',
                data:{
                    _token:'{{ csrf_token() }}',
                    kode:$('#kode').val(),
                    produk:id,
                    diskon:disk
                },success:function(d){
                     if(d==='ok'){
                        loadtable() 
                     }   
                }
            })
        }
        function updateJumlah(id,jum) {
            $('#kembali').html("Rp 0")
          $.ajax({
              url:'{{ route('updatejumlah') }}',
              type:'POST',
              data:{
                  _token:'{{ csrf_token() }}',
                  kode:$('#kode').val(),
                  produk:id,
                  jumlah:jum,                 
              },success:function (d) {
                 if(d==='ok') {                 
                    loadtable()                    
                 }
              }
          })
        }
            var options =  {
                reverse:true,
                onKeyPress: function(cep, e, field, options) {
                    var masks = ['#.##0', '000.000.000.000.000'];
                    var mask = (cep.length>7) ? masks[1] : masks[0];
                    $("#jumlah_byr").mask(mask, options);
                }};
            $("#jumlah_byr").mask('#.##0', options);
    </script>
    @endsection