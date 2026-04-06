@extends('layouts.user')

@section('title', 'Vilo Story - VIMS')

@push('styles')
<style>
    .story-wrap{max-width:1100px;margin:0 auto}
    .title-section{text-align:center;margin:1.25rem 0 1.5rem}
    .title-section .serif-title{font-family:'Playfair Display',Georgia,serif;font-size:2rem;color:var(--vims-primary)}
    .subtitle-top{letter-spacing:.2em;text-transform:uppercase;font-size:.7rem;color:var(--vims-text-light)}
    .story-slide{display:grid;grid-template-columns:1.1fr 1fr;gap:2rem;align-items:center;margin:1.25rem 0}
    .slide-title{font-family:'Playfair Display',Georgia,serif;font-size:2rem;color:#111}
    .slide-title strong{font-weight:700}
    .slide-body{color:#333;line-height:1.8;max-width:560px}
    .slide-media{border:1px solid var(--vims-border);border-radius:10px;overflow:hidden}
    .slide-media img{display:block;width:100%;height:420px;object-fit:cover}
    .slide-nav{display:flex;gap:.5rem;margin-top:1rem}
    .slide-btn{width:42px;height:42px;border:1px solid #111;background:#fff;color:#111;border-radius:4px;display:inline-flex;align-items:center;justify-content:center;cursor:pointer}
    .slide-btn:hover{background:#111;color:#fff}
    .sr{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0)}
    .story-hero{display:grid;grid-template-columns:1.2fr 1fr;gap:1.5rem;align-items:start;margin-bottom:1.75rem}
    .story-hero .hero-img{border-radius:12px;overflow:hidden;border:1px solid var(--vims-border)}
    .story-hero .hero-img img{width:100%;height:100%;object-fit:cover;display:block}
    .story-hero .hero-text{max-width:520px;margin:0 auto}
    .story-hero .hero-text p{color:var(--vims-text);line-height:1.85;margin:.6rem 0}
    .story-wide{border-radius:12px;overflow:hidden;border:1px solid var(--vims-border);margin:1.25rem 0}
    .story-wide img{width:100%;height:420px;object-fit:cover;display:block}
    .story-two{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:start;margin:1.5rem 0}
    .story-two .text p{line-height:1.85;margin:.6rem 0}
    .story-two .img{border-radius:12px;overflow:hidden;border:1px solid var(--vims-border)}
    .story-two .img img{width:100%;height:380px;object-fit:cover;display:block}
    .story-stats{display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;align-items:center;margin:1.5rem 0}
    .stat-card{background:var(--vims-card);border:1px solid var(--vims-border);border-radius:12px;padding:1.5rem;box-shadow:var(--vims-shadow);text-align:center}
    .stat-number{font-family:'Playfair Display',Georgia,serif;font-size:2rem;color:var(--vims-primary)}
    .stat-label{color:var(--vims-text-light);font-size:.9rem}
    .story-stats .img{border-radius:12px;overflow:hidden;border:1px solid var(--vims-border)}
    .story-stats .img img{width:100%;height:320px;object-fit:cover;display:block}
    @media(max-width:900px){.story-hero{grid-template-columns:1fr}.story-two{grid-template-columns:1fr}.story-stats{grid-template-columns:1fr} .story-wide img{height:300px}}
</style>
@endpush

@section('content')

<div class="story-wrap">
    <div class="title-section">
        <p class="subtitle-top">Since 2017</p>
        <h1 class="serif-title">The (his)Story</h1>
        <p class="lead" style="max-width:640px;margin:0 auto;color:var(--vims-text-light)">Sejarah kehadiran serta filosofi di balik berdirinya Vilo Gelato.</p>
    </div>

    @php
        $img1 = file_exists(public_path('images/content/Vilo1.1.avif'))
            ? '/images/content/Vilo1.1.avif'
            : '/images/content/project-web-peraturan-umum-perusahaan-2026_image3.png';
        $img2 = file_exists(public_path('images/content/Vilo1.2.avif'))
            ? '/images/content/Vilo1.2.avif'
            : '/images/content/project-web-peraturan-umum-perusahaan-2026_image4.png';
        $img3 = file_exists(public_path('images/content/Vilo1.3.avif'))
            ? '/images/content/Vilo1.3.avif'
            : $img1;
        $img4 = file_exists(public_path('images/content/Vilo1.4.avif'))
            ? '/images/content/Vilo1.4.avif'
            : $img2;
    @endphp



    <div class="story-hero px-3">
        <div class="hero-img"><img src="{{ $img1 }}" alt="Vilo History"></div>
        <div class="hero-text">
            <p>Vilo Gelato lahir di akhir tahun 2017 dari sebuah percakapan sederhana namun manis antara tiga sahabat SMA. Di suatu sore yang santai, mereka bertanya pada diri sendiri: <strong>Mengapa es krim yang enak selalu harus terlalu manis, terlalu mahal, dan hampir selalu produk impor?</strong></p>
            <p>Didorong oleh rasa penasaran, mereka menghabiskan liburan panjang di tahun itu dengan menyelami dunia pembuatan es krim. Bermodal resep YouTube dan semangat mencoba hal baru, mereka mulai bereksperimen di dapur sendiri.</p>
            <p>Hasilnya? <span style="color:var(--vims-text-light);font-style:italic">Belum layak untuk disajikan.</span></p>
        </div>
    </div>

    <div class="story-two px-3">
        <div class="text">
            <p>Setelah menguji ratusan resep dan melewati berbagai blind taste test, mereka akhirnya mulai menemukan formula gelato yang sempurna.</p>
            <p>Mereka segera menyadari bahwa teknik terbaik tidak akan berarti tanpa bahan baku terbaik. Petualangan baru dimulai—mencari bahan-bahan paling segar dan berkualitas dari dalam negeri.</p>
            <p>Di Vilo, itu berarti <strong>tanpa perisa buatan, tanpa pewarna, dan tanpa pengawet</strong>. Hanya bahan asli dan rasa yang jujur.</p>
            <p>Gelato dibuat dalam batch kecil setiap hari agar selalu segar.</p>
        </div>
        <div class="img"><img src="{{ $img3 }}" alt="Workshop"></div>
    </div>

</div>

    <div class="px-3" id="vilo-story-carousel" aria-roledescription="carousel">
        <div class="story-slide" data-index="0">
            <div>
                <h2 class="slide-title">Lebih dari <strong>300</strong> Rasa</h2>
                <p class="slide-body">
                    Karena kami belajar membuat gelato dari nol, kami jadi memahami seni (dan juga ilmu!) dalam menyeimbangkan setiap bahan dengan tepat.
                    Dasar inilah yang memberi kami kebebasan untuk menciptakan hampir semua rasa yang bisa dibayangkan. Sejak tahun 2017, kami telah menciptakan lebih dari 300 varian rasa gelato—dan jumlahnya terus bertambah!
                </p>
                <div class="slide-nav">
                    <button type="button" class="slide-btn" data-prev aria-label="Previous slide"><span class="sr">Previous</span>‹</button>
                    <button type="button" class="slide-btn" data-next aria-label="Next slide"><span class="sr">Next</span>›</button>
                </div>
            </div>
            <div class="slide-media"><img src="{{ $img1 }}" alt="Vilo flavours"></div>
        </div>
        <div class="story-slide" data-index="1" style="display:none">
            <div>
                <h2 class="slide-title"><strong>37</strong> Outlets</h2>
                <p class="slide-body">
                    Kami dengan bangga memiliki, mengelola, dan menjalankan 37 gerai yang tersebar di seluruh kepulauan Indonesia, menjadikan kami sebagai jaringan gelato lokal terbesar di tanah air.
                    Dari sudut kota hingga destinasi pulau, selalu ada secangkir Vilo yang tidak pernah terlalu jauh dari Anda!
                </p>
                <div class="slide-nav">
                    <button type="button" class="slide-btn" data-prev aria-label="Previous slide"><span class="sr">Previous</span>‹</button>
                    <button type="button" class="slide-btn" data-next aria-label="Next slide"><span class="sr">Next</span>›</button>
                </div>
            </div>
            <div class="slide-media"><img src="{{ $img2 }}" alt="Vilo outlets"></div>
        </div>
    </div>

@endsection
@push('scripts')
<script>
    (function(){
        const container = document.getElementById('vilo-story-carousel');
        if (!container) return;
        const slides = Array.from(container.querySelectorAll('.story-slide'));
        let idx = 0;
        function render() {
            slides.forEach((s,i)=> s.style.display = i===idx ? '' : 'none');
        }
        container.addEventListener('click', function(e){
            const btn = e.target.closest('.slide-btn');
            if (!btn) return;
            if (btn.hasAttribute('data-prev')) {
                idx = (idx - 1 + slides.length) % slides.length;
                render();
            } else if (btn.hasAttribute('data-next')) {
                idx = (idx + 1) % slides.length;
                render();
            }
        });
        render();
    })();
</script>
@endpush
