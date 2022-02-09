<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\MataPelajaranDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\MataPelajaran;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class MataPelajaranController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.mata_pelajaran.mata_pelajaran');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'nama_mapel' => 'required|max:255|string|unique:tbl_mata_pelajarans,nama_mapel',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            try {
                MataPelajaran::create([
                    'nama_mapel' => $data['nama_mapel'],
                ]);
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data mata pelajaran');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data mata pelajaran')->withInput();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Show modal for deleting and editing mata pelajaran
     */
    public function actionMataPelajaran($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $mapel = MataPelajaran::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        $returnHTML = view('dashboard.admin.mata_pelajaran.mata_pelajaran_action', ['data' => $mapel, 'action' => $action])->render();
        return response()->json(['html' => $returnHTML]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $rules = [
            'nama_mapel' => 'required|max:255|string|unique:tbl_mata_pelajarans,nama_mapel,'.$id,
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            try {
                $mapel = MataPelajaran::findOrFail($id);
                $mapel->update([
                    'nama_mapel' => $data['nama_mapel'],
                ]);
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data mata pelajaran');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data mata pelajaran');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            MataPelajaran::findOrFail($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
