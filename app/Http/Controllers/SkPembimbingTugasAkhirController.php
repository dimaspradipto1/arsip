<?php

namespace App\Http\Controllers;

use App\DataTables\SkPembimbingTugasAkhirDataTable;
use App\Exports\SkPembimbingTugasAkhirTemplateExport;
use App\Http\Requests\SkPembimbingTugasAkhirRequest;
use App\Imports\SkPembimbingTugasAkhirImport;
use App\Models\SkPembimbingTugasAkhir;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SkPembimbingTugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPembimbingTugasAkhirDataTable $dataTable)
    {
        return $dataTable->render('pages.skpembimbingtugasakhir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpembimbingtugasakhir.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPembimbingTugasAkhirRequest $request)
    {
        $data = $request->validated();

        SkPembimbingTugasAkhir::create($data);

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingtugasakhir.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPembimbingTugasAkhir $skpembimbingtugasakhir)
    {
        return redirect()->route('skpembimbingtugasakhir.edit', $skpembimbingtugasakhir->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPembimbingTugasAkhir $skpembimbingtugasakhir)
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpembimbingtugasakhir.edit', compact('tahunakademik', 'users', 'skpembimbingtugasakhir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPembimbingTugasAkhirRequest $request, SkPembimbingTugasAkhir $skpembimbingtugasakhir)
    {
        $data = $request->validated();

        $skpembimbingtugasakhir->update($data);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingtugasakhir.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpembimbingtugasakhir = SkPembimbingTugasAkhir::findOrFail($id);
        $skpembimbingtugasakhir->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingtugasakhir.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SkPembimbingTugasAkhirImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingtugasakhir.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SkPembimbingTugasAkhirTemplateExport, 'Template_SK_Pembimbing_Tugas_Akhir.xlsx');
    }
}
