<?php

namespace App\Http\Controllers;

use App\DataTables\YudisiumDataTable;
use App\Exports\YudisiumTemplateExport;
use App\Http\Requests\YudisiumRequest;
use App\Imports\YudisiumImport;
use App\Models\TahunAkademik;
use App\Models\User;
use App\Models\Yudisium;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class YudisiumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(YudisiumDataTable $dataTable)
    {
        return $dataTable->render('pages.yudisium.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.yudisium.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(YudisiumRequest $request)
    {
        Yudisium::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('yudisium.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Yudisium $yudisium)
    {
        return redirect()->route('yudisium.edit', $yudisium->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Yudisium $yudisium)
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.yudisium.edit', compact('yudisium', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(YudisiumRequest $request, Yudisium $yudisium)
    {
        $yudisium->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('yudisium.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $yudisium = Yudisium::findOrFail($id);
        $yudisium->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('yudisium.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new YudisiumImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('yudisium.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new YudisiumTemplateExport, 'Template_LPJ_Yudisium.xlsx');
    }
}
