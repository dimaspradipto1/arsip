<?php

namespace App\Http\Controllers;

use App\DataTables\SkPengujiSemproDataTable;
use App\Exports\SkPengujiSemproTemplateExport;
use App\Http\Requests\SkPengujiSemproRequest;
use App\Imports\SkPengujiSemproImport;
use App\Models\SkPengujiSempro;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SkPengujiSemproController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPengujiSemproDataTable $dataTable)
    {
        return $dataTable->render('pages.skpengujisempro.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpengujisempro.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPengujiSemproRequest $request)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        $skSempro = SkPengujiSempro::create($data);

        if (!empty($userIds)) {
            $skSempro->users()->sync($userIds);
        }

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujisempro.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPengujiSempro $skpengujisempro)
    {
        return redirect()->route('skpengujisempro.edit', $skpengujisempro->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPengujiSempro $skpengujisempro)
    {
        $skpengujisempro->load('users');
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpengujisempro.edit', compact('tahunakademik', 'users', 'skpengujisempro'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPengujiSemproRequest $request, SkPengujiSempro $skpengujisempro)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        $skpengujisempro->update($data);
        $skpengujisempro->users()->sync($userIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujisempro.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpengujisempro = SkPengujiSempro::findOrFail($id);
        $skpengujisempro->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujisempro.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SkPengujiSemproImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujisempro.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SkPengujiSemproTemplateExport, 'Template_SK_Penguji_Sempro.xlsx');
    }
}

