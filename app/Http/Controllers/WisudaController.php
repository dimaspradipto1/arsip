<?php

namespace App\Http\Controllers;

use App\DataTables\WisudaDataTable;
use App\Exports\WisudaTemplateExport;
use App\Http\Requests\WisudaRequest;
use App\Imports\WisudaImport;
use App\Models\TahunAkademik;
use App\Models\User;
use App\Models\Wisuda;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class WisudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WisudaDataTable $dataTable)
    {
        return $dataTable->render('pages.wisuda.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.wisuda.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WisudaRequest $request)
    {
        Wisuda::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('wisuda.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Wisuda $wisuda)
    {
        return redirect()->route('wisuda.edit', $wisuda->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wisuda $wisuda)
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.wisuda.edit', compact('wisuda', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WisudaRequest $request, Wisuda $wisuda)
    {
        $wisuda->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('wisuda.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wisuda = Wisuda::findOrFail($id);
        $wisuda->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('wisuda.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new WisudaImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('wisuda.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new WisudaTemplateExport, 'Template_LPJ_Wisuda.xlsx');
    }
}
