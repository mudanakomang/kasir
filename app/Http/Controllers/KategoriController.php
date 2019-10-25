<?php

namespace App\Http\Controllers;

use App\Kategori;
use Illuminate\Http\Request;
use Validator;

class KategoriController extends Controller
{
    //
    public function index(){
        return view('admin.produk.kategori.index');
    }
    public function listkategori(Request $request){
        $draw=$request->draw;
        $length=$request->length;
        $start=$request->start;
        $search=$request->search['value'];
        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];
        $total=Kategori::count();
        $kategories=Kategori::limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
        $output=[];
        $output['draw']=$draw;
        $output['recordsTotal']=$total;
        $output['recordsFiltered']=$total;
        $output['data']=[];

        if(!empty($search)){
            $kategories=Kategori::where('kode','LIKE',"%$search%")
                ->orWhere('nama','LIKE',"%$search%")
                ->orWhere('keterangan','LIKE',"%$search%")
                ->limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
            $output['recordsTotal']=$kategories->count();
            $output['recordsFiltered']=$kategories->count();
        }
        foreach ($kategories as $key=>$kategori){
            $subdata['id']=$key+1;
            $subdata['kategoriid']=$kategori->id;
            $subdata['kode']=$kategori->kode;
            $subdata['nama']=$kategori->nama;
            $subdata['keterangan']=$kategori->keterangan;
            $output['data'][]=$subdata;
        }
        return response(json_encode($output));
    }
    public function add(){
        $kategori=new Kategori();
        return view('admin.produk.kategori.manage',['data'=>$kategori,'action'=>'KategoriController@store']);
    }
    public function edit($id){
        $kategori=Kategori::find($id);
        return view('admin.produk.kategori.manage',['data'=>$kategori,'action'=>['KategoriController@update','id'=>$id]]);
    }
    public function store(Request $request){
        $rules=[
            'nama'=>'required',
        ];
        $messages=[
            'nama.required'=>'Kategori harus diisi',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $kat=new Kategori();
            $kat->kode=$request->kodebaru;
            $kat->nama=$request->nama;
            $kat->keterangan=$request->keterangan;
            $kat->save();
            return redirect(route('kategori'));
        }
    }
    public  function update(Request $request,$id){
        $rules=[
            'nama'=>'required'
        ];
        $messages=[
            'nama.required'=>'Kategori harus diisi'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $kat=Kategori::find($id);
            $kat->nama=$request->nama;
            $kat->keterangan=$request->keterangan;
            $kat->save();
            return redirect(route('kategori'));
        }
    }
    public function getkategorikode(){
        $kat=Kategori::orderBy('id', 'desc')->first();
        if($kat!=null){
            $id=$kat->id+1;
        }else{
            $id=1;
        }
        $kode=sprintf('KAT-%05d',$id);
        return response($kode);
    }
    public function deletekategori(Request $request){
        $kat=Kategori::find($request->id);
        $kat->delete();
        return response('success',200);
    }
}
