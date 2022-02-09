<?php

namespace App\Http\Controllers\Guru;

use App\DataTables\Admin\MataPelajaranDataTable;
use App\DataTables\Admin\SiswaDataTable;
use App\DataTables\Guru\JadwalKelasDataTable;
use App\DataTables\Guru\PengumumanGuruDataTable;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\PengumumanAdmin;
use App\Models\PengumumanGuru;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('guru');

        $this->middleware(function($request, $next)
        {
            if (session('success_message')) {
                Alert::success('Sukses!', session('success_message'));
            }

            if (session('warning_message')) {
                Alert::warning('Gagal!', session('warning_message'));
            }

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jadwalKelas(JadwalKelasDataTable $dataTable)
    {
        return $dataTable->with('id', Auth::user()->gurus->id)->render('dashboard.guru.jadwal_kelas');
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function mataPelajaran(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('dashboard.guru.mata_pelajaran');
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function siswa(SiswaDataTable $dataTable)
    {
        return $dataTable->render('dashboard.guru.siswa');
    }

    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function profil(SiswaDataTable $dataTable)
    {
        $dataGuru = Guru::findOrFail(Auth::user()->gurus->id);

        return view('dashboard.guru.profil.profil', ['guru' => $dataGuru]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function gantiPassword()
    {
        $dataSiswa = Guru::findOrFail(Auth::user()->gurus->id);

        return view('dashboard.guru.profil.ganti_pass', ['guru' => $dataSiswa]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function storeGantiPassword(Request $request)
    {
        $rules = ([
            'password' => ['required', new MatchOldPassword],
            'passwordBaru' => ['required', 'string', 'min:8'],
            'konfirmasiPassword' => ['same:passwordBaru', 'string', 'min:8'],
        ]);

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
            ->withInput();
        } else {
            try {
                User::find(auth()->user()->id)->update(['password'=> Hash::make($request->passwordBaru)]);

                return redirect()->back()->withSuccessMessage('Berhasil mengedit data');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data');
            }
        }

    }

    public function indexPengumuman(PengumumanGuruDataTable $dataTable)
    {
        return $dataTable->with('id', Auth::user()->gurus->id)->render('dashboard.guru.pengumuman.pengumuman');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePengumuman(Request $request)
    {
        $rules = [
            'pengumuman' => 'required|max:255|string',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            try {
                PengumumanGuru::create([
                    'pengumuman'        => $data['pengumuman'],
                    'waktu_pengumuman'  => date(now()),
                    'id_guru'           => Auth::user()->gurus->id,
                    ]);
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pengumuman');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data pengumuman')->withInput();
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePengumuman(Request $request, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $pengumuman = PengumumanGuru::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        $rules = [
            'pengumuman' => 'required|max:255|string',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            try {
                $pengumuman->update([
                    'pengumuman'        => $data['pengumuman'],
                    'waktu_pengumuman'  => date(now()),
                    ]);
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data pengumuman');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data pengumuman')->withInput();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyPengumuman($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            PengumumanGuru::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }

    /**
    * Show modal for deleting and editing pengumuman
    */
   public function actionPengumuman($action, $id)
   {
       try {
           $id = Crypt::decrypt($id);
           $pengumuman = PengumumanGuru::findOrFail($id);
       } catch (DecryptException $th) {
           return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
       }

       $returnHTML = view('dashboard.guru.pengumuman.pengumuman_action', ['data' => $pengumuman, 'action' => $action])->render();
       return response()->json(['html' => $returnHTML]);
   }
}
