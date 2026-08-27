<?php

namespace App\Http\Controllers;

use App\DataTables\UjianAkhirSemesterDataTable;
use App\Exports\UjianAkhirSemesterTemplateExport;
use App\Http\Requests\UjianAkhirSemesterRequest;
use App\Imports\UjianAkhirSemesterImport;
use App\Models\TahunAkademik;
use App\Models\UjianAkhirSemester;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class UjianAkhirSemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UjianAkhirSemesterDataTable $dataTable)
    {
        return $dataTable->render('pages.ujianakhirsemester.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.ujianakhirsemester.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UjianAkhirSemesterRequest $request)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $uas = UjianAkhirSemester::create($data);

        if (!empty($sekretarisIds)) {
            $uas->sekretaris()->sync($sekretarisIds);
        }

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujianakhirsemester.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(UjianAkhirSemester $ujianakhirsemester)
    {
        return redirect()->route('ujianakhirsemester.edit', $ujianakhirsemester->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UjianAkhirSemester $ujianakhirsemester)
    {
        $ujianakhirsemester->load('sekretaris');
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.ujianakhirsemester.edit', compact('ujianakhirsemester', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UjianAkhirSemesterRequest $request, UjianAkhirSemester $ujianakhirsemester)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $ujianakhirsemester->update($data);
        $ujianakhirsemester->sekretaris()->sync($sekretarisIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujianakhirsemester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $ujianakhirsemester = UjianAkhirSemester::findOrFail($id);
        $ujianakhirsemester->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujianakhirsemester.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new UjianAkhirSemesterImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('ujianakhirsemester.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new UjianAkhirSemesterTemplateExport, 'Template_LPJ_Ujian_Akhir_Semester.xlsx');
    }
}
