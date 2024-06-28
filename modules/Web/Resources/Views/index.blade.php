@extends('web::layouts.default')

@section('content')
    @include('web::layouts.components.hero')
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="animateup animatein py-0" style="margin-top:-4.5rem">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-9">
                    <div class="card card-hoverable card-span bg-danger">
                        <div class="card-body">
                            <div class="row flex-center gx-0">
                                <div class="col-lg-4 col-xl-2 text-xl-start text-center"><img src="{{ asset('/img/gallery/funfacts.png') }}" width="120" alt="..." /></div>
                                <div class="col-lg-8 col-xl-5">
                                    <h3 class="text-light fs-lg-3 fs-xl-4">Kegiatan baru akan diadakan...</h3>
                                </div>
                                <div class="col-lg-12 col-xl-5">
                                    <h2 class="display-5 text-light text-xl-end text-center">11 : 02 : 45 : 21</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end of .container-->
    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->

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
    <div class="container-fluid bg-secondary">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 col-lg-6 h-100 bg-light px-4 py-2">
                <div class="card card-hoverable card-span h-100 bg-light text-white">
                    <img class="w-100" src="{{ asset('/img/gallery/barri.jpg') }}" alt="..." />
                    <div class="card-body px-xl-5 px-md-3 pt-0">
                        <div class="d-flex flex-column align-items-center bg-secondary" style="margin-top:-2.4rem;">
                            <h5 class="text-light mb-0 mt-3">Moh. Barrie Irsyad</h5>
                            <p class="fw-bold text-light">Pendiri KASEGU</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 h-100 px-4 py-2">
                <h4 editable="inline" class="display-4 fw-bold mt-2 text-white" style="letter-spacing: -2px;">Tentang kami!</h4>
                <h2 class="my-3"><span class="text-danger">Tapak Suci</span> <span class="text-light">Putera Muhammadiyah</span></h2>
                <p class="text-light">
                    Tapak Suci, adalah sebuah aliran, perguruan, dan organisasi pencak silat yang merupakan anggota Ikatan Pencak Silat Indonesia (IPSI). Tapak Suci termasuk dalam 10 perguruan historis IPSI, yaitu perguruan yang menunjang tumbuh dan berkembangnya IPSI sebagai organisasi. Tapak Suci berasas Islam, bersumber pada Al Qur'an dan As-Sunnah, berjiwa persaudaraan, berada di bawah naungan Persyarikatan Muhammadiyah sebagai organisasi otonom yang ke-11.
                </p>
                <div class="mt-4">
                    <div class="card card-hoverable card-span bg-secondary">
                        <div class="card-body">
                            <div class="row flex-center gx-0">
                                <div class="col-lg-4 col-xl-3 text-xl-start text-center">
                                    <img src="{{ asset('/img/logo/tapak-suci-png-5.png') }}" width="120" alt="courses" />
                                </div>
                                <div class="col-lg-8 col-xl-9">
                                    <h5 class="font-sans-serif fw-bold text-light">Dengan Iman dan Akhlak saya menjadi kuat, tanpa Iman dan akhlak saya menjadi lemah</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <section>
        <div class="bg-holder" style="background-image:url({{ asset('/img/gallery/funfacts-2-bg.png') }});background-position:center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/published.png') }}" height="100" alt="..." />
                    <h2 class="my-2">6000+</h2>
                    <p class="text-danger fw-bold">ANGGOTA</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/instructors.png') }}" height="100" alt="..." />
                    <h2 class="my-2">3000+</h2>
                    <p class="text-danger fw-bold">SISWA</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/learners.png') }}" height="100" alt="..." />
                    <h2 class="my-2">500+</h2>
                    <p class="text-danger fw-bold">KEJUARAAN</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/awards.png') }}" height="100" alt="..." />
                    <h2 class="my-2">80+</h2>
                    <p class="text-danger fw-bold">JUARA</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="bg-secondary container-fluid">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-6 col-lg-4 bg-light mx-lg-4 mx-0"><img src="{{ asset('/img/gallery/subscribe.png') }}" width="280" alt="cta" /></div>
                <div class="col-md-6 col-lg-5 mx-lg-4 mx-0 py-4">
                    <h5 class="text-danger font-sans-serif fw-bold">Berlangganan sekarang</h5>
                    <h3 class="text-light mb-3">Dapatkan informasi terbaru<br />Tapak suci</h3>
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

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="container-fluid bg-white p-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-lg-0 mx-lg-2 mx-0 mb-4">
                        <h2 class="mb-3">Kontak kami.</h2>
                        <div class="card card-body">
                            <form class="border-right mb-5 pr-5" method="post" id="contactForm" name="contactForm">
                                <div class="row mb-3">
                                    <div class="col-md-6 form-group mb-3">
                                        <input type="text" class="form-control" name="fname" id="fname" placeholder="Nama depan">
                                    </div>
                                    <div class="col-md-6 form-group">
                                        <input type="text" class="form-control" name="lname" id="lname" placeholder="Nama belakang">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 form-group">
                                        <input type="text" class="form-control" name="email" id="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-12 form-group">
                                        <textarea class="form-control" name="message" id="message" cols="30" rows="7" placeholder="Tulis pesan Anda"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-lg-2 mb-0">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-danger rounded-0 rounded px-4 py-2"><i class="mdi mdi-email"></i> Kirim pesan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 mx-lg-2 mx-0">
                        <h3 class="mb-4">Ada pertanyaan?</h3>
                        <p>Kontak kami apabila Anda mempunyai pertanyaan, admin kami akan merespon sesegera mungkin.</p>
                        <p><a href="#" class="text-secondary"><i class="mdi mdi-information-outline"></i> Syarat dan ketentuan</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of .container-->
    <!-- <section> close ============================-->
    <!-- ============================================-->
@endsection
