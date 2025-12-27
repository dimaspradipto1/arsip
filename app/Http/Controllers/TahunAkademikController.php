<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TahunAkademik;
use RealRashid\SweetAlert\Facades\Alert;
use App\DataTables\TahunAkademikDataTable;
use App\Http\Requests\TahunAkademikRequest;

class TahunAkademikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TahunAkademikDataTable $dataTable)
    {
        return $dataTable->render('pages.tahunakademik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.tahunakademik.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TahunAkademikRequest $request)
    {
        TahunAkademik::create($request->all());
        Alert::success('Success', 'Data berhasil ditambahkan')->autoclose(2000)->toToast()->timerProgressBar()->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('tahunakademik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAkademik $tahunAkademik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAkademik $tahunakademik)
    {
        return view('pages.tahunakademik.edit', compact('tahunakademik'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TahunAkademikRequest $request, TahunAkademik $tahunakademik)
    {
        $tahunakademik->update($request->all());
        Alert::success('Success', 'Data berhasil diubah')->autoclose(2000)->toToast()->timerProgressBar()->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('tahunakademik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tahunakademik = TahunAkademik::findOrFail($id);
        $tahunakademik->delete();
        Alert::success('Success', 'Data berhasil dihapus')->autoclose(2000)->toToast()->timerProgressBar()->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('tahunakademik.index');
    }
}
