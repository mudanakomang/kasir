<?php

namespace App\Http\Controllers;

use App\Guide;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JDate;
use Illuminate\Support\Facades\URL;
use Validator;


class GuideController extends Controller
{
    //
    public function index(){
        return view('admin.guide.index');
    }
    public function listguide(Request $request){
        $draw=$request->draw;
        $length=$request->length;
        $start=$request->start;
        $search=$request->search['value'];
        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];
        $total=Guide::count();
        $guides=Guide::offset($start)->limit($length)->orderBy($columnName,$columnSortOrder)->get();
        $output=[];
        $output['draw']=$draw;
        $output['recordsTotal']=$total;
        $output['recordsFiltered']=$total;
        $output['data']=[];

        if(!empty($search)){
            $guides=Guide::where('name','LIKE',"%$search%")
                ->orWhere('telp','LIKE',"%$search%")
                ->orWhere('tgl_masuk','LIKE',"%$search%")
                ->orWhere('honor','LIKE',"%$search%")
                ->offset($start)->limit($length)->orderBy($columnName,$columnSortOrder)->get();
            $output['recordsTotal']=$guides->count();
            $output['recordsFiltered']=$guides->count();
        }
        foreach ($guides as $key=>$guide) {
            $subdata['id']=$key+1;
            $subdata['guideid']=$guide->id;
            $subdata['name']=$guide->name;
            $subdata['telp']=$guide->telp;
            $subdata['tgl_masuk']=$guide->tgl_masuk;
            $subdata['honor']=$guide->honor;
            $output['data'][]=$subdata;
        }
        return response(json_encode($output));
    }
    public function edit($id){
        $guide=Guide::find($id);
        return view('admin.guide.manage',['data'=>$guide,'action'=>['GuideController@update','id'=>$id]]);
    }
    public function add(){
        $guide=new Guide();
        return view('admin.guide.manage',['data'=>$guide,'action'=>'GuideController@store']);
    }
    public function store(Request $request){
       // dd($request->tgl_masuk);
        JDate::setLocale('id');
        $rules=[
            'name'=>'required',
            'telp'=>'numeric|nullable',
            'tgl_masuk'=>'required',

        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'telp.numeric'=>'Format penulisan salah',
            'tgl_masuk.required'=>'Tanggal masuk harus diisi',

        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            \Carbon\Carbon::setLocale('id');
            $guide=new Guide();
            $guide->name=$request->name;
            $guide->telp=$request->telp;
            $guide->tgl_masuk=JDate::parse($request->tgl_masuk)->format('Y-m-d');
            if(!empty($request->honor)){
                $honor=str_replace('.','',$request->honor);
            }else{
                $honor=0;
            }
            $guide->honor=$honor;
            $guide->save();
            return redirect(route('guide'));
        }
    }
    public function update(Request $request,$id){
        $rules=[
            'name'=>'required',
            'telp'=>'numeric|nullable',
            'tgl_masuk'=>'required',

        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'telp.numeric'=>'Format penulisan salah',
            'tgl_masuk.required'=>'Tanggal masuk harus diisi',

        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            if (!empty($request->honor)){
                $honor=str_replace('.','',$request->honor);
            }else{
                $honor=0;
            }
            \Carbon\Carbon::setLocale('id');
            $guide=Guide::find($id);
            $guide->name=$request->name;
            $guide->telp=$request->telp;
            $guide->tgl_masuk=JDate::parse($request->tgl_masuk)->format('Y-m-d');
            $guide->honor=$honor;
            $guide->save();
            return redirect(route('guide'));
        }
    }
    public function delete(Request $request){
        $guide=Guide::find($request->id);
        $guide->delete();
        return response('success',200);
    }
}
