<?php

namespace App\Http\Controllers;

use App\DataTables\SemesterAntaraDataTable;
use App\Exports\SemesterAntaraTemplateExport;
use App\Http\Requests\SemesterAntaraRequest;
use App\Imports\SemesterAntaraImport;
use App\Models\SemesterAntara;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class SemesterAntaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SemesterAntaraDataTable $dataTable)
    {
        return $dataTable->render('pages.semesterantara.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.semesterantara.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SemesterAntaraRequest $request)
    {
        SemesterAntara::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('semesterantara.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SemesterAntara $semesterantara)
    {
        return redirect()->route('semesterantara.edit', $semesterantara->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SemesterAntara $semesterantara)
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.semesterantara.edit', compact('semesterantara', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SemesterAntaraRequest $request, SemesterAntara $semesterantara)
    {
        $semesterantara->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('semesterantara.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $semesterantara = SemesterAntara::findOrFail($id);
        $semesterantara->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('semesterantara.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new SemesterAntaraImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('semesterantara.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new SemesterAntaraTemplateExport, 'Template_LPJ_Semester_Antara.xlsx');
    }
}
