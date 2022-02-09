<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Jurusan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use RealRashid\SweetAlert\Facades\Alert;

class ControllerAdmin extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->jurusan = new Jurusan();
        $this->gurus = new Guru();

        $this->middleware('admin');
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
}
