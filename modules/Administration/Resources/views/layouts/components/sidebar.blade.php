@php
    $user = Auth::user();
    $unitKd = $user->manager->unit_departement->unit->kd;
@endphp
<div class="sidebar bg-dark open border-end text-white" style="z-index: 9999;">
    <div class="sidebar-header">
        <div class="d-flex align-items-center justify-content-center border-bottom text-center" style="height: 80px;">
            <img height="24" src="{{ asset('img/logo/logo-icon.png') }}" alt="">
            <div class="h5 mb-0 ps-2">{{ env('APP_NAME') }}</div>
        </div>
    </div>
    <div class="sidebar-body">
        <div class="sidebar-body-menu">
            <ul class="nav flex-column">
                <li class="divider">Main</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration::dashboard') }}"> <i class="mdi mdi-apps"></i> Dasbor </a>
                </li>
                <li class="divider">Administrasi</li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="javascript:;"> <i class="mdi mdi-bank"></i> Organisasi</a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{ route('administration::units.index', ['unit' => $unitKd]) }}"> Unit </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('administration::units.departements.index', ['unit' => $unitKd]) }}"> Unit departemen </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('administration::units.positions.index', ['unit' => $unitKd]) }}"> Unit jabatan </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('administration::managers.index') }}"> <i class="mdi mdi-account-circle-outline"></i> Pengurus </a>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link" href="javascript:;"> <i class="mdi mdi-account-group-outline"></i> Keanggotaan</a>
                    <ul class="submenu collapse">
                        <li>
                            <a class="nav-link" href="{{ route('administration::members.index') }}"> Anggota </a>
                        </li>
                        <li>
                            <a class="nav-link" href="{{ route('administration::students.index') }}"> Siswa </a>
                        </li>
                    </ul>
                </li>
                <li class="divider">Account</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account::home') }}"> <i class="mdi mdi-account-outline"></i> Akun saya </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('account::user.password', ['next' => url()->full()]) }}"> <i class="mdi mdi-lock-open-outline"></i> Ubah sandi </a>
                </li>
                <li class="nav-item">
                    <button class="btn w-100 nav-link text-danger" onclick="signout()"> <i class="mdi mdi-logout text-danger"></i> Keluar </button>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-footer">
        <div class="rounded-3 d-flex align-items-center flex-row p-3" style="background: rgba(200, 200, 200, .1);">
            <div class="rounded-circle me-3" style="width: 48px; height: 48px; background: url('{{ Auth::user()->profile_avatar_path }}') center center no-repeat; background-size: cover;"></div>
            <div class="flex-grow-1">
                <div class="fw-bold mb-0">{{ Str::limit(Auth::user()->name, 15) }}</div>
                <div class="small" style="color: rgba(150, 150, 150, .9)">{{ Str::limit(Auth::user()->email_address, 20) }}</div>
            </div>
        </div>
    </div>
</div>
