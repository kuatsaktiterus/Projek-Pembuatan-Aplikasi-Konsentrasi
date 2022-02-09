@extends('dashboard.layout.app')

@section('thumbnailProfil')
    <img 
    src="{{asset('image/guru/'.Auth::user()->gurus->foto)}}"
    alt="Foto"
    class="rounded-circle" width="40px" height="40px">
@endsection

@section('profil')
<a class="dropdown-item" href="{{ route('profil.guru') }}"><i class="fa fa-user pr-2"></i> Profile</a>
<div class="dropdown-divider"></div>
@endsection

{{-- sidebar menu guru --}}
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
            <a href="{{ route('jadwal.kelas.guru') }}"class=""><i class="fas fa-calendar-alt mr-3"></i>
                <span class="none"> Jadwal Kelas</span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('mata.pelajaran.guru') }}"class=""><i class="fas fa-book mr-3"></i>
                <span class="none"> Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href="{{ route('siswa.guru') }}"class=""><i class="fas fa-user-tie mr-3"></i>
                <span class="none"> Siswa </span>
            </a>
        </li>
    </ul>
</div>
@endsection