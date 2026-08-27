<?php

namespace App\Http\Controllers;

use App\DataTables\BebanKerjaDosenDataTable;
use App\Exports\BebanKerjaDosenTemplateExport;
use App\Http\Requests\BebanKerjaDosenRequest;
use App\Imports\BebanKerjaDosenImport;
use App\Models\BebanKerjaDosen;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class BebanKerjaDosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BebanKerjaDosenDataTable $dataTable)
    {
        return $dataTable->render('pages.bebankerjadosen.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.bebankerjadosen.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BebanKerjaDosenRequest $request)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $bebankerjadosen = BebanKerjaDosen::create($data);

        if (!empty($sekretarisIds)) {
            $bebankerjadosen->sekretaris()->sync($sekretarisIds);
        }

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('bebankerjadosen.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(BebanKerjaDosen $bebankerjadosen)
    {
        return redirect()->route('bebankerjadosen.edit', $bebankerjadosen->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BebanKerjaDosen $bebankerjadosen)
    {
        $bebankerjadosen->load('sekretaris');
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.bebankerjadosen.edit', compact('bebankerjadosen', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BebanKerjaDosenRequest $request, BebanKerjaDosen $bebankerjadosen)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $bebankerjadosen->update($data);
        $bebankerjadosen->sekretaris()->sync($sekretarisIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('bebankerjadosen.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $bebankerjadosen = BebanKerjaDosen::findOrFail($id);
        $bebankerjadosen->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('bebankerjadosen.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new BebanKerjaDosenImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('bebankerjadosen.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new BebanKerjaDosenTemplateExport, 'Template_LPJ_Beban_Kerja_Dosen.xlsx');
    }
}
