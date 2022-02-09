<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\Guru\PengumumanGuruDataTable;
use App\Http\Controllers\Controller;
use App\Models\PengumumanGuru;
use Exception;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class PengumumanGuruController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PengumumanGuruDataTable $dataTable)
    {
        return $dataTable->render('dashboard.admin.pengumuman.pengumuman_guru.pengumuman');
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
        //
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
   public function actionPengumuman($id)
   {
       try {
           $id = Crypt::decrypt($id);
           $pengumuman = PengumumanGuru::findOrFail($id);
       } catch (DecryptException $th) {
           return redirect()->back()->withWarningMessage('Maaf terjadi kesalahan');
       }

       $returnHTML = view('dashboard.admin.pengumuman.pengumuman_guru.pengumuman_action', ['data' => $pengumuman])->render();
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
}
