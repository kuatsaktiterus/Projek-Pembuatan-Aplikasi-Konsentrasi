<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Auth::routes([
    'login' => false, // Login routes...

    'register' => false, // Register Routes...

    'reset' => false, // Reset Password Routes...

    'verify' => false, // Email Verification Routes...
]);

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');
Route::middleware('auth')->get('app/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::prefix('app')->middleware('admin')->group(function () {
    /**
     * Admin routing
     */
    // siswa
    Route::resource('siswa', App\Http\Controllers\Admin\SiswaController::class);
    // modal hapus siswa
    Route::get('/siswa/{id}/delete', [App\Http\Controllers\Admin\SiswaController::class, 'actionDeleteSiswa']);
    // siswa import
    Route::post('siswa-import', [App\Http\Controllers\Admin\SiswaController::class, 'store_from_excel'])->name('siswa.store.excel');

    // guru
    Route::resource('guru', App\Http\Controllers\Admin\GuruController::class);
    // siswa import
    Route::post('guru-import', [App\Http\Controllers\Admin\GuruController::class, 'store_from_excel'])->name('guru.store.excel');
    // modal hapus guru
    Route::get('/guru/{id}/delete', [App\Http\Controllers\Admin\GuruController::class, 'actionDeleteGuru']);

    // admin account
    Route::resource('admin', App\Http\Controllers\Admin\Admincontroller::class);
    // modal action admin
    Route::get('/admin/{action}/{id}', [App\Http\Controllers\Admin\Admincontroller::class, 'actionAdmin']);
    // ubah password superadmin
    Route::put('admin-ubah-password', [App\Http\Controllers\Admin\Admincontroller::class, 'ubahPasswordSuperAdmin'])->name('superadmin.update');

    /**
     * Jadwal Routing
     */
    Route::resource('jadwal', App\Http\Controllers\Admin\JadwalController::class);
    // modal action jadwal
    Route::get('/jadwal/{action}/{id}', [App\Http\Controllers\Admin\JadwalController::class, 'actionJadwal']);

    /**
     * kelas routing
     */
    Route::resource('kelas', App\Http\Controllers\Admin\KelasController::class);
    Route::get('/kelas/edit/{id}', [App\Http\Controllers\Admin\KelasController::class, 'actionKelas']);

    /**
     * Jurusan Routing
     */
    Route::resource('jurusan', App\Http\Controllers\Admin\JurusanController::class);
    // modal action jadwal
    Route::get('/jurusan/{action}/{id}', [App\Http\Controllers\Admin\JurusanController::class, 'actionJurusan']);

    /**
     * Pembagian Kelas Routing
     */
    Route::get('pembagian-kelas/{id}', [App\Http\Controllers\Admin\PembagianKelasController::class, 'index']);
    Route::resource('pembagian-kelas', App\Http\Controllers\Admin\PembagianKelasController::class);
    // modal action pembagian kelas
    Route::get('/pembagian-kelas-siswa/action/{action}/{id}', [App\Http\Controllers\Admin\PembagianKelasController::class, 'actionPembagianKelas']);

    /**
     * pembagian kelas siswa routing
     */
    Route::post('pembagian-kelas-siswa/{id}/{idPembagianKelas}', [App\Http\Controllers\Admin\PembagianKelasSiswaController::class, 'store']);
    Route::resource('pembagian-kelas-siswa', App\Http\Controllers\Admin\PembagianKelasSiswaController::class);

    /**
     * mata pelajaran routing
     */
    Route::resource('mata-pelajaran', App\Http\Controllers\Admin\MataPelajaranController::class);
    // modal action pembagian kelas
    Route::get('/mata-pelajaran/{action}/{id}', [App\Http\Controllers\Admin\MataPelajaranController::class, 'actionMataPelajaran']);

    /**
     * Jadwal Kelas routing
     */
    Route::get('jadwal-kelas/{id}', [App\Http\Controllers\Admin\JadwalKelasController::class, 'index']);
    Route::resource('jadwal-kelas', App\Http\Controllers\Admin\JadwalKelasController::class);
    // modal action jadwal kelas
    Route::get('/jadwal-kelas/{action}/{id}', [App\Http\Controllers\Admin\JadwalKelasController::class, 'actionJadwalKelas']);

    /**
     * pengumuman admin guru routing
     */
    Route::resource('admin-pengumuman-guru', App\Http\Controllers\Admin\PengumumanGuruController::class);
    Route::get('/admin-pengumuman-guru/hapus/{id}', [App\Http\Controllers\Admin\PengumumanGuruController::class, 'actionPengumuman']);

    /**
     * pengumuman admin admin routing
     */
    Route::resource('pengumuman-admin', App\Http\Controllers\Admin\PengumumaAdminController::class);
    Route::get('/pengumuman-admin/{action}/{id}', [App\Http\Controllers\Admin\PengumumaAdminController::class, 'actionPengumuman']);
    

});

Route::prefix('app')->middleware('siswa')->group(function()
{
    Route::get('jadwal-kelas-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'index'])->name('jadwal.kelas.siswa');
    Route::get('info-kelas-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'info'])->name('info.kelas.siswa');
    Route::get('mata-pelajaran-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'mataPelajaran'])->name('mata.pelajaran.siswa');
    Route::get('guru-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'guru'])->name('guru.siswa');
    Route::get('profil-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'profil'])->name('profil.siswa');
    Route::get('ganti-profil-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'gantiPassword'])->name('ganti.password.siswa');
    Route::put('ganti-profil-siswa', [App\Http\Controllers\Siswa\SiswaController::class, 'storeGantiPassword'])->name('password.siswa');
});

Route::prefix('app')->middleware('guru')->group(function()
{
    Route::get('jadwal-kelas-guru', [App\Http\Controllers\Guru\GuruController::class, 'jadwalKelas'])->name('jadwal.kelas.guru');
    Route::get('mata-pelajaran-guru', [App\Http\Controllers\Guru\GuruController::class, 'mataPelajaran'])->name('mata.pelajaran.guru');
    Route::get('siswa-guru', [App\Http\Controllers\Guru\GuruController::class, 'siswa'])->name('siswa.guru');
    Route::get('profil-guru', [App\Http\Controllers\Guru\GuruController::class, 'profil'])->name('profil.guru');
    Route::get('ganti-profil-guru', [App\Http\Controllers\Guru\GuruController::class, 'gantiPassword'])->name('ganti.password.guru');
    Route::put('ganti-profil-guru', [App\Http\Controllers\Guru\GuruController::class, 'storeGantiPassword'])->name('password.guru');
    Route::get('pengumuman-guru', [App\Http\Controllers\Guru\GuruController::class, 'indexPengumuman'])->name('pengumuman.guru.index');
    Route::post('pengumuman-guru', [App\Http\Controllers\Guru\GuruController::class, 'storePengumuman'])->name('pengumuman.guru.store');
    Route::put('pengumuman-guru/{id}', [App\Http\Controllers\Guru\GuruController::class, 'updatePengumuman'])->name('pengumuman.guru.update');
    Route::delete('pengumuman-guru/{id}', [App\Http\Controllers\Guru\GuruController::class, 'destroyPengumuman'])->name('pengumuman.guru.destroy');
    Route::get('/pengumuman-guru/{action}/{id}', [App\Http\Controllers\Guru\GuruController::class, 'actionPengumuman'])->name('pengumuman.guru.action');
});