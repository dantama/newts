@extends('web::layouts.default')

@section('content')
    @include('web::layouts.components.hero')
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="container py-4">
        <div class="row">
            <h1 class="mb-5 text-center"> Artikel Tapaksuci</h1>
            @forelse($latest_posts as $key => $post)
                <div class="col-md-4 mb-4">
                    <div class="card card-hoverable h-100 animatein border-0 shadow">
                        <div class="backgroundEffect"></div>
                        <img class="card-img-top w-100" src="{{ asset('/img/gallery/tapak-suci.png') }}" alt="courses" />
                        <div class="card-body">
                            <h5 class="font-sans-serif fw-bold fs-md-0 fs-lg-1">{{ $post->title }}</h5>
                            <a class="text-muted fs--1 stretched-link text-decoration-none" href="{{ route('web::read', ['category' => $post->category()->slug, 'slug' => $post->slug]) }}">{{ Str::limit(strip_tags($post->content), 100) }}</a>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="bg-secondary container-fluid">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 col-lg-4 mx-lg-5 mx-0 mb-4 bg-white"><img src="{{ asset('/img/gallery/subscribe.png') }}" width="280" alt="cta" /></div>
                <div class="col-md-6 col-lg-5 mx-lg-5 mx-0 py-4">
                    <h5 class="text-danger font-sans-serif fw-bold">Berlangganan sekarang</h5>
                    <h3 class="mb-3 text-white">Dapatkan informasi terbaru Tapak suci</h3>
                    <form class="row g-0 align-items-center">
                        <div class="col">
                            <div class="input-group-icon">
                                <input class="form-control form-little-squirrel-control" type="email" placeholder="Masukan email " aria-label="email" /><i class="fas fa-envelope input-box-icon"></i>
                            </div>
                        </div>
                        <div class="col-auto">
                            <button class="btn btn-danger rounded-0" type="submit">Berlangganan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- <section> close ============================-->
    <!-- ============================================-->
@endsection
