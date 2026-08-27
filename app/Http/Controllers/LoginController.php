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

    public function portal()
    {
        if (!Auth::check()) {
            return redirect(route('login'));
        }

        $user = Auth::user();
        $roles = $user->roles;

        if (count($roles) <= 1) {
            session(['active_role' => $roles[0] ?? 'dosen']);
            return redirect(route('dashboard'));
        }

        return view('layouts.auth.portal', compact('roles', 'user'));
    }

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
            $user = Auth::user();
            $roles = $user->roles;
            
            if (count($roles) > 1) {
                session()->forget('active_role');
                return redirect(route('portal'));
            } else {
                session(['active_role' => $roles[0] ?? 'dosen']);
                Alert::success('success', 'Login successful')->autoclose(2000)->toToast()->iconHtml('<i class="far fa-thumbs-up"></i>');
                return redirect(route('dashboard'));
            }
        } else {
            Alert::error('error', 'Invalid credentials')->autoclose(2000)->toToast();
            return redirect(route('login'));
        }
    }

    public function switchRole(Request $request)
    {
        $role = $request->input('role');
        $user = Auth::user();
        if ($user && $user->hasRole($role)) {
            session(['active_role' => $role]);
            return response()->json(['status' => 'success', 'redirect' => route('dashboard')]);
        }
        return response()->json(['status' => 'error', 'message' => 'Role tidak valid'], 400);
    }

    public function switchRoleGet(string $role)
    {
        $user = Auth::user();
        if ($user && $user->hasRole($role)) {
            session(['active_role' => $role]);
            Alert::success('Berhasil', 'Berhasil beralih ke peran ' . ucfirst($role))->autoclose(2000)->toToast();
            return redirect(route('dashboard'));
        }
        Alert::error('Gagal', 'Peran tidak ditemukan')->autoclose(2000)->toToast();
        return redirect(route('dashboard'));
    }
}
