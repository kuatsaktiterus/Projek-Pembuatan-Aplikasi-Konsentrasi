@extends('dashboard.layout.app')

@if (Auth::user()->role == 'admin' || Auth::user()->role == 'super_admin')
{{-- area admin --}}
{{-- dashboard admin --}}
@section('thumbnailProfil')
    @if (Auth::user()->role == 'super_admin')
        <span>Super Admin</span>
    @elseif (Auth::user()->role == 'admin')
        <span>{{Auth::user()->admins->nama }}</span>
    @endif
@endsection

@if (Auth::user()->role == 'super_admin')
@section('profil')
<button class="dropdown-item" data-toggle="modal" data-target="#edit_modal" data-whatever="@mdo"><i class="fas fa-lock pr-2"></i>
    Ubah Password</button>
@endsection
@section('modal')
        <!-- Modal -->
<div class="modal fade show" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Data Admin</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body">
        <form method="POST" action="{{ route('superadmin.update') }}">
            @csrf
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="password" class="col-form-label">Password lama</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Isikan password lama anda">
            </div>
            <div class="form-group">
                <label for="passwordBaru" class="col-form-label">Password baru</label>
                <input type="password" class="form-control" id="passwordBaru" name="passwordBaru" placeholder="Isikan password baru, minimal 8 karakter">
            </div>
            <div class="form-group">
                <label for="konfirmasiPassword" class="col-form-label">Konfirmasi Password baru</label>
                <input type="password" class="form-control" id="konfirmasiPassword" name="konfirmasiPassword" placeholder="Isikan password baru, minimal 8 karakter">
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
        </div>
        
    </div>
    </div>
</div>
@endsection
@endif

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
            <a href="#" onclick="toggle_menu('user'); return false" class=""><i class="fas fa-chalkboard-teacher mr-3"> </i>
                <span class="none">User <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="user">
                @if (Auth::user()->role == 'super_admin')
                    <li class="child"><a href="{{ route('admin.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Admin</a></li>
                @endif
                <li class="child"><a href="{{ route('siswa.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Siswa</a></li>
                <li class="child"><a href="{{ route('guru.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Guru</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="#" onclick="toggle_menu('jadwal'); return false" class=""><i class="fas fa-chalkboard mr-3"></i>
                <span class="none">Jadwal Dan Kelas <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="jadwal">
                <li class="child"><a href="{{ route('jadwal.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jadwal</a></li>
                <li class="child"><a href="{{ route('kelas.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Jurusan Dan Kelas</a></li>
            </ul>
        </li>

        <li class="parent">
            <a href="{{ route('mata-pelajaran.index') }}" class=""><i class="fas fa-book mr-3"> </i>
                <span class="none">Mata Pelajaran</span>
            </a>
        </li>

        <li class="parent">
            <a href="#" onclick="toggle_menu('pengumuman'); return false" class=""><i class="far fa-flag mr-3"></i>
                <span class="none">Pengumuman <i class="fa fa-angle-down pull-right align-bottom"></i></span>
            </a>
            <ul class="children" id="pengumuman">
                <li class="child"><a href="{{ route('pengumuman-admin.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Pengumuman Sekolah</a></li>
                <li class="child"><a href="{{ route('admin-pengumuman-guru.index') }}" class="ml-4"><i class="fa fa-angle-right mr-2"></i> Pengumuman Guru</a></li>
            </ul>
        </li>
    </ul>
</div>
@endsection

{{-- dashboard admin --}}
@section('content_right')

<div class="mt-1 mb-3 button-container">
    <div class="row pl-0">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-cog"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahAdmin}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Admin</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahSiswa}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Siswa</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahGuru}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Guru</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahKelas}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Kelas Di Sekolah</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Pengumuman</h6><hr>
            
            <div class="updates-wrapper border-left">
                @foreach ($pengumumanSekolah as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Sekolah</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}}</span>
                </div>
                @endforeach
                @foreach ($pengumumanGuru as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Guru</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}} dari {{ $data->guru->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection










@elseif (Auth::user()->role == 'siswa')
{{-- area siswa --}}
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

{{-- sidebar menu siswa --}}
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

{{-- dashboard siswa --}}
@section('content_right')

<div class="mt-1 mb-3 button-container">
    <div class="row pl-0">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahSiswa}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Siswa</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahGuru}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Guru</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahKelas}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Kelas Di Jurusan {{$siswa->jurusan->jurusan}} {{$siswa->pembagiankelassiswa[0]->pembagiankelas->kelas->kelas}} <!-- data kelas --></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Pengumuman</h6><hr>
            
            <div class="updates-wrapper border-left">
                @foreach ($pengumumanSekolah as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Sekolah</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}}</span>
                </div>
                @endforeach
                @foreach ($pengumumanGuru as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Guru</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}} dari {{ $data->guru->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Jadwal Hari Ini</h6><hr>
            @foreach ($jadwalHarian as $data)
                <div class="updates-wrapper border-left">
                    <div class="updates-content p-3 up-primary">
                        <h6 class="bc-header-small">{{ $data->matapelajaran->nama_mapel }}</h6>
                        <span class="small"><i class="fas fa-clock text-success"></i> {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->translatedFormat('H:i') }} - {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->translatedFormat('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection







@elseif (Auth::user()->role == 'guru')
{{-- area guru --}}
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

        <li class="parent">
            <a href="{{ route('pengumuman.guru.index') }}"class=""><i class="far fa-flag mr-3"></i>
                <span class="none"> Pengumuman </span>
            </a>
        </li>
    </ul>
</div>
@endsection

{{-- dashboard guru --}}
@section('content_right')

<div class="mt-1 mb-3 button-container">
    <div class="row pl-0">
        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-user-graduate"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahSiswa}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Siswa</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahGuru}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Guru</small></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-3">
            <div class="bg-white border shadow">
                <div class="media p-4">
                    <div class="align-self-center mr-3 rounded-circle notify-icon bg-theme">
                        <i class="fas fa-landmark"></i>
                    </div>
                    <div class="media-body pl-2">
                        <h3 class="mt-0 mb-0"><strong>{{$jumlahKelas}}</strong></h3>
                        <p><small class="text-muted bc-description">Jumlah Kelas Di Sekolah {{ $jumlahKelas }} <!-- data kelas --></small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Pengumuman</h6><hr>
            
            <div class="updates-wrapper border-left">
                @foreach ($pengumumanSekolah as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Sekolah</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}}</span>
                </div>
                @endforeach
                @foreach ($pengumumanGuru as $data)
                <div class="updates-content p-3 up-warning">
                    <h6 class="bc-header-small">Pengumuman Guru</h6>
                    <p class="bc-description">{{$data->pengumuman}}</p>
                    <span class="small"><i class="fas fa-clock text-success"></i> {{ $data->waktu_pengumuman}} dari {{ $data->guru->nama }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-sm-6">
        <div class="mt-1 mb-3 p-3 button-container bg-white shadow-sm border">
            <h6 class="mb-3">Jadwal Hari Ini</h6><hr>
            @foreach ($jadwalHarian as $data)
                <div class="updates-wrapper border-left">
                    <div class="updates-content p-3 up-primary">
                        <h6 class="bc-header-small">{{ $data->matapelajaran->nama_mapel }}</h6>
                        <span class="small"><i class="fas fa-clock text-success"></i> {{ \Carbon\Carbon::parse($data->jadwal->jam_mulai)->translatedFormat('H:i') }} - {{ \Carbon\Carbon::parse($data->jadwal->jam_selesai)->translatedFormat('H:i') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@endif