@extends('layouts.user')

@section('title', 'Contact Us')

@section('content')
    <div class="vims-content-card">
        <h1>Hubungi Kami</h1>
        <p class="vims-prose" style="max-width: 640px;">
            Email:cs@vilogelato.com
        </p>
    </div>

    <div class="vims-content-card" style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <div>
            <h3>Lokasi Kami</h3>
            <h4 style="margin-top:0.5rem;color:var(--vims-text-light)">Alamat</h4>
            <address style="margin-bottom:0.75rem">
                Vilo Gelato Office<br>
                Jl. Wijaya X No.11, Melawai, Kec. Kby. Baru,<br>
                Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12160
            </address>
            <h4 style="margin-top:0.5rem;color:var(--vims-text-light)">Jam Buka</h4>
            <p>Senin sampai Jumat: 9am – 5pm</p>
            <a class="vims-link" target="_blank" href="https://maps.app.goo.gl/a8hdJKJ8qfMPDkVi7">Get Directions</a>
        </div>
        <div>
            <div style="border:1px solid var(--vims-border);border-radius:var(--vims-radius);overflow:hidden;">
                <iframe src="https://www.google.com/maps?q=Vilo%20Gelato%20HQ&output=embed" width="100%" height="320"
                    style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection