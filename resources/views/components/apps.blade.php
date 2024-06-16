<div id="nav-dropdown-apps" class="dropdown-menu dropdown-menu-end position-absolute rounded border-0 p-1 shadow" style="width: 360px;">
    <div class="p-3" style="max-height: 360px; overflow-y: auto;">
        <div class="row justify-content-center gx-1 gy-1">
            <div class="col-4">
                <a class="btn btn-ghost-light text-dark w-100" href="{{ config('app.url') }}">
                    <div class="mt-2" style="height: 46px;">
                        <img src="{{ asset('img/logo/logo-icon.svg') }}" style="height: 36px;" alt="">
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
            @if (Gate::allows('core::access'))
                <div class="col-4">
                    <a class="btn btn-ghost-light text-danger w-100" href="{{ route('core::dashboard') }}">
                        <i class="mdi mdi-account-lock-outline mdi-36px"></i>
                        <div class="d-block text-danger">Admin</div>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
