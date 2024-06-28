<section class="bg-white pt-6" id="home">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-5 col-lg-6 order-0 order-md-1 animatein image-container text-end">
                <div class="image-overlay"></div>
            </div>
            <div class="col-md-7 col-lg-6 text-md-start animateup animatein py-6 text-center">
                <h4 class="fw-bold font-sans-serif text-danger">Tapaksuci</h4>
                <h1 class="fs-6 fs-xl-6 text-dark mb-5" style="font-weight: 600">Melestarikan Seni Bela Diri Tradisional <span class="text-danger">Pencak Silat</span></h1>
                <a class="btn btn-danger rounded px-4 py-2" href="#!" role="button">Hubungi kami <i class="mdi mdi-arrow-right-circle-outline"></i></a>
                <a class="text-danger px-4 py-2" href="#!">Selengkapnya </a>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <style>
        .image-container {
            height: 470px;
            background-image: url('{{ asset('/img/gallery/red2.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
        }

        .image-overlay {
            top: 0;
            left: 0;
            height: 100%;
            background-image: url('{{ asset('/img/gallery/kick2.png') }}');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.7;
        }
    </style>
@endpush
