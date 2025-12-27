<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UserDataTable $dataTable)
    {
        return $dataTable->render('pages.user.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'isAdmin' => ['nullable', 'boolean'],
            'isDosen' => ['nullable', 'boolean'],
        ]);

        // Mengambil nilai dari form (nilai default 0 jika checkbox tidak dicentang)
        $isAdmin = $request->input('isAdmin', 0);  // 0 jika tidak dipilih
        $isDosen = $request->input('isDosen', 0);  // 0 jika tidak dipilih

        // Membuat user baru
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'isAdmin' => $isAdmin,  // Menyimpan nilai isAdmin
            'isDosen' => $isDosen,  // Menyimpan nilai isDosen
        ]);

        // Menampilkan pesan sukses dan redirect
        Alert::success('Success', 'Pengguna berhasil ditambahkan')->autoclose(2000)->toToast();
        return redirect()->route('user.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('pages.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'isAdmin' => $request->isAdmin ? 1 : 0,
            'isDosen' => $request->isDosen ? 1 : 0,
        ]);

        if ($request->password) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        Alert::success('Success', 'Pengguna berhasil diubah')->autoclose(2000)->toToast();
        return redirect()->route('user.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        Alert::success('Success', 'Pengguna berhasil dihapus')->autoclose(2000)->toToast();
        return redirect()->route('user.index');
    }

    public function showUpdatePasswordForm($id)
    {
        $users = User::findOrFail($id);
        return view('pages.user.updatePassword', compact('users'));
    }
    
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->password = Hash::make($request->new_password);
        $user->save();
        Alert::success('Success', 'Password berhasil diubah')->autoclose(2000)->toToast();
        return redirect()->route('user.index');
    }

     public function import(Request $request)
    {
        $file = $request->file('excel_file');
        Excel::import(new UserImport, $file);
        Alert::success('Success', 'Data telah berhasil diimpor')->autoclose(2000)->toToast();
        return redirect()->route('user.index');
    }
}
