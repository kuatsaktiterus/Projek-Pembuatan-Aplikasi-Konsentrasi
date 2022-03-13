<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PembagianKelasDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\PembagianKelas;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PembagianKelasController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, PembagianKelasDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
            session()->put('id_kelas', $id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $kelas = Kelas::find($id);
        $guru = Guru::select('nip', 'nama', 'id')->get();
        return $dataTable->with('id', $id)->render('dashboard.admin.kelas.kelas.pembagian_kelas', ['gurus' => $guru, 'kelas' => $kelas->kelas, 'jurusan' => $kelas->jurusan]);
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
        try {
            $id = Crypt::decrypt($request->session()->get('id_kelas'));
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $getRuleGuru = array();
        foreach ($this->gurus->all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        $rules = [
            'nama_kelas' => ['required', Rule::unique('tbl_pembagian_kelases')->where('id_kelas', $id)],
            'wali_kelas' => ['required', Rule::in($getRuleGuru)],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            $data = $request->input();
            try {
                PembagianKelas::create([
                    'nama_kelas' => $data['nama_kelas'],
                    'wali_kelas' => $data['wali_kelas'],
                    'id_kelas'   => $id,
                ]);
                
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pembagian kelas');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data pembagian kelas')->withInput();
            }
        }
    }

    public function actionPembagianKelas($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $kelas = PembagianKelas::findOrFail($id);
            $guru = Guru::all();
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $returnHTML = view('dashboard.admin.kelas.kelas.pembagian_kelas_action', [
            'data' => $kelas,
            'action' => $action,
            'gurus' => $guru
        ])->render();
        return response()->json(['html' => $returnHTML]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $idPembagianKelas = Crypt::decrypt($id);
            $pembagianKelas = PembagianKelas::findOrFail($idPembagianKelas);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $id = Crypt::decrypt($request->session()->get('id_kelas'));
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $getRuleGuru = array();
        foreach ($this->gurus->all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        $rules = [
            'nama_kelas' => ['required', Rule::unique('tbl_pembagian_kelases')->where('id_kelas', $id)->ignore($idPembagianKelas)],
            'wali_kelas' => ['required', Rule::in($getRuleGuru)],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            $data = $request->input();
            try {
                $pembagianKelas->update([
                    'nama_kelas' => $data['nama_kelas'],
                    'wali_kelas' => $data['wali_kelas'],
                ]);
                
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data pembagian kelas');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data pembagian kelas');
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
            try {
                PembagianKelas::where('id', $id)->delete();
                return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
