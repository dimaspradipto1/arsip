<?php

namespace App\Http\Controllers;

use App\DataTables\UjianTengahSemesterDataTable;
use App\Exports\UjianTengahSemesterTemplateExport;
use App\Http\Requests\UjianTengahSemesterRequest;
use App\Imports\UjianTengahSemesterImport;
use App\Models\TahunAkademik;
use App\Models\UjianTengahSemester;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UjianTengahSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UjianTengahSemesterDataTable $dataTable)
    {
        return $dataTable->render('pages.ujiantengahsemester.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.ujiantengahsemester.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UjianTengahSemesterRequest $request)
    {
        UjianTengahSemester::create($request->validated());

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujiantengahsemester.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UjianTengahSemester $ujiantengahsemester)
    {
        return redirect()->route('ujiantengahsemester.edit', $ujiantengahsemester->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UjianTengahSemester $ujiantengahsemester)
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.ujiantengahsemester.edit', compact('ujiantengahsemester', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UjianTengahSemesterRequest $request, UjianTengahSemester $ujiantengahsemester)
    {
        $ujiantengahsemester->update($request->validated());

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujiantengahsemester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ujiantengahsemester = UjianTengahSemester::findOrFail($id);
        $ujiantengahsemester->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujiantengahsemester.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new UjianTengahSemesterImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujiantengahsemester.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new UjianTengahSemesterTemplateExport, 'Template_LPJ_Ujian_Tengah_Semester.xlsx');
    }
}
