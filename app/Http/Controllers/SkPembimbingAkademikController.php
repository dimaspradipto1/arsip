<?php

namespace App\Http\Controllers;

use App\DataTables\SkPembimbingAkademikDataTable;
use App\Http\Requests\SkPembimbingAkademikRequest;
use App\Models\SkPembimbingAkademik;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SkPembimbingAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPembimbingAkademikDataTable $dataTable)
    {
        return $dataTable->render('pages.skpembimbingakademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpembimbingakademik.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPembimbingAkademikRequest $request)
    {
        $data = $request->validated();

        // If prodi not filled, use user's homebase if available
        if (empty($data['prodi']) && !empty($data['user_id'])) {
            $user = User::find($data['user_id']);
            if ($user && $user->homebase) {
                $data['prodi'] = $user->homebase;
            }
        }

        SkPembimbingAkademik::create($data);

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingakademik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPembimbingAkademik $skpembimbingakademik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPembimbingAkademik $skpembimbingakademik)
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpembimbingakademik.edit', compact('tahunakademik', 'users', 'skpembimbingakademik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPembimbingAkademikRequest $request, SkPembimbingAkademik $skpembimbingakademik)
    {
        $data = $request->validated();

        // If prodi not filled, use user's homebase if available
        if (empty($data['prodi']) && !empty($data['user_id'])) {
            $user = User::find($data['user_id']);
            if ($user && $user->homebase) {
                $data['prodi'] = $user->homebase;
            }
        }

        $skpembimbingakademik->update($data);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingakademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpembimbingakademik = SkPembimbingAkademik::findOrFail($id);
        $skpembimbingakademik->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingakademik.index');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SkPembimbingAkademikImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingakademik.index');
    }

    public function downloadTemplate()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SkPembimbingAkademikTemplateExport, 'Template_SK_Pembimbing_Akademik.xlsx');
    }
}
