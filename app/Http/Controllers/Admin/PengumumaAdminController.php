<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Admin\PengumumanSekolahDataTable;
use App\Http\Controllers\Controller;
use App\Models\PengumumanAdmin;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PengumumaAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PengumumanSekolahDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.pengumuman.pengumuman_sekolah.pengumuman');
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
            'pengumuman' => 'required|max:255|string',
        ];

        $data = $request->input();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withWarningMessage("Masukkan data dengan benar");
        } else {
            try {
                PengumumanAdmin::create([
                    'pengumuman'        => $data['pengumuman'],
                    'waktu_pengumuman'  => date(now()),
                    ]);
                return redirect()->back()->withSuccessMessage('Berhasil menyimpan data pengumuman');
            } catch (Exception $e) {
                return redirect()->back()->withWarningMessage('Gagal menyimpan data pengumuman')->withInput();
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
    * Show modal for deleting and editing pengumuman
    */
   public function actionPengumuman($action, $id)
   {
       try {
           $id = Crypt::decrypt($id);
           $pengumuman = PengumumanAdmin::findOrFail($id);
       } catch (DecryptException $th) {
           return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
       }

       $returnHTML = view('dashboard.admin.pengumuman.pengumuman_sekolah.pengumuman_action', ['data' => $pengumuman, 'action' => $action])->render();
       return response()->json(['html' => $returnHTML]);
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
            $pengumuman = PengumumanAdmin::findOrFail($id);
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
    public function destroy($id)
    {
        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
        }

        try {
            PengumumanAdmin::find($id)->delete();
            return redirect()->back()->withSuccessMessage('Berhasil Menghapus Data');
        } catch (Exception $e) {
            return redirect()->back()->withWarningMessage('Gagal Menghapus Data');
        }
    }
}
