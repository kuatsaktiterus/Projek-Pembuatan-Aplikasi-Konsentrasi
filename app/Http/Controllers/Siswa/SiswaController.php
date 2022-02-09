<?php

namespace App\Http\Controllers\Siswa;

use App\DataTables\Admin\GuruDataTable;
use App\DataTables\Admin\MataPelajaranDataTable;
use App\DataTables\Siswa\InfoKelasDataTable;
use App\DataTables\Siswa\JadwalKelasDataTable;
use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('siswa');

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
    public function index(JadwalKelasDataTable $dataTable)
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswas->id);
        $idPembagianKelas = $dataSiswa->pembagiankelassiswa[0]->id_pembagian_kelas;    
        return $dataTable->with('id', $idPembagianKelas)->render('dashboard.siswa.kelas.jadwal_kelas', ['data' => $dataSiswa]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function info(InfoKelasDataTable $dataTable)
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswas->id);
        $idPembagianKelas = $dataSiswa->pembagiankelassiswa[0]->id;    
        $guru = $dataSiswa->pembagiankelassiswa[0]->PembagianKelas->guru;
        return $dataTable->with('id', $idPembagianKelas)->render('dashboard.siswa.kelas.info_kelas', ['data' => $dataSiswa, 'guru' =>  $guru]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function mataPelajaran(MataPelajaranDataTable $dataTable)
    {
        return $dataTable->render('dashboard.siswa.mata_pelajaran.mata_pelajaran');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function guru(GuruDataTable $dataTable)
    {
        return $dataTable->render('dashboard.siswa.guru.guru');
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function profil()
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswas->id);

        return view('dashboard.siswa.profil.profil', ['siswa' => $dataSiswa]);
    }
    
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function gantiPassword()
    {
        $dataSiswa = Siswa::findOrFail(Auth::user()->siswas->id);

        return view('dashboard.siswa.profil.ganti_pass', ['siswa' => $dataSiswa]);
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
}
