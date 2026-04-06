@extends('layouts.user')

@section('title', 'Home - VIMS')

@push('styles')
    <style>
        /* HERO */
        .hero-section {
            position: relative;
            height: calc(100vh - 60px);
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            background-color: var(--vims-primary);
            color: #ffffff;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 1;
            transform: scale(1.05);
            animation: heroKenBurns 20s ease-in-out forwards;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 100%);
            z-index: 2;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            max-width: 800px;
            padding: 2rem;
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 700ms ease, transform 700ms ease;
        }
        .hero-content.show {
            opacity: 1;
            transform: translateY(0);
        }

        .hero-section .display-2 {
            font-family: 'Playfair Display', Georgia, serif;
            font-size: 3.5rem;
            color: #ffffff;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero-section .lead {
            font-size: 1.25rem;
            color: rgba(255, 255, 255, 0.9);
            margin-top: .5rem;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
        }

        @keyframes heroKenBurns {
            0%   { transform: scale(1.05); }
            50%  { transform: scale(1.08); }
            100% { transform: scale(1.1); }
        }

        

        .btn {
            display: inline-block;
            margin-top: 1.5rem;
            padding: .75rem 2rem;
            border-radius: 999px;
            text-decoration: none;
            font-size: .95rem;
            font-weight: 500;
            transition: var(--vims-transition);
        }

        .btn--outline {
            border: 2px solid #ffffff;
            color: #ffffff;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(4px);
        }

        .btn--outline:hover {
            background: #ffffff;
            color: var(--vims-primary);
        }


        /* VALUE SLIDER */
        .article-slide {
            padding: 4rem 0;
            margin-bottom: 2rem;
        }

        .as-grid {
            display: grid;
            grid-template-columns: 1fr 1.25fr;
            gap: 3rem;
            align-items: center;
        }

        /* TEXT SLIDES */
        .text-slider {
            position: relative;
            padding-right: 2rem;
        }

        .text-slide {
            opacity: 0;
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 100%;
            transition: opacity .5s ease;
        }

        .text-slide.is-active {
            opacity: 1;
            position: relative;
            transform: translateY(0);
        }

        .badge {
            font-size: .85rem;
            font-weight: 700;
            color: #1a73e8;
            /* Blue color matching screenshot */
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
            display: block;
            padding: 0;
            background: transparent;
        }

        .text-slide h2 {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            font-size: 2.8rem;
            font-weight: 900;
            color: var(--vims-primary);
            margin-bottom: 1.2rem;
            line-height: 1.1;
        }

        .muted {
            color: var(--vims-text-light);
            font-size: 1.05rem;
            line-height: 1.6;
        }

        /* IMAGE SLIDES */
        .image-slider-wrapper {
            position: relative;
        }

        .image-slider {
            position: relative;
            aspect-ratio: 16/10;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .image-slide {
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transition: opacity .5s ease;
        }

        .image-slide.is-active {
            opacity: 1;
        }

        .image-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* SLIDER DOTS */
        .slider-dots {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 1rem;
        }

        .slider-dots .dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #cbd5e1;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .slider-dots .dot.active {
            background: #475569;
        }

        /* STATS */

        .vilo-stats {
            padding: 2rem 0 4rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .stat {
            text-align: center;
            padding: 1rem;
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }

        .stat.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .stat-number {
            font-size: 4rem;
            font-weight: 700;
            color: var(--vims-gold);
            margin-bottom: 0.5rem;
            font-family: 'Avenir', 'Montserrat';
            line-height: 1;
        }

        .stat-label {
            font-size: .85rem;
            color: var(--vims-text-light);
        }


        /* MOBILE */

        @media(max-width:768px) {

            .as-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }
    </style>
@endpush


@section('hero')
    <!-- HERO -->
    <header class="hero-section">
        <!-- Background image from the original upload -->
        <img src="/images/content/Vilo1.avif" alt="Vilo Gelato Background" class="hero-bg">
        <div class="hero-overlay"></div>

        <div class="hero-content">
            <h1 class="display-2">Vilo Gelato</h1>
            <a href="#about" class="btn btn--outline">
                Explore Our Internal
            </a>
        </div>
    </header>
@endsection

@section('content')

    <div class="vims-container">

        <!-- VALUES SLIDER -->

        <section id="about" class="article-slide">

            <div class="as-grid">

                <!-- TEXT -->

                <div class="text-slider" data-text-slider>

                    <div class="text-slide is-active">

                    
                        <h6 class="badge">Value 01</h6>
                        <h2>Value</h2>
                        <p class="muted">
Segala sesuatu yang kami lakukan harus memberikan nilai bagi pelanggan, karyawan, keluarga, pemangku kepentingan, dan masyarakat.
                        </p>
                    </div>


                    <div class="text-slide">
                        <h6 class="badge">Value 02</h6>
                        <h2>Improvement</h2>
                        <p class="muted">
                            Kami berupaya untuk menjadi yang terbaik dalam apa yang kami lakukan
                            dengan terus mengembangkan diri melalui riset, eksperimen, serta pengembangan yang didorong
                            oleh teknologi.
                        </p>
                    </div>

                    <div class="text-slide">
                        <h6 class="badge">Value 03</h6>
                        <h2>Lean and Agile</h2>
                        <p class="muted">
                            Tim yang kecil namun berperforma tinggi, dengan budaya kerja yang
                            mendorong setiap anggota untuk berkembang dengan memberikan ruang untuk mencoba, melakukan
                            kesalahan, dan belajar darinya
                        </p>
                    </div>

                    <div class="text-slide">
                        <h6 class="badge">Value 04</h6>
                        <h2>Openness</h2>
                        <p class="muted">
                            Kami percaya bahwa keterbukaan itu penting karena sejalan dengan apa
                            yang diinginkan dan diharapkan orang—agar mereka dapat merasakan rasa memiliki serta
                            keterikatan emosional terhadap sebuah organisasi.
                        </p>
                    </div>

                </div>


                <!-- IMAGE -->
                <div class="image-slider-wrapper">
                    <div class="image-slider" data-image-slider>

                        <div class="image-slide is-active">
                            <img src="/images/content/Vilo1.1.avif">
                        </div>

                        <div class="image-slide">
                            <img src="/images/content/Vilo1.2.avif">
                        </div>

                        <div class="image-slide">
                            <img src="/images/content/Vilo1.3.avif">
                        </div>

                        <div class="image-slide">
                            <img src="/images/content/Vilo1.4.avif">
                        </div>

                    </div>

                    <!-- DOTS -->
                    <div class="slider-dots">
                        <span class="dot active"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>
                        <span class="dot"></span>

                    </div>
                </div>

            </div>

        </section>


        <!-- STATS -->

        <section class="vilo-stats">

            <div class="stats-grid">

                <div class="stat">
                    <div class="stat-number"><span class="counter" data-target="37">0</span>+</div>
                    <div class="stat-label">Cabang</div>
                </div>

                <div class="stat">
                    <div class="stat-number"><span class="counter" data-target="300">0</span>+</div>
                    <div class="stat-label">Varian Rasa</div>
                </div>

                <div class="stat">
                    <div class="stat-number"><span class="counter" data-target="7">0</span>+</div>
                    <div class="stat-label">Tahun Operasi</div>
                </div>

                <div class="stat">
                    <div class="stat-number"><span class="counter" data-target="100">0</span>%</div>
                    <div class="stat-label">Alami</div>
                </div>

            </div>

        </section>

    </div>

@endsection



@push('scripts')
    <script>

        document.addEventListener("DOMContentLoaded", function () {
            const heroContent = document.querySelector(".hero-content");
            if (heroContent) {
                requestAnimationFrame(() => heroContent.classList.add("show"));
            }

            const textSlides = document.querySelectorAll(".text-slide");
            const imageSlides = document.querySelectorAll(".image-slide");
            const dots = document.querySelectorAll(".slider-dots .dot");

            let current = 0;
            const total = textSlides.length;
            let slideInterval;

            function goToSlide(index) {
                textSlides[current].classList.remove("is-active");
                imageSlides[current].classList.remove("is-active");
                if (dots.length > 0) dots[current].classList.remove("active");

                current = index;

                textSlides[current].classList.add("is-active");
                imageSlides[current].classList.add("is-active");
                if (dots.length > 0) dots[current].classList.add("active");
            }

            function nextSlide() {
                goToSlide((current + 1) % total);
            }

            slideInterval = setInterval(nextSlide, 4500);

            // Add click events to dots
            dots.forEach((dot, index) => {
                dot.addEventListener("click", () => {
                    clearInterval(slideInterval);
                    goToSlide(index);
                    slideInterval = setInterval(nextSlide, 4500);
                });
            });

            // Stats Animation Observer with Number Counter
            const stats = document.querySelectorAll(".stat");

            function animateValue(obj, start, end, duration) {
                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    // easeOutQuart easing for smooth deceleration
                    const easeProgress = 1 - Math.pow(1 - progress, 4);
                    obj.innerHTML = Math.floor(easeProgress * (end - start) + start);
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);
            }

            const statObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        const target = entry.target;

                        // Stagger the fade-in animation
                        const delay = Array.from(stats).indexOf(target) * 150;
                        setTimeout(() => {
                            target.classList.add("is-visible");

                            // Trigger number counter
                            const counterElement = target.querySelector('.counter');
                            if (counterElement) {
                                const targetValue = parseInt(counterElement.getAttribute('data-target'));
                                animateValue(counterElement, 0, targetValue, 2000); // 2 second animation
                            }
                        }, delay);

                        observer.unobserve(target); // Only animate once
                    }
                });
            }, {
                threshold: 0.2 // Trigger when 20% visible
            });

            stats.forEach(stat => {
                statObserver.observe(stat);
            });

        });

    </script>
@endpush
