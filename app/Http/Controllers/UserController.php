<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $title = "User Management";
        $users = User::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        return view('user.list', compact('title', 'users'));
    }

    public function create(Request $request)
    {
        if($request->isMethod('POST')){
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required',
                'mobile' => 'required|digits:10',
                'password' => 'required|min:8',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $check_exist = $this->exist_data($request);
            if($check_exist){
                return redirect()->back()->with('error', 'User already exist.');
            }
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->password = Hash::make($request->password);
            $user->status = $request->status;
            $user->save();
            return redirect()->route('user.index')->with('success', 'User created successfully.');
        }
        $title = "Create User";
        return view('user.index', compact('title'));
    }

    public function edit($id)
    {
        if (!$id) {
            return redirect()->route('user.index')->with('error', 'Invalid User ID.');
        }

        $title = "Edit User";
        $user = User::find($id);
        $users = User::where('status', '!=', 3)->orderBy('id', 'desc')->get();
        return view('user.index', compact('title', 'users', 'user'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'mobile' => 'required|digits:10',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $check_exist = $this->exist_data($request,$request->hidden_id);
        if($check_exist){
            return redirect()->back()->with('error', 'User already exist.');
        }
        $user = User::find($request->hidden_id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function delete($id)
    {
        if (!$id) {
            return redirect()->route('user.index')->with('error', 'Invalid User ID.');
        }

        User::where('id', $id)->update(['status' => 3]);
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
    public function exist_data($data,$id=''){
        $query = User::where('email',$data['title'])->orWhere('mobile',$data['mobile'])->where('status','!=',3);
        if(!empty($id)){
            $query->where('id','!=',$id);
        }
        $check_role = $query->first();
        if($check_role){
            return true;
        }
    }

}
