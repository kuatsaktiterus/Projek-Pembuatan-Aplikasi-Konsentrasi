@extends('dashboard.layout.app')

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
