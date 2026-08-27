<?php

namespace App\Http\Controllers;

use App\DataTables\IdentitasKaryaIlmiahDataTable;
use App\Exports\IdentitasKaryaIlmiahTemplateExport;
use App\Http\Requests\IdentitasKaryaIlmiahRequest;
use App\Imports\IdentitasKaryaIlmiahImport;
use App\Models\IdentitasKaryaIlmiah;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class IdentitasKaryaIlmiahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IdentitasKaryaIlmiahDataTable $dataTable)
    {
        return $dataTable->render('pages.identitaskaryailmiah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.identitaskaryailmiah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IdentitasKaryaIlmiahRequest $request)
    {
        IdentitasKaryaIlmiah::create($request->validated());

        Alert::success('Data berhasil disimpan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('identitaskaryailmiah.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(IdentitasKaryaIlmiah $identitaskaryailmiah)
    {
        return redirect()->route('identitaskaryailmiah.edit', $identitaskaryailmiah->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IdentitasKaryaIlmiah $identitaskaryailmiah)
    {
        return view('pages.identitaskaryailmiah.edit', compact('identitaskaryailmiah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IdentitasKaryaIlmiahRequest $request, IdentitasKaryaIlmiah $identitaskaryailmiah)
    {
        $identitaskaryailmiah->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('identitaskaryailmiah.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $identitaskaryailmiah = IdentitasKaryaIlmiah::findOrFail($id);
        $identitaskaryailmiah->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('identitaskaryailmiah.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new IdentitasKaryaIlmiahImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('identitaskaryailmiah.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new IdentitasKaryaIlmiahTemplateExport, 'Template_Identitas_Karya_Ilmiah.xlsx');
    }
}

