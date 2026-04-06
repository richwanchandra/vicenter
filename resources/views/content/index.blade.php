@extends('layouts.app')

@section('title', 'Vilo Office Internal - Home')

@section('content')
    {{-- Hero Section --}}
    <header class="hero-section">
        <div class="container animate__animated animate__fadeInUp">
            <div class="hero-banner__img position-relative" style="background-image: url('{{ asset('assets/img/Vilo1.avif') }}')"></div>

            <h1 class="display-2 mb-4">Vilo Gelato </h1>
            <p class="lead mb-5">Segala sesuatu yang kami lakukan harus memberikan nilai bagi pelanggan dan masyarakat.</p>
            <a href="#about" class="btn btn-outline-light btn-lg px-5 rounded-pill">Explore Our Values</a>
        </div>
    </header>

    {{-- About / Values Section --}}
    <section id="about" class="article-slide bg-white overflow-hidden">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="article-text-slider">
                        <div>
                            <h6 class="text-primary fw-bold text-uppercase">Value 01</h6>
                            <h2 class="mb-4">Value (Nilai)</h2>
                            <p class="text-muted">Memberikan nilai bagi pelanggan, karyawan, keluarga, pemangku kepentingan, dan masyarakat.</p>
                        </div>
                        <div>
                            <h6 class="text-primary fw-bold text-uppercase">Value 02</h6>
                            <h2 class="mb-4">Improvement</h2>
                            <p class="text-muted">Terus berkembang melalui riset, eksperimen, serta pengembangan didorong teknologi.</p>
                        </div>
                        <div>
                            <h6 class="text-primary fw-bold text-uppercase">Value 03</h6>
                            <h2 class="mb-4">Lean and Agile</h2>
                            <p class="text-muted">Tim kecil berperforma tinggi dengan budaya belajar dari kesalahan.</p>
                        </div>
                        <div>
                            <h6 class="text-primary fw-bold text-uppercase">Value 04</h6>
                            <h2 class="mb-4">Openness</h2>
                            <p class="text-muted">Keterbukaan untuk menciptakan keterikatan emosional terhadap organisasi.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="article-image-slider">
                        <div> <img src="{{ asset('assets/img/Vilo1.avif') }}" alt="Vilo 1" class="img-fluid rounded-4 shadow"></div>
                        <div> <img src="{{ asset('assets/img/Vilo1.2.avif') }}" alt="Vilo 2" class="img-fluid rounded-4 shadow"></div>
                        <div> <img src="{{ asset('assets/img/Vilo1.3.avif') }}" alt="Vilo 3" class="img-fluid rounded-4 shadow"></div>
                        <div> <img src="{{ asset('assets/img/Vilo1.4.avif') }}" alt="Vilo 4" class="img-fluid rounded-4 shadow"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="vilo-stats">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-md-3 col-6">
                    <div class="stat-number">37+</div>
                    <div class="stat-label">Cabang</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">300+</div>
                    <div class="stat-label">Varian Rasa</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">7+</div>
                    <div class="stat-label">Tahun Operasi</div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Alami</div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
    $(document).ready(function() {
        // Sinkronisasi Dual Slider (About Section)
        const $textSlider = $('.article-text-slider');
        const $imageSlider = $('.article-image-slider');

        $textSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.article-image-slider',
            autoplay: true,
            autoplaySpeed: 4000
        });

        $imageSlider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            asNavFor: '.article-text-slider',
            dots: true,
            fade: true,
            arrows: false,
            infinite: true
        });

        // Fix Refresh Bug
        $(window).on('load', function() {
            $textSlider.slick('setPosition');
            $imageSlider.slick('setPosition');
        });
    });
    </script>
@endpush