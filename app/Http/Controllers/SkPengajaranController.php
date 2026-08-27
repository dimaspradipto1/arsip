<?php

namespace App\Http\Controllers;

use App\DataTables\SkPengajaranDataTable;
use App\Exports\SkPengajaranTemplateExport;
use App\Http\Requests\SkPengajaranRequest;
use App\Imports\SkPengajaranImport;
use App\Models\SkPengajaran;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SkPengajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPengajaranDataTable $dataTable)
    {
        return $dataTable->render('pages.skpengajaran.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpengajaran.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPengajaranRequest $request)
    {
        $data = $request->validated();

        SkPengajaran::create($data);

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengajaran.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPengajaran $skpengajaran)
    {
        return redirect()->route('skpengajaran.edit', $skpengajaran->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPengajaran $skpengajaran)
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.skpengajaran.edit', compact('tahunakademik', 'users', 'skpengajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPengajaranRequest $request, SkPengajaran $skpengajaran)
    {
        $data = $request->validated();

        $skpengajaran->update($data);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengajaran.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpengajaran = SkPengajaran::findOrFail($id);
        $skpengajaran->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengajaran.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SkPengajaranImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengajaran.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SkPengajaranTemplateExport, 'Template_SK_Pengajaran.xlsx');
    }
}
