<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\GuruDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class GuruController extends ControllerAdmin
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GuruDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.guru.guru');
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
            'nama'                  => 'required|max:255|string',
            'jenis_kelamin'         => ['required', Rule::in('laki-laki', 'perempuan')],
            'nip'                   => 'required|max:255|string|unique:gurus,nip|unique:App\models\User,username',
            'golongan'              => 'required|max:255|string',
            'no_telepon'            => 'required|max:255|string',
            'alamat'                => 'required|max:255|string',
            'pendidikan_terakhir'   => 'required|max:255|string',
            'jurusan_pendidikan'    => 'required|max:255|string',
            'foto'                  => 'mimes:jpeg,jpg,png,webp|max:2048',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            try {
                $data = $request->input();
                $user = User::create([
                    'username' => $data['nip'],
                    'password' => Hash::make($data['nip']),
                    'role'     => 'guru'
                ]);
                
                $guru = $user->Gurus()->create([
                    'nama'                  => $data['nama'],
                    'nip'                   => $data['nip'],
                    'golongan'              => $data['golongan'],
                    'jenis_kelamin'         => $data['jenis_kelamin'],
                    'no_telepon'            => $data['no_telepon'],
                    'alamat'                => $data['alamat'],
                    'pendidikan_terakhir'   => $data['pendidikan_terakhir'],
                    'jurusan_pendidikan'    => $data['jurusan_pendidikan'],
                ]);

                if ($request->hasFile('foto')) {
                    $image = $request->file('foto');
                    $name = time().$image->getClientOriginalName();
                    $destinationPath = public_path('/image/guru');
                    $image->move($destinationPath, $name);

                    $guru->update([
                        'foto' => $name
                    ]);
                }
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data guru');
            } catch (\Throwable $th) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data guru')->withInput();
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
            $import = new GuruImport;
            $import->import($request->file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return redirect()->back()->withWarningMessage("Gagal Menambah Data Siswa kesalahan terjadi di baris ".$failures[0]->row().", ".$failures[0]->errors()[0]."");
        }
        return redirect()->back()->withSuccessMessage('Berhasil menyimpan data siswa');
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
            $guru = Guru::find($id);
        } catch (\Throwable $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('dashboard.admin.guru.guru_show', ['guru' => $guru]);
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
            $guru = Guru::find($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        return view('dashboard.admin.guru.guru_edit', ['guru' => $guru, 'jurusan' => $this->jurusan::all()]);
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
            $guru = Guru::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }

        $rules = [
            'nama'                  => 'required|max:255|string',
            'jenis_kelamin'         => ['required', Rule::in('laki-laki', 'perempuan')],
            'golongan'              => 'required|max:255|string',
            'no_telepon'            => 'required|max:255|string',
            'alamat'                => 'required|max:255|string',
            'pendidikan_terakhir'   => 'required|max:255|string',
            'jurusan_pendidikan'    => 'required|max:255|string',
            'foto'                  => 'mimes:jpeg,jpg,png,webp|max:2048',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar")
                ->withInput();
        } else {
            try {
                $data = $request->input();

                $guru->update([
                    'nama'                => $data['nama'],
                    'golongan'            => $data['golongan'],
                    'jenis_kelamin'       => $data['jenis_kelamin'],
                    'no_telepon'          => $data['no_telepon'],
                    'alamat'              => $data['alamat'],
                    'pendidikan_terakhir' => $data['pendidikan_terakhir'],
                    'jurusan_pendidikan'  => $data['jurusan_pendidikan'],
                ]);

                if ($request->hasFile('foto')) {
                    $file = public_path('/image/guru/');
                    if (is_file($file. $guru->foto) && ($guru->foto != 'Default.png')) {
                        unlink($file. $guru->foto);
                    }

                    $image = $request->file('foto');
                    $name = time().$image->getClientOriginalName();
                    $image->move($file, $name);

                    $guru->update([
                        'foto' => $name
                    ]);
                }

                if ($request->filled('password')) {
                    $rules['password'] = ['required', 'string', 'min:8'];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return redirect()->back()->withWarningMessage('Isi data dengan benar, anda salah memasukkan password dengan ketentuan yang benar');
                    } else {
                        try {
                            $user = Guru::find($id)->user;
                            $user->password = Hash::make($data['password']);
                            $user->save();
                        } catch (\Throwable $th) {
                            return redirect()->back()->withWarningMessage('Anda gagal mengedit password user');
                        }
                    }
                }
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data guru');
            } catch (\Throwable $th) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data guru');
            }
        }
    }

    /**
     * Show modal for deleting guru
     */
    public function actionDeleteGuru($id)
    {
    try {
        $id = Crypt::decrypt($id);
        $guru = Guru::findOrFail($id);
    } catch (DecryptException $e) {
        return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
    }

    $returnHTML = view('dashboard.admin.guru.guru_action', ['data' => $guru,])->render();
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
            $id = Guru::find($id);
            $filename = $id->foto;
            $id = $id->user->id;
            $file = public_path('/image/guru/') . $filename;

            if (is_file($file) && ($filename != 'Default.png')) {
                unlink($file);
            }

            try {
                User::find($id)->delete();
                return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
            }
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
    }
}
