<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Imports\UserImport;
use Illuminate\Http\Request;
use App\DataTables\UserDataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $currentUser = Auth::user();

        $dosenQuery = User::whereRole('dosen');
        if ($currentUser && !$currentUser->hasRole('admin')) {
            $dosenQuery->facultyScope($currentUser);
        }

        $totalDosen = (clone $dosenQuery)->count();

        $dosenPerProdi = (clone $dosenQuery)
            ->select('homebase', \Illuminate\Support\Facades\DB::raw('count(*) as total'))
            ->groupBy('homebase')
            ->orderByDesc('total')
            ->get();

        return $dataTable->render('pages.user.index', compact('totalDosen', 'dosenPerProdi'));
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
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['string', 'in:admin,tatausaha,dosen,dekan,wakilDekan1,wakilDekan2,kaprodi,sekprodi'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'homebase' => ['nullable', 'string', 'max:255'],
        ]);

        User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'roles'    => $validated['roles'],
            'fakultas' => $validated['fakultas'] ?? null,
            'homebase' => $validated['homebase'] ?? null,
        ]);

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
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
            'roles'    => ['required', 'array', 'min:1'],
            'roles.*'  => ['string', 'in:admin,tatausaha,dosen,dekan,wakilDekan1,wakilDekan2,kaprodi,sekprodi'],
            'fakultas' => ['nullable', 'string', 'max:255'],
            'homebase' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6'],
        ]);

        $data = [
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'roles'    => $validated['roles'],
            'fakultas' => $validated['fakultas'] ?? null,
            'homebase' => $validated['homebase'] ?? null,
        ];

        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

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
        $file = $request->file('file') ?? $request->file('excel_file');
        if ($file) {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\UserImport, $file);
            Alert::success('Berhasil', 'Data pengguna telah berhasil diimpor')->autoclose(3000)->toToast();
        }
        return redirect()->route('user.index');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\UserTemplateExport, 'Template_Pengguna.xlsx');
    }
}
