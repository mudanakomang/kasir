<?php

namespace App\Http\Controllers;

use App\Produk;
use Illuminate\Http\Request;
use Validator;

class ProdukController extends Controller
{
    //
    public function index(){
        return view('admin.produk.index');
    }
    public function listproduk(Request $request){
        $draw=$request->draw;
        $length=$request->length;
        $start=$request->start;
        $search=$request->search['value'];
        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];
        $total=Produk::with('kategori')->count();
        $produk=Produk::with('kategori')->limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
        $output=[];
        $output['draw']=$draw;
        $output['recordsTotal']=$total;
        $output['recordsFiltered']=$total;
        $output['data']=[];

        if (!empty($search)){
             $produk=Produk::with('kategori')
                 ->where('kode','LIKE',"%$search%")
                ->orWhere('nama','LIKE',"%$search%")
                ->orWhere('stok','LIKE',"%$search%")
                ->orWhere('satuan','LIKE',"%$search%")
                ->orWhere('harga','LIKE',"%$search%")
                ->orWhere('tipe_komisi','LIKE',"%$search%")
                ->orWhere('komisi','LIKE',"%$search%")
                ->limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
                $output['recordsTotal']=$produk->count();
                $output['recordsFiltered']=$produk->count();
        }
        foreach ($produk as $key=>$prd){
            $subdata['id']=$key+1;
            $subdata['produkid']=$prd->id;
            $subdata['kode']=$prd->kode;
            $subdata['nama']=$prd->nama;
            $subdata['kategori_id']=$prd->kategori->nama;
            $subdata['stok']=$prd->stok;
            $subdata['satuan']=$prd->satuan;
            $subdata['harga']=$prd->harga;
            $subdata['tipe_komisi']=$prd->tipe_komisi;
            $subdata['komisi']=$prd->komisi;
            $output['data'][]=$subdata;
        }
        return response(json_encode($output));
    }
    public function edit($id){
        $prd=Produk::find($id);
        return view('admin.produk.manage',['data'=>$prd,'action'=>['ProdukController@update','id'=>$id]]);
    }
    public function update(Request $request,$id){
        $produk=Produk::find($id);
        $rules=[
            'nama'=>'required',
            'kategori_id'=>'required',
            'stok'=>'required|numeric',
            'satuan'=>'required',
            'harga'=>'required',
            'tipe_komisi'=>'required',
            'komisi'=>'required'

        ];
        $messages=[
            'nama.required'=>'Nama produk harus diisi',
            'kategori_id.required'=>'Kategori harus diisi',
            'stok.required'=>'Stok harus diisi',
            'stok.numeric'=>'Tipe data harus angka',
            'satuan.required'=>'Satuan harus diisi',
            'harga.required'=>'Harga harus diisi',
            'tipe_komisi.required'=>'Tipe komisi harus diisi',
            'komisi.required'=>'Komisi harus diisi'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $produk->kode=$request->kodebaru;
            $produk->nama=$request->nama;
            $produk->kategori_id=$request->kategori_id;
            $produk->stok=$request->stok;
            $produk->satuan=$request->satuan;
            $produk->harga=str_replace('.','',$request->harga);
            $produk->tipe_komisi=$request->tipe_komisi;
            $produk->komisi=str_replace('.','',$request->komisi);
            $produk->save();
            return redirect(route('produk'));
        }
    }
    public function add(){
        $produk=new Produk();
        return view('admin.produk.manage',['data'=>$produk,'action'=>'ProdukController@store']);
    }
    public function store(Request $request){
        $rules=[
            'nama'=>'required',
            'kategori_id'=>'required',
            'stok'=>'required|numeric',
            'satuan'=>'required',
            'harga'=>'required',
            'tipe_komisi'=>'required',
            'komisi'=>'required'

        ];
        $messages=[
            'nama.required'=>'Nama produk harus diisi',
            'kategori_id.required'=>'Kategori harus diisi',
            'stok.required'=>'Stok harus diisi',
            'stok.numeric'=>'Tipe data harus angka',
            'satuan.required'=>'Satuan harus diisi',
            'harga.required'=>'Harga harus diisi',
            'tipe_komisi.required'=>'Tipe komisi harus diisi',
            'komisi.required'=>'Komisi harus diisi'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $prd=new Produk();
            $prd->kode=$request->kodebaru;
            $prd->nama=$request->nama;
            $prd->kategori_id=$request->kategori_id;
            $prd->kategori_id=$request->kategori_id;
            $prd->stok=$request->stok;
            $prd->satuan=$request->satuan;
            $prd->harga=str_replace('.','',$request->harga);
            $prd->tipe_komisi=$request->tipe_komisi;
            $prd->komisi=str_replace('.','',$request->komisi);
            $prd->save();
            return redirect(route('produk'));
        }
    }
    public function delete(Request $request){
        $prd=Produk::find($request->id);
        $prd->delete();
        return response('success',200);
    }
    public function getkodeproduk(){
        $prd=Produk::orderBy('id','desc')->first();
        if ($prd!=null){
            $id=$prd->id+1;
        }else{
            $id=1;
        }
        $kode=sprintf('PRD-%05d',$id);
        return response($kode);
    }
}
