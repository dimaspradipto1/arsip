<?php

namespace App\Http\Controllers;

use App\Models\KategorySk;
use Illuminate\Http\Request;
use App\Models\SkKepanitiaan;
use App\Models\TahunAkademik;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\SkKepanitiaanDataTable;
use App\Http\Requests\SkKepanitianRequest;
use App\Http\Requests\SkKepanitiaanRequest;

class SkKepanitiaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkKepanitiaanDataTable $dataTable)
    {
        return $dataTable->render('pages.skkepanitiaan.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $kategorysk = KategorySk::all();
        return view('pages.skkepanitiaan.create', compact('tahunakademik', 'kategorysk'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkKepanitiaanRequest $request)
    {
        $data = $request->validated();
        SkKepanitiaan::create($data);
        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('skkepanitiaan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkKepanitiaan $skKepanitiaan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkKepanitiaan $skkepanitiaan)
    {
        $tahunakademik = TahunAkademik::all();
        $kategorysk = KategorySk::all();
        return view('pages.skkepanitiaan.edit', compact('tahunakademik', 'kategorysk', 'skkepanitiaan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkKepanitiaanRequest $request, SkKepanitiaan $skkepanitiaan)
    {
        $data = $request->validated();
        $skkepanitiaan->update($data);
        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('skkepanitiaan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skkepanitiaan = SkKepanitiaan::findOrFail($id);
        $skkepanitiaan->delete();
        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('skkepanitiaan.index');
    }
}
