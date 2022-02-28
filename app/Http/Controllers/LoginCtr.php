<?php

namespace App\Http\Controllers;

use App\Models\LoginMaster;
use App\Models\RoleMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginCtr extends Controller
{
    //
    public function login()
    {
        if (Session()->has('loggedData')) {
            return redirect()->route('dashboard');
        }
        return view('login.login');
    }

    public function auth(Request $request)
    {
        if (Session()->has('loggedData')) {
            return redirect()->route('dashboard');
        }
        $request->validate([
            'username' => 'required|email',
            'password' => 'required'
        ]);
        $user = LoginMaster::where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $request->session()->put('loggedData', $user);
                return redirect()->route('dashboard'); //->with('message', 'Welcome, Have a nice Day!');
            } else {
                return back()->with('error', 'Incorrect Password');
            }
        } elseif (!$user) {
            return back()->with('error', 'Username does not exist.');
        } else {
            return back()->with('error',  "No User Found");;
        }
    }

    public function list()
    {
        $data = LoginMaster::get();
        return view('login.list', compact('data'));
    }

    public function form($id = 0)
    {
        $data = [];
        if (!empty($id)) {
            $data = LoginMaster::where('login_id', $id)->first();
        }

        $roles = RoleMaster::all();
        return view('login.form', compact('data','roles'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'designation' => 'required',
            'role' => 'required',
            'username' => 'required|email',
            'password' => 'required'
        ]);
        // return $request->login_id;
        if (!empty($request->login_id)) {
            $data = LoginMaster::where('login_id', '=', $request->login_id)->first();
        } else {
            $data = new LoginMaster;
        }
        $data->name = $request->name;
        $data->designation = $request->designation;
        $data->role = $request->role;
        $data->username = $request->username;
        if (!empty($request->password)) {
            $data->password = Hash::make($request->password);
        }
        $data->created_id = Session()->get('loggedData')['login_id'];
        $data->save();

        return redirect()->route('login.list')->with('message', 'Successfully saved.');;
    }

    public function delete($id)
    {
        LoginMaster::where('login_id', $id)->delete();
        return redirect()->route('login.list')->with('message', 'Successfully deleted.');;
    }
}
