@extends('web::layouts.default')

@section('title', env('APP_NAME'))

@section('content')
    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-0" style="margin-top:-5.8rem">
        <div class="container">
            <div class="row">
                <div class="card card-span bg-secondary">
                    <div class="card-body">
                        <div class="row flex-center gx-0">
                            <div class="col-lg-4 col-xl-2 text-xl-start text-center"><img src="{{ asset('/img/gallery/funfacts.png') }}" width="170" alt="..." /></div>
                            <div class="col-lg-8 col-xl-4">
                                <h1 class="text-light fs-lg-4 fs-xl-5">Kegiatan baru akan diadakan...</h1>
                            </div>
                            <div class="col-lg-12 col-xl-6">
                                <h1 class="display-2 text-light text-xl-end text-center">11 : 02 : 45 : 21</h1>
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
    <section>
        <div class="container">
            <div class="row">
                <h1 class="mb-5 text-center"> Artikel Tapaksuci</h1>
                @forelse($latest_posts as $key => $post)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="backgroundEffect"></div>
                            <img class="card-img-top w-100" src="{{ asset('/img/gallery/art-design.png') }}" alt="courses" />
                            <div class="card-body">
                                <h5 class="font-sans-serif fw-bold fs-md-0 fs-lg-1">{{ $post->title }}</h5>
                                <a class="text-muted fs--1 stretched-link text-decoration-none" href="#!">{{ Str::limit(strip_tags($post->content), 100) }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
        <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->




    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="pt-0">
        <div class="container">
            <div class="row h-100 align-items-center">
                <div class="col-md-12 col-lg-6 h-100">
                    <div class="card card-span h-100 text-white"><img class="w-100" src="{{ asset('/img/gallery/barri.jpg') }}" alt="..." />
                        <div class="card-body px-xl-5 px-md-3 pt-0">
                            <div class="d-flex flex-column align-items-center bg-200" style="margin-top:-2.4rem;">
                                <h5 class="mb-0 mt-3">Moh. Barrie Irsyad</h5>
                                <p class="text-muted">Pendiri KASEGU</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 h-100">
                    <h1 class="my-4">Tapak Suci<br /><span class="text-primary">Putera Muhammadiyah</span></h1>
                    <p>
                        Tapak Suci, adalah sebuah aliran, perguruan, dan organisasi pencak silat yang merupakan anggota Ikatan Pencak Silat Indonesia (IPSI). Tapak Suci termasuk dalam 10 perguruan historis IPSI, yaitu perguruan yang menunjang tumbuh dan berkembangnya IPSI sebagai organisasi. Tapak Suci berasas Islam, bersumber pada Al Qur'an dan As-Sunnah, berjiwa persaudaraan, berada di bawah naungan Persyarikatan Muhammadiyah sebagai organisasi otonom yang ke-11.
                    </p>
                    <div class="mt-6">
                        <h5 class="font-sans-serif fw-bold mb-3">Tapak Suci memiliki motto</h5>
                        <div class="card card-span bg-600">
                            <div class="card-body">
                                <div class="row flex-center gx-0">
                                    <div class="col-lg-4 col-xl-3 text-xl-start text-center"><img src="{{ asset('/img/logo/tapak-suci-png-5.png') }}" width="120" alt="courses" /></div>
                                    <div class="col-lg-8 col-xl-9">
                                        <h5 class="font-sans-serif fw-bold">Dengan Iman dan Akhlak saya menjadi kuat, tanpa Iman dan akhlak saya menjadi lemah</h5>
                                    </div>
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


    <section>
        <div class="bg-holder" style="background-image:url({{ asset('/img/gallery/funfacts-2-bg.png') }});background-position:center;background-size:cover;">
        </div>
        <!--/.bg-holder-->

        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/published.png') }}" height="100" alt="..." />
                    <h1 class="my-2">6000+</h1>
                    <p class="text-info fw-bold">ANGGOTA</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/instructors.png') }}" height="100" alt="..." />
                    <h1 class="my-2">3000+</h1>
                    <p class="text-info fw-bold">SISWA</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/learners.png') }}" height="100" alt="..." />
                    <h1 class="my-2">500+</h1>
                    <p class="text-info fw-bold">KEJUARAAN</p>
                </div>
                <div class="col-sm-6 col-lg-3 mb-5 text-center"><img src="{{ asset('/img/gallery/awards.png') }}" height="100" alt="..." />
                    <h1 class="my-2">80+</h1>
                    <p class="text-info fw-bold">JUARA</p>
                </div>
            </div>
        </div>
    </section>


    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 col-lg-4 mb-5"><img src="{{ asset('/img/gallery/subscribe.png') }}" width="280" alt="cta" /></div>
            <div class="col-md-6 col-lg-5">
                <h5 class="text-primary font-sans-serif fw-bold">Berlangganan sekarang</h5>
                <h3 class="mb-3">Dapatkan informasi terbaru<br />Tapak suci</h3>
                <form class="row g-0 align-items-center">
                    <div class="col">
                        <div class="input-group-icon">
                            <input class="form-control form-little-squirrel-control" type="email" placeholder="Masukan email " aria-label="email" /><i class="fas fa-envelope input-box-icon"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary rounded-0" type="submit">Berlangganan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- <section> close ============================-->
    <!-- ============================================-->

    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <div class="bg-light container-fluid p-4">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">
                <div class="row align-items-center">
                    <div class="col-lg-7 mb-lg-0 mb-5">
                        <h2 class="mb-5">Kontak kami.</h2>
                        <form class="border-right mb-5 pr-5" method="post" id="contactForm" name="contactForm">
                            <div class="row mb-3">
                                <div class="col-md-6 form-group">
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
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger rounded-0 rounded px-4 py-2"><i class="mdi mdi-email"></i> Kirim pesan</button>
                                    <span class="submitting"></span>
                                </div>
                            </div>
                        </form>
                        <div id="form-message-warning mt-4"></div>
                        <div id="form-message-success"></div>
                    </div>
                    <div class="col-lg-4 ml-auto">
                        <h3 class="mb-4">Ada pertanyaan?</h3>
                        <p>Kontak kami apabila Anda mempunyai pertanyaan, admin kami akan merespon sesegera mungkin.</p>
                        <p><a href="#">Syarat dan ketentuan</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of .container-->
    <!-- <section> close ============================-->
    <!-- ============================================-->
@endsection
