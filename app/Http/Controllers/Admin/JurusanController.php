<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerAdmin;
use App\Models\Jurusan;
use App\Models\Kelas;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class JurusanController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'jurusan' => 'required|max:255|string|unique:tbl_jurusans,jurusan',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            try {
                $jurusan = Jurusan::create(['jurusan' => $data['jurusan']]);
                $kelas = [
                    ['kelas'=>'X',      'id_jurusan'=> $jurusan->id],
                    ['kelas'=>'XI',     'id_jurusan'=> $jurusan->id],
                    ['kelas'=>'XII',    'id_jurusan'=> $jurusan->id],
                ];
                Kelas::insert($kelas);
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jurusan');
            } catch (\Throwable $th) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data jurusan')->withInput();
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

    public function actionJurusan($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jurusan = Jurusan::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('dashboard.admin.kelas.jurusan.jurusan_action', [
            'data' => $jurusan,
            'action' => $action
        ])->render();
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
            $jurusan = Jurusan::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $rules = [
            'jurusan' => 'required|max:255|string|unique:tbl_jurusans,jurusan,'.$id,
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            try {
                $jurusan->update(['jurusan' => $data['jurusan']]);
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data jurusan');
            } catch (\Throwable $th) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data jurusan')->withInput();
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
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            Kelas::where('id_jurusan', $id)->delete();
            Jurusan::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
