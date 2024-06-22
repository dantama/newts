<nav class="navbar navbar-expand-lg navbar-light sticky-top d-block py-2" data-navbar-on-scroll="data-navbar-on-scroll">
    <div class="container"><a class="navbar-brand" href="index.html"><img src="{{ asset('/img/logo/logo.png') }}" height="45" alt="logo" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"> </span></button>
        <div class="navbar-collapse border-top border-lg-0 mt-lg-0 collapse mt-4" id="navbarSupportedContent">
            <ul class="navbar-nav pt-lg-0 font-base ms-auto pt-2">
                <li class="nav-item px-2"><a class="nav-link active" aria-current="page" href="{{ env('APP_URL') }}">Beranda</a></li>
                <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="pricing.html">Profil</a></li>
                <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="web-development.html">Artikel</a></li>
                <li class="nav-item px-2"><a class="nav-link" aria-current="page" href="user-research.html">Kegiatan</a></li>
            </ul>
            <a class="btn btn-danger order-lg-0 text-light order-1" href="{{ route('account::home') }}">Masuk <i class="mdi mdi-account-arrow-right-outline"></i></a>
            <form class="d-flex d-block d-lg-none my-3">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-primary" type="submit">Search</button>
            </form>
            <div class="dropdown d-none d-lg-block">
                <button class="btn btn-outline-light ms-2" id="dropdownMenuButton1" type="submit" data-bs-toggle="dropdown" aria-expanded="false"><i class="mdi mdi-magnify text-800"></i></button>
                <ul class="dropdown-menu dropdown-menu-lg-end" aria-labelledby="dropdownMenuButton1" style="top:55px">
                    <form>
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" />
                    </form>
                </ul>
            </div>
        </div>
    </div>
</nav>
