<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\LoginprosesRequest;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.auth.login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('login'));
    }

    // public function loginproses(LoginprosesRequest $request)
    // {
    //     // Validasi email dan password menggunakan Auth::attempt
    //     if (Auth::attempt($request->only('email', 'password'))) {
    //         Alert::success('Success', 'Login berhasil')->toToast(3000);
    //         return redirect()->route('dashboard');
    //     }

    //     Alert::error('Error', 'Login gagal. Cek kembali email atau password Anda.')->toToast(3000);
    //     return redirect()->route('login')->withInput();
    // }

    public function loginproses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if ($validator->fails()) {
            Alert::error('error', 'Login failed')->autoclose(2000)->toToast();
            return redirect(route('login'));
        }
    
        $credentials = $request->only('email', 'password');
    
        if (Auth::attempt($credentials)) {
            Alert::success('success', 'Login successful')->autoclose(2000)->toToast()->iconHtml('<i class="far fa-thumbs-up"></i>');
            return redirect(route('dashboard'));
        } else {
            Alert::error('error', 'Invalid credentials')->autoclose(2000)->toToast();
            return redirect(route('login'));
        }
    }
}
