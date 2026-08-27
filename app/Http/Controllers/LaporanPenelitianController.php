<?php

namespace App\Http\Controllers;

use App\DataTables\LaporanPenelitianDataTable;
use App\Exports\LaporanPenelitianTemplateExport;
use App\Http\Requests\LaporanPenelitianRequest;
use App\Imports\LaporanPenelitianImport;
use App\Models\LaporanPenelitian;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class LaporanPenelitianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LaporanPenelitianDataTable $dataTable)
    {
        return $dataTable->render('pages.laporanpenelitian.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.laporanpenelitian.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LaporanPenelitianRequest $request)
    {
        LaporanPenelitian::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('laporanpenelitian.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LaporanPenelitian $laporanpenelitian)
    {
        return redirect()->route('laporanpenelitian.edit', $laporanpenelitian->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LaporanPenelitian $laporanpenelitian)
    {
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.laporanpenelitian.edit', compact('laporanpenelitian', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LaporanPenelitianRequest $request, LaporanPenelitian $laporanpenelitian)
    {
        $laporanpenelitian->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('laporanpenelitian.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporanpenelitian = LaporanPenelitian::findOrFail($id);
        $laporanpenelitian->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('laporanpenelitian.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new LaporanPenelitianImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('laporanpenelitian.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new LaporanPenelitianTemplateExport, 'Template_Laporan_Penelitian.xlsx');
    }
}
