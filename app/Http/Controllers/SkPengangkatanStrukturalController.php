<?php

namespace App\Http\Controllers;

use App\DataTables\SkPengangkatanStrukturalDataTable;
use App\Exports\SkPengangkatanStrukturalTemplateExport;
use App\Http\Requests\SkPengangkatanStrukturalRequest;
use App\Imports\SkPengangkatanStrukturalImport;
use App\Models\SkPengangkatanStruktural;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SkPengangkatanStrukturalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPengangkatanStrukturalDataTable $dataTable)
    {
        return $dataTable->render('pages.skpengangkatanstruktural.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpengangkatanstruktural.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPengangkatanStrukturalRequest $request)
    {
        $data = $request->validated();

        SkPengangkatanStruktural::create($data);

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengangkatanstruktural.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPengangkatanStruktural $skpengangkatanstruktural)
    {
        return redirect()->route('skpengangkatanstruktural.edit', $skpengangkatanstruktural->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPengangkatanStruktural $skpengangkatanstruktural)
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpengangkatanstruktural.edit', compact('tahunakademik', 'users', 'skpengangkatanstruktural'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPengangkatanStrukturalRequest $request, SkPengangkatanStruktural $skpengangkatanstruktural)
    {
        $data = $request->validated();

        $skpengangkatanstruktural->update($data);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengangkatanstruktural.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpengangkatanstruktural = SkPengangkatanStruktural::findOrFail($id);
        $skpengangkatanstruktural->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengangkatanstruktural.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SkPengangkatanStrukturalImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengangkatanstruktural.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SkPengangkatanStrukturalTemplateExport, 'Template_SK_Pengangkatan_Struktural.xlsx');
    }
}

