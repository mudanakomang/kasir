<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    //
    public function index($tipe){            
        return view('kasir.transaksi.index',['tipe'=>$tipe]);
    }
    public function detail($kode){
        $data=Transaksi::where('kode','=',$kode)->with(['produk'=>function($q){
            $q->selectRaw('produk.*,jumlah * (harga-(harga*diskon/100)) as subtotal');
        }])->with('guide')->first();           
        return view('kasir.transaksi.detail',['data'=>$data,'action'=>'TransaksiController@store']);
    }
    public function listtransaksi(Request $request){
       
        $total=Transaksi::with('produk')->with('guide')->where('status','=',$request->tipe)->get();
        
        $columns=[
            0=>'id',
            1=>'trid',
            2=>'kode',
            3=>'nopol',
            4=>'guide',
            5=>'tipe_byr',
            6=>'total',
            7=>'jumlah_byr',
            8=>'tanggal',
        ];
        $totalData = $total->count();
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');
        $search=$request->input('search.value');

        if (!empty($search)){
             $trx=Transaksi::with('produk')
                 ->where('kode','LIKE',"%$search%")
                ->orWhere('nopol','LIKE',"%$search%")
                ->orWhere('tipe_byr','LIKE',"%$search%")
                ->orWhere('total','LIKE',"%$search%") 
                ->orWhere('jumlah_byr','LIKE',"%$search%")              
                ->offset($start)->limit($limit)->with('guide')->where('status','=',$request->tipe)->orderBy($order,$dir)->get();
               // $output['recordsTotal']=$trx->count();
                //$output['recordsFiltered']=$trx->count();
                $totalFiltered=count($trx);
        }else{
            $trx=Transaksi::with('produk')->with('guide')->offset($start)->limit($limit)->where('status','=',$request->tipe)->orderBy($order,$dir)->get();
        }
        $data=[];
        if(!empty($trx)){
            foreach ($trx as $key=>$prd){
                $subdata['id']=$key+1;
                $subdata['trid']=$prd->id;
                $subdata['kode']=$prd->kode;
                $subdata['nopol']=$prd->nopol;
                $subdata['guide']=$prd->guide->name;
                $subdata['tipe_byr']=$prd->tipe_byr;
                $subdata['total']=$prd->total;
                $subdata['jumlah_byr']=$prd->jumlah_byr;
                $subdata['tanggal']=\Carbon\Carbon::parse($prd->created_at)->format('Y/m/d H:i');           
                $data[]=$subdata;
            }
            $json_array=[
                "draw"=>intval($request->input('draw')),
                "recordsTotal"=>intval($totalData),
                "recordsFiltered"=>intval($totalFiltered),
                "data"=>$data
            ];
           
            return response(json_encode($json_array));
        }
    }
    public function add(){
        $data=Transaksi::where('status','=','proses')->first();
        if (empty($data)){
            $data=new Transaksi();
        }
        return view('kasir.transaksi.manage',['data'=>$data,'action'=>'TransaksiController@store']);
    }
    public function getkodetrx(){
        $trx=Transaksi::orderBy('id','desc')->first();
        if ($trx!=null){
            $id=$trx->id+1;
        }else{
            $id=1;
        }
        $kode=sprintf('TRX-%08d',$id);
        $trx=Transaksi::create(['kode'=>$kode,'status'=>'proses','created_at'=>\Carbon\Carbon::now('Asia/Makassar')->format('Y-m-d H:i:s')]);
        return response($trx);
    }
    public function lanjuttrx(Request $request){
        Transaksi::where('status','=','proses')->delete();
        Transaksi::where('kode','=',$request->kode)->update(['status'=>'proses']);
        return response('ok');
    }
    public function updatetrx(Request $request)
    {
           //dd($request->nopol);
           $prd = Produk::find($request->produk);           
           $trx = Transaksi::updateOrCreate(['kode' => $request->kode], ['total_byr'=>$request->total,'jumlah_byr' => $request->jumlah_byr, 'status' => 'proses']);
           
           if ($trx->produk->isEmpty()) {
               $trx->produk()->attach($prd->id, ['jumlah' => 1]);
           } else {
               $item = $trx->with(['produk' => function ($q) use ($prd) {
                   $q->where('id', '=', $prd->id);
               }])->where('kode','=',$request->kode)->first();
               if ($item->produk->isNotEmpty()) {
                   $jum = $item->produk->first()->pivot->jumlah;
                   $trx->produk()->sync([$prd->id => ['jumlah' => $jum + 1]], false);
               } else {
                   $trx->produk()->attach($prd->id, ['jumlah' => 1]);
               }
           }
           $res = $trx->with(['produk' => function ($q) use ($prd) {
            $q->where('id', '=', $prd->id);
        }])->where('kode','=',$request->kode)->with('guide')->first();
        return response($res);
    }
    public function loadtrx(Request $request){
        $trx=Transaksi::with(['produk'=>function($q){
                $q->selectRaw('produk.*,jumlah * (harga-(harga*diskon/100)) as subtotal');
            }])->with('guide')->where('status','=','proses')->first();           
        if ($trx==null){
            $res='error';
        }else{
            $res=$trx;
            $total=0;
            foreach($trx->produk as $sub){
                $total+=$sub->subtotal;
            }           
            $res->total=$total;
        }
       
        
        return response($res);
    }
    public function updatejumlah(Request $request){

        $trx=Transaksi::with(['produk'=>function($q) use ($request){
            $q->where('id','=',$request->produk);
        }])->where('kode','=',$request->kode)->first();       
        $trx->produk()->updateExistingPivot($request->produk,['jumlah'=>$request->jumlah]);
        return response('ok');
    }
    public function updatediskon(Request $request){
        $trx=Transaksi::with(['produk'=>function($q) use ($request){
            $q->where('id','=',$request->produk);
        }])->where('kode','=',$request->kode)->first();
        $trx->produk()->updateExistingPivot($request->produk,['diskon'=>$request->diskon]);;
        return response('ok');
    }
    public function hapusproduk(Request $request){
        $trx=Transaksi::with(['produk'=>function($q) use ($request){
            $q->where('id','=',$request->produk);
        }])->where('kode','=',$request->kode)->first();
        $trx->produk()->detach($request->produk);
        return response('ok');
    }
    public function updatenopol(Request $request){
        Transaksi::where('kode','=',$request->kode)->update(['nopol'=>$request->nopol]);
        $trx=Transaksi::where('kode','=',$request->kode)->with('guide')->first();
        return response($trx);
    }
    public function updateguideid(Request $request){
        Transaksi::where('kode','=',$request->kode)->update(['guide_id'=>$request->guide_id]);
        $trx=Transaksi::where('kode','=',$request->kode)->with('guide')->first();
        return response($trx);
    }
    public function updatetotal(Request $request){
        Transaksi::where('kode','=',$request->kode)->update(['total'=>$request->total,'jumlah_byr'=>$request->byr,'tipe_byr'=>$request->tipe]);
    }

    public function pendingtrx(Request $request){
        Transaksi::where('kode','=',$request->kode)->update(['status'=>'pending']);
        return response('ok');
    }
    public function canceltrx(Request $request){
        Transaksi::where('kode','=',$request->kode)->update(['status'=>'batal']);
        return response('ok');
    }
    public function printtrx(Request $request){       
        Transaksi::where('kode','=',$request->kode)->update(['status'=>'selesai','tipe_byr'=>$request->tipe,'total'=>$request->total,'jumlah_byr'=>$request->byr]);
        return response('ok');
    }
    public function finish(Request $request){
        $trx=Transaksi::where('kode','=',$request->kode)->where('print','=','1')->first();    
        if(!empty($trx)){
            foreach($trx->produk as $produk){              
                $stok=$produk->stok - $produk->pivot->jumlah;
                $produk->update(['stok'=>$stok]);
            }   
            $trx->update(['status'=>'selesai']);
            return response('ok');
        }else{
            return response('no');
        }        
    }
}
