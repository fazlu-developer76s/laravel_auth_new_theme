<?php

namespace App\Http\Controllers;

use App\Models\Role;
use DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index(){
        $title ="Role List";
        $allrole = Role::where('status','!=',3)->orderBy('id','desc')->get();
        return view('role.index', compact('title','allrole'));
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        };
        $check_exist = $this->exist_data($request);
        if($check_exist){
            return redirect()->back()->with('error', 'Role already exist.');
        }
        $role = new Role();
        $role->title = $request->title;
        $role->status = $request->status;
        $role->save();
        return redirect()->route('role.index')->with('success', 'Role created successfully.');

    }

    public function edit($id){
        if(!$id){
            return redirect()->route('role.index')->with('error', 'Invalid Role ID.');
        }
        $title ="Edit Role";
        $get_role = Role::find($id);
        $allrole = Role::where('status','!=',3)->orderBy('id','desc')->get();
        return view('role.index', compact('title','allrole','get_role'));
    }

    public function update(Request $request){
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        };
        $check_exist = $this->exist_data($request,$request->hidden_id);
        if($check_exist){
            return redirect()->back()->with('error', 'Role already exist.');
        }
        $role = Role::find($request->hidden_id);
        $role->title = $request->title;
        $role->status = $request->status;
        $role->save();
        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }

    public function delete($id){
    if(!$id){
            return redirect()->route('role.index')->with('error', 'Invalid Role ID.');
        }
        Role::where('id',$id)->update(['status' => 3]);
        return redirect()->route('role.index')->with('success', 'Role deleted successfully.');
    }

    public function exist_data($data,$id=''){
        $query = Role::where('title',$data['title'])->where('status','!=',3);
        if(!empty($id)){
            $query->where('id','!=',$id);
        }
        $check_role = $query->first();
        if($check_role){
            return true;
        }
    }
    public function change_status(Request $request){
        $table_name = $request->table_name;
        $id = $request->id;
        $status = $request->status;
        $change_status = DB::table($table_name)->where('id', $id)->update(['status' => $status, 'updated_at' => date('Y-m-d H:i:s')]);
        if ($change_status) {
            return response()->json(['status' => 'status changed successfully']);
        } else {
            return response()->json(['status' => false]);
        }
    }
}
