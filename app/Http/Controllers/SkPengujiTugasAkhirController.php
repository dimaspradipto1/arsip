<?php

namespace App\Http\Controllers;

use App\DataTables\SkPengujiTugasAkhirDataTable;
use App\Exports\SkPengujiTugasAkhirTemplateExport;
use App\Http\Requests\SkPengujiTugasAkhirRequest;
use App\Imports\SkPengujiTugasAkhirImport;
use App\Models\SkPengujiTugasAkhir;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SkPengujiTugasAkhirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPengujiTugasAkhirDataTable $dataTable)
    {
        return $dataTable->render('pages.skpengujitugasakhir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpengujitugasakhir.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkPengujiTugasAkhirRequest $request)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        $skPengujiTa = SkPengujiTugasAkhir::create($data);

        if (!empty($userIds)) {
            $skPengujiTa->users()->sync($userIds);
        }

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujitugasakhir.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPengujiTugasAkhir $skpengujitugasakhir)
    {
        return redirect()->route('skpengujitugasakhir.edit', $skpengujitugasakhir->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPengujiTugasAkhir $skpengujitugasakhir)
    {
        $skpengujitugasakhir->load('users');
        $tahunakademik = TahunAkademik::orderBy('id', 'desc')->get();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpengujitugasakhir.edit', compact('tahunakademik', 'users', 'skpengujitugasakhir'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkPengujiTugasAkhirRequest $request, SkPengujiTugasAkhir $skpengujitugasakhir)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        $skpengujitugasakhir->update($data);
        $skpengujitugasakhir->users()->sync($userIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujitugasakhir.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpengujitugasakhir = SkPengujiTugasAkhir::findOrFail($id);
        $skpengujitugasakhir->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujitugasakhir.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SkPengujiTugasAkhirImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpengujitugasakhir.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SkPengujiTugasAkhirTemplateExport, 'Template_SK_Penguji_Tugas_Akhir.xlsx');
    }
}

