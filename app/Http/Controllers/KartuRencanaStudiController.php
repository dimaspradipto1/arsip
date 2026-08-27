<?php

namespace App\Http\Controllers;

use App\DataTables\KartuRencanaStudiDataTable;
use App\Exports\KartuRencanaStudiTemplateExport;
use App\Http\Requests\KartuRencanaStudiRequest;
use App\Imports\KartuRencanaStudiImport;
use App\Models\KartuRencanaStudi;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class KartuRencanaStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KartuRencanaStudiDataTable $dataTable)
    {
        return $dataTable->render('pages.karturencanaStudi.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.karturencanaStudi.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KartuRencanaStudiRequest $request)
    {
        KartuRencanaStudi::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('karturencanaStudi.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KartuRencanaStudi $karturencanaStudi)
    {
        return redirect()->route('karturencanaStudi.edit', $karturencanaStudi->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $karturencanaStudi = KartuRencanaStudi::findOrFail($id);
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.karturencanaStudi.edit', compact('karturencanaStudi', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KartuRencanaStudiRequest $request, $id)
    {
        $karturencanaStudi = KartuRencanaStudi::findOrFail($id);
        $karturencanaStudi->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('karturencanaStudi.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $karturencanaStudi = KartuRencanaStudi::findOrFail($id);
        $karturencanaStudi->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('karturencanaStudi.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new KartuRencanaStudiImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('karturencanaStudi.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new KartuRencanaStudiTemplateExport, 'Template_LPJ_Kartu_Rencana_Studi.xlsx');
    }
}
