<?php

namespace Database\Seeders;

use App\Models\Jadwal;
use App\Models\JadwalKelas;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PembagianKelas;
use App\Models\PembagianKelasSiswa;
use App\Models\PengumumanAdmin;
use App\Models\PengumumanGuru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $jurusans = [
            ['id' => 1, 'jurusan' => 'IPA'],
            ['id' => 2, 'jurusan' => 'IPS'],
        ];

        foreach($jurusans as $jurusan){
            Jurusan::create($jurusan);
        }

        $users = [
            ['id' => 1, 'username' => 'riki', 'password' => Hash::make('12345678'), 'role' => 'super_admin'],
            ['id' => 2, 'username' => '161348',  'password' => Hash::make('161348'), 'role' => 'siswa'],
            ['id' => 3, 'username' => '199011092014021007',  'password' => Hash::make('199011092014021007'), 'role' => 'guru'],
            ['id' => 4, 'username' => '192442',  'password' => Hash::make('192442'), 'role' => 'admin'],
        ];

        foreach($users as $user){
            User::create($user);
        }

        \App\Models\Siswa::create([
            'id'                    => '1',
            'name'                  => 'Ricky Heri Sappa',
            'jenis_kelamin'         => 'laki-laki',
            'no_telepon'            => '081433538729',
            'nisn'                  => '161348',
            'nik'                   => '7317231130306010001',
            'tempat_lahir'          => 'Makassar',
            'tanggal_lahir'         => '2021-12-28',
            'agama'                 => 'kristen protestan',
            'alamat_lengkap'        => 'Jl. Tidung VI Stp 3 No.53',
            'alamat_rt'             => '02',
            'alamat_rw'             => '03',
            'alamat_kelurahan'      => 'Mappala',
            'alamat_kecamatan'      => 'Rappocini',
            'kode_pos'              => '92002',
            'tinggal_bersama'       => 'orang tua',
            'transportasi'          => 'kendaraan pribadi',
            'id_user'               => 2,
            'id_jurusan'            => '1',
        ]);

        \App\Models\Guru::create([
            'id'                    => '1',
            'nip'                   => '199011092014021007',
            'golongan'              => 'IV/a',
            'nama'                  => 'Heri',
            'jenis_kelamin'         => 'laki-laki',
            'alamat'                => 'Bumi Tamalanrea Permai',
            'no_telepon'            => '0812345678',
            'pendidikan_terakhir'   => 'S1-Teknik Informatika',
            'jurusan_pendidikan'    => 'Pendidikan Bimbingan Konseling',
            'id_user'               => '3',
        ]);
        \App\Models\Admin::create([
            'id'        => '1',
            'nama'      => 'Admin 1',
            'id_user'   => 4,
        ]);

        $jadwals = [
            ['id' => 1, 'jam_mulai' => '07:30:00',  'jam_selesai' => '09:00:00', 'hari' => 1],
            ['id' => 2, 'jam_mulai' => '09:20:00',  'jam_selesai' => '11:10:00', 'hari' => 2],
            ['id' => 3, 'jam_mulai' => '01:00:00',  'jam_selesai' => '15:00:00', 'hari' => 3],
            ['id' => 4, 'jam_mulai' => '15:10:00',  'jam_selesai' => '17:00:00', 'hari' => 4],
        ];

        foreach($jadwals as $jadwal){
            Jadwal::create($jadwal);
        }

        $kelases = [
            ['id' => 1, 'kelas' => 'X',  'id_jurusan' => 1],
            ['id' => 2, 'kelas' => 'XI', 'id_jurusan' => 1],
            ['id' => 3, 'kelas' => 'XII','id_jurusan' => 1],
            ['id' => 4, 'kelas' => 'X',  'id_jurusan' => 2],
            ['id' => 5, 'kelas' => 'XI', 'id_jurusan' => 2],
            ['id' => 6, 'kelas' => 'XII','id_jurusan' => 2],
        ];

        foreach($kelases as $kelas){
            Kelas::create($kelas);
        }

        $pembagianKelase = [
            ['id' => 1, 'nama_kelas' => 'A', 'wali_kelas' => 1, 'id_kelas' => 1],
            ['id' => 2, 'nama_kelas' => 'A', 'wali_kelas' => 1, 'id_kelas' =>2],
        ];
        
        foreach($pembagianKelase as $pembagianKelases){
            PembagianKelas::create($pembagianKelases);
        }

        $pembagianKelase = [
            ['id' => 1, 'id_siswa' => 1, 'id_pembagian_kelas' => 1],
        ];
        
        foreach($pembagianKelase as $pembagianKelases){
            PembagianKelasSiswa::create($pembagianKelases);
        }

        $mapels = [
            ['id' => 1, 'nama_mapel' => 'Fisika',  ],
            ['id' => 2, 'nama_mapel' => 'Kimia', ],
            ['id' => 3, 'nama_mapel' => 'Matematika',],
        ];

        foreach($mapels as $mapel){
            MataPelajaran::create($mapel);
        }

        $jadwal_kelases = [
            ['id' => 1, 'id_pembagian_kelas' => 1,  'id_matapelajaran' => 1, 'id_pengajar' => 1, 'id_jadwal' => 1],
            ['id' => 2, 'id_pembagian_kelas' => 1,  'id_matapelajaran' => 2, 'id_pengajar' => 1, 'id_jadwal' => 2],
        ];

        foreach($jadwal_kelases as $jadwal_kelas){
            JadwalKelas::create($jadwal_kelas);
        }

        $pengumumanGurus = [
            ['id' => 1, 'pengumuman' => "Hari besok terakhir mengumpulkan tugas 2", 'waktu_pengumuman' => date(now()), 'id_guru' => 1],
            ['id' => 2, 'pengumuman' => "Mengambil formulir biodata di ruang guru", 'waktu_pengumuman' => date(now()), 'id_guru' => 1],
        ];
        
        foreach($pengumumanGurus as $pengumumanGuru){
            PengumumanGuru::create($pengumumanGuru);
        }

        $pengumumanAdmins = [
            ['id' => 1, 'pengumuman' => "Bulan Depan tanggal 02-14 UAS", 'waktu_pengumuman' => date(now())],
        ];
        
        foreach($pengumumanAdmins as $pengumumanAdmin){
            PengumumanAdmin::create($pengumumanAdmin);
        }
    }
}
