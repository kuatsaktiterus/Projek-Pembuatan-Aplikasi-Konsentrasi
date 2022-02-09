<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\JadwalKelasDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\JadwalKelas;
use App\Models\MataPelajaran;
use App\Models\PembagianKelas;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JadwalKelasController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id, JadwalKelasDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $pembagianKelas = PembagianKelas::all();
            $mataPelajaran = MataPelajaran::all();
            $pengajar = Guru::all();
            $jadwal = Jadwal::all();
            $dataPemabgianKelas = PembagianKelas::findOrFail($id);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        return $dataTable->with('id', $id)->render('dashboard.admin.jadwal_kelas.jadwal_kelas.jadwal_kelas', [
            'pembagianKelas' => $pembagianKelas,
            'matapelajaran'  => $mataPelajaran,
            'pengajar'       => $pengajar,
            'jadwal'         => $jadwal,
            'data'           => $dataPemabgianKelas
        ]);
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
        $data = $request->input();

        $cekJadwalKelasPengajar = JadwalKelas::where('id_pengajar', $data['pengajar'])->get();
        $cekJadwalKelasKelas = JadwalKelas::where('id_pembagian_kelas', $data['pembagian_kelas'])->get();

        // cek jadwal dari guru yang telah dipilih
        $getRuleJadwalKelas_idJadwalPengajar = array();
        foreach ($cekJadwalKelasPengajar as $jadwal) {
            $getRuleJadwalKelas_idJadwalPengajar[] = '' . $jadwal->id_jadwal . '';
        }

        // cek jadwal dari kelas yang telah dipilih
        $getRuleJadwalKelas_idJadwalKelas = array();
        foreach ($cekJadwalKelasKelas as $jadwal) {
            $getRuleJadwalKelas_idJadwalKelas[] = '' . $jadwal->id_jadwal . '';
        }
        
        // Jika pengajar memiliki waktu mengajar yang sama
        if (in_array($request->jadwal, $getRuleJadwalKelas_idJadwalPengajar)) {
            return redirect()->back()->withWarningMessage('Pengajar ini sudah memiliki jadwal di waktu tersebut')->withInput();
        }

        // Jika didalam sebuah kelas sudah memiliki waktu mengajar tersebut
        if (in_array($request->jadwal, $getRuleJadwalKelas_idJadwalKelas)) {
            return redirect()->back()->withWarningMessage('Waktu pelajaran di kelas ini sudah terisi')->withInput();
        }

        $getRuleJadwal = array();
        foreach (Jadwal::all() as $jadwal) {
            $getRuleJadwal[] = '' . $jadwal->id . '';
        }

        $getRulePembagianKelas = array();
        foreach (PembagianKelas::all() as $kelas) {
            $getRulePembagianKelas[] = '' . $kelas->id . '';
        }

        $getRuleGuru = array();
        foreach (Guru::all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        $getRuleMapel = array();
        foreach (MataPelajaran::all() as $mapel) {
            $getRuleMapel[] = '' . $mapel->id . '';
        }

        $rules = [
            'mapel' => ['required', Rule::in($getRuleMapel)],
            'pembagian_kelas' => ['required', Rule::in($getRulePembagianKelas)],
            'pengajar' => ['required', Rule::in($getRuleGuru)],
            'jadwal' => ['required', Rule::in($getRuleJadwal)],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back();
        } else {
            try {
                JadwalKelas::create([
                    'id_pembagian_kelas' => $data['pembagian_kelas'],
                    'id_matapelajaran'   => $data['mapel'],
                    'id_pengajar'        => $data['pengajar'],
                    'id_jadwal'          => $data['jadwal']
                ]);
                
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data jadwal kelas');
                return redirect()->back();
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data jadwal kelas')->withInput();
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

    public function actionJadwalKelas($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $jadwalKelas = JadwalKelas::findOrFail($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $pembagianKelas = PembagianKelas::all();
        $matapelajaran = MataPelajaran::all();
        $guru = Guru::all();
        $jadwal = Jadwal::all();

        $returnHTML = view('dashboard.admin.jadwal_kelas.jadwal_kelas.jadwal_kelas_action', [
            'data' => $jadwalKelas,
            'pembagianKelas' => $pembagianKelas,
            'matapelajaran' => $matapelajaran,
            'pengajar' => $guru,
            'jadwal' => $jadwal,
            'action' => $action
        ])->render();
        return response()->json(['html' => $returnHTML]);
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
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $jadwalKelas = JadwalKelas::findOrFail($id);
        $data = $request->input();
        $cekJadwalKelasPengajar = JadwalKelas::where('id_pengajar', $data['pengajar'])->get();
        $cekJadwalKelasKelas = JadwalKelas::where('id_pembagian_kelas', $data['pembagian_kelas'])->get();

        // cek jadwal dari guru yang telah dipilih
        $getRuleJadwalKelas_idJadwalPengajar = array();
        foreach ($cekJadwalKelasPengajar as $jadwal) {
            $getRuleJadwalKelas_idJadwalPengajar[] = '' . $jadwal->id_jadwal . '';
        }

        // cek jadwal dari kelas yang telah dipilih
        $getRuleJadwalKelas_idJadwalKelas = array();
        foreach ($cekJadwalKelasKelas as $jadwal) {
            $getRuleJadwalKelas_idJadwalKelas[] = '' . $jadwal->id_jadwal . '';
        }
        
        // Jika pengajar memiliki waktu mengajar yang sama
        if (in_array($request->jadwal, $getRuleJadwalKelas_idJadwalPengajar)) {
            return redirect()->back()->withWarningMessage('Pengajar ini sudah memiliki jadwal di waktu tersebut')->withInput();
        }

        // Jika didalam sebuah kelas sudah memiliki waktu mengajar tersebut
        if (in_array($request->jadwal, $getRuleJadwalKelas_idJadwalKelas)) {
            return redirect()->back()->withWarningMessage('Waktu pelajaran di kelas ini sudah terisi')->withInput();
        }

        $getRuleJadwal = array();
        foreach (Jadwal::all() as $jadwal) {
            $getRuleJadwal[] = '' . $jadwal->id . '';
        }

        $getRulePembagianKelas = array();
        foreach (PembagianKelas::all() as $kelas) {
            $getRulePembagianKelas[] = '' . $kelas->id . '';
        }

        $getRuleGuru = array();
        foreach (Guru::all() as $guru) {
            $getRuleGuru[] = '' . $guru->id . '';
        }

        $getRuleMapel = array();
        foreach (MataPelajaran::all() as $mapel) {
            $getRuleMapel[] = '' . $mapel->id . '';
        }

        $rules = [
            'mapel' => ['required', Rule::in($getRuleMapel)],
            'pembagian_kelas' => ['required', Rule::in($getRulePembagianKelas)],
            'pengajar' => ['required', Rule::in($getRuleGuru)],
            'jadwal' => ['required', Rule::in($getRuleJadwal)],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back();
        } else {
            try {
                $jadwalKelas->update([
                    'id_pembagian_kelas'    => $data['pembagian_kelas'],
                    'id_matapelajaran'      => $data['mapel'],
                    'id_pengajar'           => $data['pengajar'],
                    'id_jadwal'             => $data['jadwal'],
                ]);
                
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data jurusan');
            } catch (Exception $e) {
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
            JadwalKelas::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
