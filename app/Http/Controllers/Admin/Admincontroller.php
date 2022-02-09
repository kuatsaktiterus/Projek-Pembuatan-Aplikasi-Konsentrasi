<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\AdminDataTable;
use App\Http\Controllers\ControllerAdmin;
use App\Models\Admin;
use App\Models\User;
use App\Rules\MatchOldPassword;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class Admincontroller extends ControllerAdmin
{
    public function __construct()
    {
        
        $this->middleware('super_admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdminDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.admin.admin');
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
            'nama' => 'required|max:255|string',
            'username' => 'required|max:255|string|unique:users,username',
            'password' => ['required', 'string', 'min:8'],
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            try {
                $user = User::create([
                    'username' => $data['username'],
                    'password' => Hash::make($data['password']),
                    'role'     => 'admin',
                ]);

                $admin = $user->Admins()->create([
                    'nama'    => $data['nama'],
                ]);

                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data admin');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data admin')->withInput();
            }
        }
    }

    /**
     * Show modal for deleting and editing admin
     */
    public function actionAdmin($action, $id)
    {
        try {
            $id = Crypt::decrypt($id);
            $admin = Admin::findOrFail($id);
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }
        $returnHTML = view('dashboard.admin.admin.admin_action', ['data' => $admin, 'action' => $action])->render();
        return response()->json(['html' => $returnHTML]);
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
            $admin = Admin::find($id);
        } catch (DecryptException $e) {
            return redirect()->route('siswa.index')->withWarningMessage('Maaf terjadi kesalahan');
        }
        $rules = [
            'nama'      => 'required|max:255|string',
            'username'  => 'required|max:255|string|unique:users,username,'.$admin->id_user,
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            $admin->update([
                'nama' => $data['nama'],
            ]);

            $admin->User()->update([
                'username' => $data['username'],
            ]);

            try {
                if ($request->filled('password')) {
                    $rules['password'] = ['string', 'min:8'];
                    $validator = Validator::make($request->all(), $rules);
                    if ($validator->fails()) {
                        return redirect()->back()->withWarningMessage('Isi data dengan benar, anda salah memasukkan password dengan ketentuan yang benar');
                    } else {
                        try {
                            $admin->User()->update([
                                'password' => Hash::make($data['password']),
                            ]);
                        } catch (\Throwable $th) {
                            return redirect()->back()->withWarningMessage('Anda gagal mengupdate password user');
                        }
                    }
                }
                return redirect()->back()->withSuccessMessage('Berhasil mengedit data admin');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal mengedit data admin')->withInput();
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ubahPasswordSuperAdmin(Request $request)
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
        } catch (DecryptException $th) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            $id = Admin::find($id);
            $id = $id->user->id;
            User::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
