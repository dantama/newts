<div class="sidebar bg-dark open border-end text-white" style="z-index: 9999;">
    <div class="sidebar-header">
        <div class="d-flex align-items-center justify-content-center border-bottom text-center" style="height: 80px;">
            <img height="24" src="{{ asset('img/logo/logo-icon-bw-32.png') }}" alt="">
            <div class="h5 mb-0 ps-2">P<span class="text-danger">é</span>Mad</div>
        </div>
    </div>
    <div class="sidebar-body">
        <div class="sidebar-body-menu">
            <ul class="nav flex-column">
                <li class="divider">Main</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('core::dashboard') }}"> <i class="mdi mdi-apps"></i> Dasbor </a>
                </li>
                @can('access', \Modules\Account\Models\Member::class)
                    <li class="divider">Anggota</li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('core::membership.members.index') }}"> <i class="mdi mdi-walk"></i> Anggota </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('core::membership.members.index') }}"> <i class="mdi mdi-file-document-multiple-outline"></i> Surat keterangan </a>
                    </li>
                @endcan
                <li class="divider">Sistem</li>
                @can('access', \App\Models\Departement::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('core::system.departments.index') }}"> <i class="mdi mdi-file-tree-outline"></i> Departemen </a>
                    </li>
                @endcan
                @can('access', \App\Models\Position::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('core::system.positions.index') }}"> <i class="mdi mdi-tag-outline"></i> Jabatan </a>
                    </li>
                @endcan
                @can('access', \Modules\Account\Models\User::class)
                    <li class="nav-item has-submenu">
                        <a class="nav-link" href="javascript:;"> <i class="mdi mdi-account-group-outline"></i> Pengguna</a>
                        <ul class="submenu collapse">
                            <li><a class="nav-link" href="{{ route('core::system.users.index') }}">Kelola pengguna </a></li>
                            <li><a class="nav-link" href="{{ route('core::system.user-logs.index') }}">Log </a></li>
                        </ul>
                    </li>
                @endcan
                @can('access', \App\Models\Role::class)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('core::system.roles.index') }}"> <i class="mdi mdi-shield-star-outline"></i> Peran </a>
                    </li>
                @endcan
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
