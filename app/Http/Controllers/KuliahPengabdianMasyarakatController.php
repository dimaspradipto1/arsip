<?php

namespace App\Http\Controllers;

use App\DataTables\KuliahPengabdianMasyarakatDataTable;
use App\Exports\KuliahPengabdianMasyarakatTemplateExport;
use App\Http\Requests\KuliahPengabdianMasyarakatRequest;
use App\Imports\KuliahPengabdianMasyarakatImport;
use App\Models\KuliahPengabdianMasyarakat;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class KuliahPengabdianMasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KuliahPengabdianMasyarakatDataTable $dataTable)
    {
        return $dataTable->render('pages.kuliahpengabdianmasyarakat.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.kuliahpengabdianmasyarakat.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KuliahPengabdianMasyarakatRequest $request)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $kpm = KuliahPengabdianMasyarakat::create($data);

        if (!empty($sekretarisIds)) {
            $kpm->sekretaris()->sync($sekretarisIds);
        }

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('kuliahpengabdianmasyarakat.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KuliahPengabdianMasyarakat $kuliahpengabdianmasyarakat)
    {
        return redirect()->route('kuliahpengabdianmasyarakat.edit', $kuliahpengabdianmasyarakat->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KuliahPengabdianMasyarakat $kuliahpengabdianmasyarakat)
    {
        $kuliahpengabdianmasyarakat->load('sekretaris');
        $tahunakademik = TahunAkademik::all();
        $users = User::facultyScope()->orderBy('name', 'asc')->get();
        return view('pages.kuliahpengabdianmasyarakat.edit', compact('kuliahpengabdianmasyarakat', 'tahunakademik', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(KuliahPengabdianMasyarakatRequest $request, KuliahPengabdianMasyarakat $kuliahpengabdianmasyarakat)
    {
        $data = $request->validated();
        $sekretarisIds = $data['sekretaris_id'] ?? [];
        unset($data['sekretaris_id']);

        $kuliahpengabdianmasyarakat->update($data);
        $kuliahpengabdianmasyarakat->sekretaris()->sync($sekretarisIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('kuliahpengabdianmasyarakat.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kuliahpengabdianmasyarakat = KuliahPengabdianMasyarakat::findOrFail($id);
        $kuliahpengabdianmasyarakat->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('kuliahpengabdianmasyarakat.index');
    }

    /**
     * Import Excel file.
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:20480',
        ]);

        Excel::import(new KuliahPengabdianMasyarakatImport, $request->file('file'));

        Alert::success('Data berhasil diimport')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('kuliahpengabdianmasyarakat.index');
    }

    /**
     * Download Excel template.
     */
    public function downloadTemplate()
    {
        return Excel::download(new KuliahPengabdianMasyarakatTemplateExport, 'Template_LPJ_Kuliah_Pengabdian_Masyarakat.xlsx');
    }
}
