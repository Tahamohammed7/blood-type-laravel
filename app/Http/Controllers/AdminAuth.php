<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuth extends Controller
{
    public function login()
    {
        return view('admin.login');
    }
    public function dologin()
    {
        $rememberme = request('remember') == 1?true:false;
        if (auth()->guard()->attempt(['email' => request('email'),'password' => request('password')],$rememberme)){
            return redirect('home');
        } else {
            flash()->success('Errors');
            return redirect('login');
        }
    }
    public function logout()
    {
        auth()->guard()->logout();
        return redirect('admin/login');
    }
}
