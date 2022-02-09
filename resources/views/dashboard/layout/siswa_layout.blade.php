@extends('dashboard.layout.app')

@section('thumbnailProfil')
    <img 
    src="{{asset('image/siswa/'.Auth::user()->siswas->foto)}}"
    alt="Foto"
    class="rounded-circle" width="40px" height="40px">
@endsection

@section('profil')
<a class="dropdown-item" href="{{ route('profil.siswa') }}"><i class="fa fa-user pr-2"></i> Profile</a>
<div class="dropdown-divider"></div>
@endsection

@section('sidebar')
<div class="sidebar-menu-container">
    <ul class="sidebar-menu mt-4 mb-4">
        {{-- dashboard section --}}
        <li class="parent">
            <a href="{{ route('dashboard') }}"class=""><i class="fa fa-dashboard mr-3"></i>
                <span class="none"> Dashboard </span>
            </a>
        </li>

        {{-- user section --}}
        <li class="parent">
            <a href="#" onclick="toggle_menu('jadwal'); return false" class=""><i class="fas fa-landmark mr-3"></i>
                <span class="none">Kelas <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="jadwal">
                <li class="child"><a href="{{ route('jadwal.kelas.siswa') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jadwal Kelas</a></li>
                <li class="child"><a href="{{ route('info.kelas.siswa') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Info Kelas</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="{{ route('mata.pelajaran.siswa') }}"class=""></i><i class="fas fa-book mr-3"></i>
                <span class="none"> Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('guru.siswa') }}"class=""></i><i class="fas fa-user-tie mr-3"></i>
                <span class="none"> Guru </span>
            </a>
        </li>
    </ul>
</div>
@endsection
