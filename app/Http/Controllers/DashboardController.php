<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Guru;
use App\Models\Jadwal;
use App\Models\PembagianKelas;
use App\Models\PengumumanAdmin;
use App\Models\PengumumanGuru;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'siswa') {
            $siswa              = Siswa::findOrfail(Auth::user()->siswas->id);
            $jumlahGuru         = Guru::count();
            $jumlahSiswa        = Siswa::count();
            $pengumumanAdmin    = PengumumanAdmin::all();
            $pengumumanGuru     = PengumumanGuru::all();
            $jumlahKelas        = PembagianKelas::where('id_kelas', $siswa->pembagiankelassiswa[0]->pembagiankelas->kelas->id)->count();

            // cari jadwal sesuai hari ini
            $hari = date('w', Carbon::now()->timestamp);
            $jadwal = Jadwal::where('hari', $hari)->get();

            // cari jadwal kelas untuk kelas hari itu
            $jadwalHarian = [];
            foreach ($jadwal as $data) {
                $jadwalHarian = $siswa->pembagiankelassiswa[0]->jadwalkelas->where('id_jadwal', $data->id);
            }
            
            return view('dashboard.dashboard', [
                'siswa'                 => $siswa, 
                'jumlahGuru'            => $jumlahGuru, 
                'jumlahSiswa'           => $jumlahSiswa, 
                'jumlahKelas'           => $jumlahKelas,
                'jadwalHarian'          => $jadwalHarian,
                'pengumumanSekolah'     => $pengumumanAdmin,
                'pengumumanGuru'        => $pengumumanGuru]); 
        
        } elseif (Auth::user()->role == 'guru') {

            $guru               = Guru::findOrfail(Auth::user()->gurus->id);
            $jumlahGuru         = Guru::count();
            $jumlahSiswa        = Siswa::count();
            $pengumumanAdmin    = PengumumanAdmin::all();
            $pengumumanGuru     = PengumumanGuru::all();
            $jumlahKelas        = PembagianKelas::all()->count();

            // cari jadwal sesuai hari ini
            $hari = date('w', Carbon::now()->timestamp);
            $jadwal = Jadwal::where('hari', $hari)->get();

            // dd($guru->jadwalkelas);
            // cari jadwal kelas untuk kelas hari itu
            $jadwalHarian = [];
            foreach ($jadwal as $data) {
                $jadwalHarian = $guru->jadwalkelas->where('id_jadwal', $data->id);
            }
            
            return view('dashboard.dashboard', [
                'guru'                  => $guru, 
                'jumlahGuru'            => $jumlahGuru, 
                'jumlahSiswa'           => $jumlahSiswa, 
                'jumlahKelas'           => $jumlahKelas,
                'jadwalHarian'          => $jadwalHarian,
                'pengumumanSekolah'     => $pengumumanAdmin,
                'pengumumanGuru'        => $pengumumanGuru]); 

        } elseif (Auth::user()->role == 'admin' || (Auth::user()->role == 'super_admin') ) {
            $jumlahAdmin        = Admin::count();
            $jumlahGuru         = Guru::count();
            $jumlahSiswa        = Siswa::count();
            $pengumumanAdmin    = PengumumanAdmin::all();
            $pengumumanGuru     = PengumumanGuru::all();
            $jumlahKelas        = PembagianKelas::all()->count();


            return view('dashboard.dashboard', [
                'jumlahGuru'            => $jumlahGuru, 
                'jumlahSiswa'           => $jumlahSiswa, 
                'jumlahKelas'           => $jumlahKelas,
                'pengumumanSekolah'     => $pengumumanAdmin,
                'pengumumanGuru'        => $pengumumanGuru,
                'jumlahAdmin'           => $jumlahAdmin]); 
            return view('dashboard.dashboard');
        }
    }
}
