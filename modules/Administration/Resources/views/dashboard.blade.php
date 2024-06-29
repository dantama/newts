@extends('administration::layouts.default')

@section('title', 'Dasbor')

@section('content')
    <div class="card mb-4 border-0">
        <div class="card-body">
            <h4>Selamat datang <strong> {{ $user->name }} </strong></h4>
            <h6 class="fw-bold"></h6>
        </div>
    </div>
    <div class="row">
        @foreach ($memberships as $key => $value)
            <div class="col-md-6 col-lg mb-4">
                <div class="card h-100 border-0 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-{{ $value[1] }} text-uppercase mb-1 text-xs">Jumlah {{ $key }}</div>
                                <h1 class="font-weight-bold mb-0 text-gray-800">{{ $value[0] ?? 0 }}</h1>
                            </div>
                            <div class="col-auto"> <i class="{{ $value[2] }} fa-3x text-gray-300"></i> </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-6 col-lg mb-4">
            <div class="card border-left-warning h-100 border-0 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-warning text-uppercase mb-1 text-xs">User</div>
                            <h1 class="font-weight-bold mb-0 text-gray-800">{{ $users_count ?? 0 }}</h1>
                        </div>
                        <div class="col-auto"> <i class="fas fa-users fa-3x text-gray-300"></i> </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-sm-12">
            <div class="card border-0">
                <div class="card-body border-bottom">Statistik Anggota</div>
                <div class="card-body"></div>
            </div>
        </div>
        <div class="col-lg-4 col-sm-12">
            <div class="card mb-4 border-0">
                <div class="card-body border-bottom">
                    <i class="fas fa-sm fa-eye"></i> Postingan paling banyak dilihat
                </div>
                <div class="card-body">
                    @include('web::layouts.components.widgets.widget-3', ['posts' => $most_viewed_posts])
                </div>
            </div>
        </div>
    </div>

@stop
