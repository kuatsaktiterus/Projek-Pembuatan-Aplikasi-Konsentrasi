<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JadwalDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Jadwal;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class JadwalController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(JadwalDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.jadwal_kelas.jadwal.jadwal');
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
            'jam_mulai' => 'required|multi_date_format:H:i,H:i:s',
            'jam_selesai' => 'required|multi_date_format:H:i,H:i:s',
            'hari' => 'required|integer|between:0,6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            $data = $request->input();
            try {
                Jadwal::create([
                    'jam_mulai'     => $data['jam_mulai'],
                    'jam_selesai'   => $data['jam_selesai'],
                    'hari'          => $data['hari'],
                ]);

                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jadwal');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data jadwal')->withInput();

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

    public function actionJadwal($action, $id)
    {
    try {
        $id = Crypt::decrypt($id);
        $jadwal = Jadwal::findOrFail($id);
    } catch (DecryptException $e) {
        return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
    }

    $returnHTML = view('dashboard.admin.jadwal_kelas.jadwal.jadwal_action', ['data' => $jadwal, 'action' => $action])->render();
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
            $jadwal = Jadwal::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }

        $rules = [
            'jam_mulai'     => 'required|multi_date_format:H:i,H:i:s',
            'jam_selesai'   => 'required|multi_date_format:H:i,H:i:s',
            'hari'          => 'required|integer|between:0,6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            $data = $request->input();
            try {
                $jadwal->update([
                    'jam_mulai'     => $data['jam_mulai'],
                    'jam_selesai'   => $data['jam_selesai'],
                    'hari'          => $data['hari'],
                ]);

                return redirect()->back()->withSuccessMessage('Berhasil mengedit data jadwal');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data jadwal');

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
            Jadwal::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
