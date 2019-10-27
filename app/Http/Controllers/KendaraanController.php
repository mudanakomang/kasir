<?php

namespace App\Http\Controllers;

use App\Kendaraan;
use Illuminate\Http\Request;
use Validator;

class KendaraanController extends Controller
{
    //
    public function index(){
        return view('konter.kendaraan');
    }
    public function listnopol(Request $request){

        $yesterday=Kendaraan::whereDate('created_at','<=',\Carbon\Carbon::now()->subDay())->get();
        foreach( $yesterday as $ys){
            $ys->delete();
        }
        $draw=$request->draw;
        $length=$request->length;
        $start=$request->start;
        $search=$request->search['value'];
        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];
        $total=Kendaraan::whereDay('created_at','=',date('d'))->count();
      
        $kendaraan=Kendaraan::whereDay('created_at','=',date('d'))->offset($start)->limit($length)->orderBy($columnName,$columnSortOrder)->get();
        $output=[];
        $output['draw']=$draw;
        $output['recordsTotal']=$total;
        $output['recordsFiltered']=$total;
        $output['data']=[];
        if(!empty($search)){
            $kendaraan=Kendaraan::whereDay('created_at','=',date('d'))->where('nopol','LIKE',"%$search%")
                ->offset($start)->limit($length)->orderBy($columnName,$columnSortOrder)->get();
            $output['recordsTotal']=$output['recordsFiltered']=$kendaraan->count();
        }
        foreach ($kendaraan as $key=>$knd){
            $subdata['id']=$key+1;
            $subdata['nopolid']=$knd->id;
            $subdata['nopol']=$knd->nopol;
            $subdata['tgl_masuk']=$knd->created_at;
            $output['data'][]=$subdata;
        }
        return response(json_encode($output));
    }
    public function savenopol(Request $request){
        $rules=[
            'nopol'=>'required'
        ];
        $messages=[
            'nopol.required'=>'Nomor polisi harus diisi'
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return response($validator->errors());
        }else {
            $nopol=str_replace(' ','',$request->nopol);
            $nopol=strtoupper($nopol);
            Kendaraan::updateOrCreate(['nopol' => $nopol], ['nopol' => $nopol]);
            return response('success', 200);
        }
    }
    public function deletenopol(Request $request){
        $nopol=Kendaraan::find($request->id);
        $nopol->delete();
    }
}
