<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Validator;

class KaryawanController extends Controller
{
    //
    public function index(){
        return view('admin.karyawan.index');
    }
    public function listkaryawan(Request $request){
        $draw=$request->draw;
        $length=$request->length;
        $start=$request->start;
        $search=$request->search['value'];
        $columnIndex = $request->order[0]['column'];
        $columnName = $request->columns[$columnIndex]['data'];
        $columnSortOrder = $request->order[0]['dir'];

        $total=User::with('roles')->count();
        $users=User::with('roles')->limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
        $output=[];
        $output['draw']=$draw;
        $output['recordsTotal']=$total;
        $output['recordsFiltered']=$total;
        $output['data']=[];

        if(!empty($search)){
            $users=User::with(['roles'=>function($q) use ($search){
                 $q->where('name','LIKE',"%$search%");
            }])->where('username','LIKE',"%$search%")->orWhere('name','LIKE',"%$search%")
                ->limit($length,$start)->orderBy($columnName,$columnSortOrder)->get();
            $output['recordsTotal']=$users->count();
            $output['recordsFiltered']=$users->count();
        }

        foreach ($users as $key=>$user) {
            $subdata['id']=$key+1;
            $subdata['userid']=$user->id;
            $subdata['name']=$user->name;
            $subdata['username']=$user->username;
            $subdata['role']=$user->roles[0]->description;
            $output['data'][]=$subdata;
        }
        return response(json_encode($output));
    }
    public function delete(Request $request){
        $user=User::find($request->id);
        $user->roles()->detach();
        $user->delete();
        return response('success',200);
    }
    public function add(){
        $data=new User();
        return view('admin.karyawan.manage',['data'=>$data,'action'=>'']);
    }
    public function edit($id){
        $karyawan=User::find($id);
        return view('admin.karyawan.manage',['data'=>$karyawan,'action'=>'edit']);
    }
    public function update(Request $request){
        $rules=[
          'name'=>'required',
          'username'=>'required|min:6',
          'role'=>'required'
        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'username.required'=>'Nama Pengguna harus diisi',
            'username.min'=>'Nama pengguna minimal karakter 6',
            'role.required'=>'Role harus diisi',
        ];
        $validator=Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else
        {
            $karyawan=User::find($request->id);
            $karyawan->update($request->all());
            $karyawan->roles()->sync($request->role);
            return redirect(route('karyawan'));
        }
    }
    public function store(Request $request){
        $rules=[
          'name'=>'required',
          'username'=>'required|min:6|unique:users',
          'role'=>'required',
          'password'=>'required|confirmed|min:6'
        ];
        $messages=[
            'name.required'=>'Nama harus diisi',
            'username.required'=>'Nama pengguna harus diisi',
            'username.min'=>'Nama pengguna minimal 6 karakter',
            'username.unique'=>'Nama Pengguna sudah digunakan',
            'role.required'=>'Role harus diisi',
            'password.min'=>'Password minimal 6 karakter',
            'password.confirmed'=>'Konfirmasi password tidak sesuai',
            'password.required'=>'Password harus diisi'
        ];
        $validator =Validator::make($request->all(),$rules,$messages);
        if ($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $karyawan=new User();
            $karyawan->name=$request->name;
            $karyawan->username=$request->username;
            $karyawan->password=bcrypt($request->password);
            $karyawan->save();
            $karyawan->roles()->attach($request->role);
            return redirect(route('karyawan'));
        }
    }
}
