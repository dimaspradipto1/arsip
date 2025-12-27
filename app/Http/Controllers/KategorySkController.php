<?php

namespace App\Http\Controllers;

use App\Models\KategorySk;
use Illuminate\Http\Request;
use App\DataTables\KategorySkDataTable;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\KatergorySkRequest;

class KategorySkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KategorySkDataTable $datatable)
    {
        return $datatable->render('pages.kategorysk.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kategorysk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(KatergorySkRequest $request)
    {
        KategorySk::create($request->validated());
        Alert::success('Success', 'Data berhasil ditambahkan')
            ->autoclose(2000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('kategorysk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(KategorySk $kategorySk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KategorySk $kategorysk)
    {
        return view('pages.kategorysk.edit', compact('kategorysk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KategorySk $kategorysk)
    {
        $kategorysk->update($request->all());
        Alert::success('Success', 'Data berhasil diupdate')
            ->autoclose(2000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('kategorysk.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KategorySk $kategorysk)
    {
        $kategorysk->delete();
        Alert::success('Success', 'Data berhasil dihapus')
            ->autoclose(2000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');
        return redirect()->route('kategorysk.index');
    }
}
