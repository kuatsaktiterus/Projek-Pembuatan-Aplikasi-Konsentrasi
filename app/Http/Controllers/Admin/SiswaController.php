<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ControllerAdmin;
use Illuminate\Http\Request;
use App\DataTables\Admin\SiswaDataTable;
use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SiswaController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SiswaDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.siswa.siswa');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.siswa.siswa_create', ['jurusan' => $this->jurusan::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $getRuleJurusan = array();
        foreach ($this->jurusan::all() as $jurusan) {
            $getRuleJurusan[] = '' . $jurusan->id . '';
        }

        $rules = [
            'nama' => 'required|max:255|string',
            'jenis_kelamin' => ['required', Rule::in('laki-laki', 'perempuan')],
            'no_telepon' => 'required|max:255|string',
            'tempat_lahir' => 'required|max:255|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|max:255|string',
            'alamat_lengkap' => 'required|max:255|string',
            'alamat_rt' => 'required|max:255|string',
            'alamat_rw' => 'required|max:255|string',
            'alamat_kelurahan' => 'required|max:255|string',
            'alamat_kecamatan' => 'required|max:255|string',
            'kode_pos' => 'required|max:8|string',
            'tinggal_bersama' => ['required', Rule::in('orang tua', 'wali', 'sendiri')],
            'transportasi' => ['required', Rule::in('angkutan umum', 'kendaraan pribadi', 'antar jemput', 'jalan kaki')],
            'jurusan' => ['required', Rule::in($getRuleJurusan)],
            'nik' => 'required|max:255|string|unique:tbl_siswas,nik|unique:App\Models\User,username',
            'nisn' => ['required', 'max:255', 'string', 'unique:tbl_siswas,nisn'],
            'foto' => 'mimes:jpeg,jpg,png,webp|max:2048',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->messages();
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            try {
                $data = $request->input();
                $user = User::create([
                    'username' => $data['nisn'],
                    'password' => Hash::make($data['nisn']),
                    'role' => 'siswa'
                ]);
                
                $siswa = $user->Siswas()->create([
                    'name' => $data['nama'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'no_telepon' => $data['no_telepon'],
                    'nisn' => $data['nisn'],
                    'nik' => $data['nik'],
                    'tempat_lahir' => $data['tempat_lahir'],
                    'tanggal_lahir' => $data['tanggal_lahir'],
                    'agama' => $data['agama'],
                    'alamat_lengkap' => $data['alamat_lengkap'],
                    'alamat_rt' => $data['alamat_rt'],
                    'alamat_rw' => $data['alamat_rw'],
                    'alamat_kelurahan' => $data['alamat_kelurahan'],
                    'alamat_kecamatan' => $data['alamat_kecamatan'],
                    'kode_pos' => $data['kode_pos'],
                    'tinggal_bersama' => $data['tinggal_bersama'],
                    'transportasi' => $data['transportasi'],
                    'id_jurusan' => $data['jurusan'],
                ]);

                if ($request->hasFile('foto')) {
                    $image = $request->file('foto');
                    $name = time().$image->getClientOriginalName();
                    $destinationPath = public_path('/image/siswa');
                    $image->move($destinationPath, $name);

                    $siswa->update([
                        'foto' => $name
                    ]);
                }
                return redirect()->route('siswa.create')->withSuccessMessage('Berhasil menyimpan data siswa');
            } catch (\Throwable $th) {
                return redirect()->route('siswa.create')->withWarningMessage('Gagal menyimpan data siswa')->withInput();
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_from_excel(Request $request)
    {
        $request->validate([
            'file' => 'required|file:xlsx'
        ]);
        
        try {
            $import = new SiswaImport;
            $import->import($request->file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->route('siswa.index')->withWarningMessage("Gagal Menambah Data Siswa kesalahan terjadi di baris ".$failures[0]->row().", ".$failures[0]->errors()[0]."");
        }
        return redirect()->route('siswa.index')->withSuccessMessage('Berhasil menyimpan data siswa');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('dashboard.admin.siswa.siswa_show', ['siswa' => $siswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $id = Crypt::decrypt($id);
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('dashboard.admin.siswa.siswa_edit', ['siswa' => $siswa, 'jurusan' => $this->jurusan::all()]);
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
            $siswa = Siswa::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }

        $getRuleJurusan = array();
        foreach ($this->jurusan::all() as $jurusan) {
            $getRuleJurusan[] = '' . $jurusan->id . '';
        }

        $rules = [
            'nama' => 'required|max:255|string',
            'jenis_kelamin' => ['required', Rule::in('laki-laki', 'perempuan')],
            'no_telepon' => 'required|max:255|string',
            'tempat_lahir' => 'required|max:255|string',
            'tanggal_lahir' => 'required|date',
            'agama' => 'required|max:255|string',
            'alamat_lengkap' => 'required|max:255|string',
            'alamat_rt' => 'required|max:255|string',
            'alamat_rw' => 'required|max:255|string',
            'alamat_kelurahan' => 'required|max:255|string',
            'alamat_kecamatan' => 'required|max:255|string',
            'kode_pos' => 'required|max:8|string',
            'tinggal_bersama' => ['required', Rule::in('orang tua', 'wali', 'sendiri')],
            'transportasi' => ['required', Rule::in('angkutan umum', 'kendaraan pribadi', 'antar jemput', 'jalan kaki')],
            'jurusan' => ['required', Rule::in($getRuleJurusan)],
            'foto' => 'mimes:jpeg,jpg,png,webp|max:2048',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->messages();
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            $siswa = Siswa::find($id);

            try {
                $data = $request->input();

                $siswa->update([
                    'name'              => $data['nama'],
                    'jenis_kelamin'     => $data['jenis_kelamin'],
                    'no_telepon'        => $data['no_telepon'],
                    'tempat_lahir'      => $data['tempat_lahir'],
                    'tanggal_lahir'     => $data['tanggal_lahir'],
                    'agama'             => $data['agama'],
                    'alamat_lengkap'    => $data['alamat_lengkap'],
                    'alamat_rt'         => $data['alamat_rt'],
                    'alamat_rw'         => $data['alamat_rw'],
                    'alamat_kelurahan'  => $data['alamat_kelurahan'],
                    'alamat_kecamatan'  => $data['alamat_kecamatan'],
                    'kode_pos'          => $data['kode_pos'],
                    'tinggal_bersama'   => $data['tinggal_bersama'],
                    'transportasi'      => $data['transportasi'],
                    'id_jurusan'        => $data['jurusan'],
                ]);

                if ($request->hasFile('foto')) {
                    $image = $request->file('foto');

                    $file = public_path('/image/siswa/') . $siswa->foto;
                    if (is_file($file) && ($siswa->foto != 'Default.png')) {
                        unlink($file);
                    }

                    $name = time().$image->getClientOriginalName();
                    $destinationPath = public_path('/image/siswa');
                    $image->move($destinationPath, $name);

                    $siswa->update([
                        'foto' => $name
                    ]);
                }

                if ($request->filled('password')) {
                    $rules['password'] = ['required', 'string', 'min:8'];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return redirect()->route('siswa.edit', ['siswa' => Crypt::encrypt($id)])
                            ->withWarningMessage('Isi data dengan benar, anda salah memasukkan password dengan ketentuan yang benar');
                    } else {
                        try {
                            $user = Siswa::find($id)->user;
                            $user->password = Hash::make($data['password']);
                            $user->save();
                        } catch (\Throwable $th) {
                            return redirect()->route('siswa.edit', ['siswa' => Crypt::encrypt($id)])->withWarningMessage('Anda gagal mengupdate password user');
                        }
                    }
                }
                return redirect()->route('siswa.edit', ['siswa' => Crypt::encrypt($id)])
                ->withSuccessMessage('Berhasil mengedit data siswa');
            } catch (\Throwable $th) {
                return redirect()->route('siswa.edit', ['siswa' => Crypt::encrypt($id)])
                ->withWarningMessage('Gagal mengedit data siswa')->withInput();
            }
        }
    }

    /**
     * Show modal for deleting siswa
     */
    public function actionDeleteSiswa($id)
    {
    try {
        $id = Crypt::decrypt($id);
        $siswa = Siswa::findOrFail($id);
    } catch (DecryptException $e) {
        return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
    }

    $returnHTML = view('dashboard.admin.siswa.siswa_action', ['data' => $siswa,])->render();
    return response()->json(['html' => $returnHTML]);
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
            $id = Siswa::find($id);
            $filename = $id->foto;
            $id = $id->user->id;

            $file = public_path('/image/siswa/') . $filename;
            if (is_file($file) && ($filename != 'Default.png')) {
                unlink($file);
            }

            User::find($id)->delete();
            return redirect()->route('siswa.index')->withSuccessMessage('Berhasil Menghapus Data');
            try {
            } catch (\Throwable $e) {
                return redirect()->route('siswa.index')->withWarningMessage('Gagal Menghapus Data');
            }
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
