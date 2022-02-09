<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JurusanDataTable;
use App\DataTables\Admin\KelasDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Jadwal;
use App\Models\Jurusan;
use App\Models\Kelas;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class KelasController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JurusanDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.kelas.jurusan.jurusan', ['jurusans' => $this->jurusan->all()]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, KelasDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
            $jurusan = Jurusan::find($id);
            return $dataTable->with('id', $id)->render('dashboard.admin.kelas.kelas.kelas', ['jurusan' => $jurusan->jurusan]);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
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

    public function actionKelas($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $kelas = Kelas::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('dashboard.admin.kelas.kelas.kelas_action', ['data' => $kelas,])->render();
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
            $kelas = Kelas::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        $rules = [
            'nama_kelas' => 'required|max:255|string',
            'status' => 'required|max:255|string',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            try {
                $kelas->update([
                    'kelas'    => $data['nama_kelas'],
                    'status'    => $data['status'],
                ]);
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data kelas');
            } catch (\Throwable $th) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data kelas')->withInput();
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
        //
    }
}
