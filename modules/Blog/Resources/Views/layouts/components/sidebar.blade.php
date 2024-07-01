<div class="sidebar bg-dark open border-end text-white" style="z-index: 9999;">
    <div class="sidebar-header">
        <a class="d-flex align-items-center justify-content-center border-bottom text-center text-white" style="height: 80px;" href="{{ route('account::home') }}">
            <img height="24" src="{{ asset('img/logo/logo-icon-bw-32.png') }}" alt="">
            <div class="h5 mb-0 ps-2">P<span class="text-danger">é</span>Mad</div>
        </a>
    </div>
    <div class="sidebar-body">
        <div class="sidebar-body-menu">
            <ul class="nav flex-column">
                <li class="divider">Utama</li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog::dashboard') }}"> <i class="mdi mdi-apps"></i> Dasbor </a>
                </li>
                <li class="divider">Blog</li>
                @if (count(array_filter([
                            auth()->user()->can('access', Modules\BLog\Models\BlogCategory::class),
                            auth()->user()->can('access', Modules\BLog\Models\BlogPost::class),
                        ])))
                    <li class="nav-item has-submenu">
                        <a class="nav-link" href="javascript:;"> <i class="mdi mdi-file-outline"></i> Artikel</a>
                        <ul class="submenu collapse">
                            @can('access', Modules\Blog\Models\BlogCategory::class)
                                <li><a class="nav-link" href="{{ route('blog::article.categories.index') }}">Kelola kategori</a></li>
                            @endcan
                            @can('access', Modules\Blog\Models\BlogPost::class)
                                <li><a class="nav-link" href="{{ route('blog::article.posts.index') }}">Kelola artikel</a></li>
                            @endcan
                        </ul>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog::testimonies.index') }}"> <i class="mdi mdi-account-outline"></i> Testimoni </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blog::pages.index') }}"> <i class="mdi mdi-web"></i> Laman </a>
                </li>
                <li class="divider">Akun</li>
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
