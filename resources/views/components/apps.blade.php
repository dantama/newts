<div id="nav-dropdown-apps" class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 p-1 shadow" style="width: 360px;">
    <div class="p-3" style="max-height: 360px; overflow-y: auto;">
        <div class="row justify-content-center gx-1 gy-1">
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ config('app.url') }}">
                    <div class="mt-2" style="height: 46px;">
                        <img src="{{ asset('img/logo/logo-icon.png') }}" style="height: 36px;" alt="">
                    </div>
                    <div class="d-block text-dark">Beranda</div>
                </a>
            </div>
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('account::index') }}">
                    <i class="mdi mdi-account-circle-outline mdi-36px"></i>
                    <div class="d-block text-dark">Akun</div>
                </a>
            </div>
            @if (Gate::allows('administration::access'))
                <div class="col-4">
                    <a class="btn btn-ghost-light text-dark w-100" href="{{ route('administration::dashboard') }}">
                        <i class="mdi mdi-account-multiple mdi-36px"></i>
                        <div class="d-block text-dark">Administrasi</div>
                    </a>
                </div>
            @endif
            @if (Gate::allows('blog::access'))
                <div class="col-4">
                    <a class="btn btn-ghost-light text-dark w-100" href="{{ route('blog::dashboard') }}">
                        <i class="mdi mdi-file-document-multiple-outline mdi-36px"></i>
                        <div class="d-block text-dark">Artikel</div>
                    </a>
                </div>
            @endif
            {{-- @if (Gate::allows('event::access')) --}}
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ route('event::home') }}">
                    <i class="mdi mdi-file-document-multiple-outline mdi-36px"></i>
                    <div class="d-block text-dark">Kegiatan</div>
                </a>
            </div>
            {{-- @endif --}}
            @if (Gate::allows('core::access'))
                <div class="col-4">
                    <a class="btn btn-ghost-light text-danger w-100" href="{{ route('core::dashboard') }}">
                        <i class="mdi mdi-cogs mdi-36px"></i>
                        <div class="d-block text-danger">Pengaturan</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
