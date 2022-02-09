<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\IsikelasDataTable;
use App\DataTables\Admin\PembagianKelasSiswaDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class PembagianKelasSiswaController extends ControllerAdmin
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
    public function store($idSiswa, $idPembagianKelas)
    {
        try {
            $pembagianKelas = Crypt::decrypt($idPembagianKelas);
            $idSiswa = Crypt::decrypt($idSiswa);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        }

        try {
            PembagianKelasSiswa::create([
                'id_siswa'              => $idSiswa,
                'id_pembagian_kelas'    => $pembagianKelas,
            ]);
            
            return redirect()->back()->withSuccessMessage('Berhasil memasukkan siswa ke dalam kelas');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal memasukkan siswa ke dalam kelas');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, PembagianKelasSiswaDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $id_jurusan = PembagianKelas::find($id)->kelas->id_jurusan;

        $banyakPembagianKelasSiswa = PembagianKelasSiswa::where('id_pembagian_kelas', $id)->count();
        $pembagianKelas = PembagianKelas::find($id);
        return $dataTable->with('id', $id)->with('id_jurusan', $id_jurusan)->render(
            'dashboard.admin.kelas.kelas.pembagian_kelas_siswa',
            [
                'id' => $id,
                'banyakSiswa' => $banyakPembagianKelasSiswa,
                'kelas' => $pembagianKelas->kelas->kelas,
                'jurusan' => $pembagianKelas->kelas->jurusan
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, IsikelasDataTable $dataTable)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $pembagianKelas = PembagianKelas::find($id);
        return $dataTable->with('id', $id)->render('dashboard.admin.kelas.kelas.isi_kelas', ['pembagianKelas' => $pembagianKelas]);
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
        //
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
                PembagianKelasSiswa::find($id)->delete();
                return redirect()->back()->withSuccessMessage('Berhasil mengeluarkan siswa dari kelas');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal Menghapus mengeluarkan siswa dari kelas');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
