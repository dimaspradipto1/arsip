<?php

namespace App\Http\Controllers;

use App\DataTables\SkPembimbingKpmDataTable;
use App\Http\Requests\SkpembimbingKpmRequest;
use App\Models\SkPembimbingKpm;
use App\Models\TahunAkademik;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SkPembimbingKpmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SkPembimbingKpmDataTable $dataTable)
    {
        return $dataTable->render('pages.skpembimbingkpm.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tahunakademik = TahunAkademik::all();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpembimbingkpm.create', compact('tahunakademik', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SkpembimbingKpmRequest $request)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        // Auto fill prodi if empty from first selected lecturer
        if (empty($data['prodi']) && !empty($userIds)) {
            $firstUser = User::find($userIds[0]);
            if ($firstUser && $firstUser->homebase) {
                $data['prodi'] = $firstUser->homebase;
            }
        }

        $skKpm = SkPembimbingKpm::create($data);

        if (!empty($userIds)) {
            $skKpm->users()->sync($userIds);
        }

        Alert::success('Data berhasil ditambahkan')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingkpm.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SkPembimbingKpm $skpembimbingkpm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SkPembimbingKpm $skpembimbingkpm)
    {
        $skpembimbingkpm->load('users');
        $tahunakademik = TahunAkademik::all();
        $users = User::orderBy('name', 'asc')->get();
        return view('pages.skpembimbingkpm.edit', compact('tahunakademik', 'users', 'skpembimbingkpm'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SkpembimbingKpmRequest $request, SkPembimbingKpm $skpembimbingkpm)
    {
        $data = $request->validated();
        $userIds = $data['user_ids'] ?? [];
        unset($data['user_ids']);

        // Auto fill prodi if empty from first selected lecturer
        if (empty($data['prodi']) && !empty($userIds)) {
            $firstUser = User::find($userIds[0]);
            if ($firstUser && $firstUser->homebase) {
                $data['prodi'] = $firstUser->homebase;
            }
        }

        $skpembimbingkpm->update($data);
        $skpembimbingkpm->users()->sync($userIds);

        Alert::success('Data berhasil diupdate')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingkpm.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skpembimbingkpm = SkPembimbingKpm::findOrFail($id);
        $skpembimbingkpm->delete();

        Alert::success('Data berhasil dihapus')
            ->autoclose(3000)
            ->toToast()
            ->timerProgressBar()
            ->iconHtml('<i class="far fa-thumbs-up"></i>');

        return redirect()->route('skpembimbingkpm.index');
    }
}
