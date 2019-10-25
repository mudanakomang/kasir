<?php

namespace App\Http\Controllers;

use App\Produk;
use App\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    //
    public function index(){

        return view('kasir.transaksi.index');
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
        $trx=Transaksi::create(['kode'=>$kode,'status'=>'proses']);
        return response($trx);
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
        $trx->produk()->where('id','=',$request->produk)->update(['diskon'=>$request->diskon]);
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
            $trx->update(['status'=>'selesai']);
            return response('ok');
        }else{
            return response('no');
        }        
    }
}
