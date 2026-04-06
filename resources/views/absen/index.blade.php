@extends('layouts.app')

@section('title', 'Vilo Office Internal - Home')

@section('content')

<main class="content mt-5 pt-4">
    <header class="hero-section py-5 bg-white border-bottom">
        <div class="container text-center animate__animated animate__fadeIn">
            <p class="text-uppercase fw-bold text-primary small mb-1 tracking-widest">Human Resource Development</p>
            <h1 class="display-3 fw-bold mb-3" style="font-family: var(--vilo-font);">Prosedur Absen</h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">Panduan dan prosedur pencatatan kehadiran karyawan Vilo Gelato.</p>
        </div>
    </header>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeInUp">
                <div class="card-body p-4 p-lg-5 bg-white">


                    <h2 class="fw-bold text-dark mb-4"><i class="bi bi-journal-text me-2 text-primary"></i>Ketentuan Umum</h2>
                    <ol class="ketentuan-main-list fs-6 text-secondary mb-5">
                        <li class="mb-3">Karyawan wajib mematuhi jam kerja yang telah ditetapkan sesuai masing-masing divisi dengan waktu istirahat maksimal selama 1 jam.</li>
                        <li class="mb-3">Kehadiran dicatat melalui sistem <strong>Human Resource Information System (HRIS)</strong> yang digunakan untuk mengumpulkan, menyimpan, mengelola data serta proses terkait Sumber Daya Manusia (SDM) dalam suatu perusahaan.</li>
                        <li class="mb-3">Selama jam kerja, karyawan tidak diperbolehkan meninggalkan area kantor tanpa izin dari Atasan Langsung.</li>
                        <li class="mb-3">Selama jam kerja, karyawan tidak diperbolehkan untuk dikunjungi oleh keluarga atau kerabat agar dapat meningkatkan fokus dan produktivitas kerja serta menjaga keamanan dan ketertiban di lingkungan kantor.</li>
                    </ol>

                    <div class="ketentuan-highlight p-4 rounded-4 shadow-sm border-start border-4 border-warning bg-light">
                        <h3 class="highlight-title h5 fw-bold text-dark mb-3">Hal yang Perlu Diperhatikan :</h3>
                        <ul class="highlight-list list-unstyled mb-0 small">
                            <li class="d-flex mb-2">
                                <span class="fw-bold text-primary me-2">a.</span> 
                                <span>Pastikan untuk selalu mengecek riwayat kehadiran pada sistem HRIS sebelum meninggalkan area kerja.</span>
                            </li>
                            <li class="d-flex mb-2">
                                <span class="fw-bold text-primary me-2">b.</span> 
                                <span>Pastikan seluruh pengajuan seperti change shift maupun overtime diajukan maksimal <strong>H+1</strong> melalui sistem HRIS agar tidak ada pengajuan yang terlewat dan dapat diakumulasi di saat proses penggajian.</span>
                            </li>
                            <li class="d-flex">
                                <span class="fw-bold text-primary me-2">c.</span> 
                                <span>Komunikasi ke Atasan jika terjadi kejadian di luar kendali seperti bencana alam, kecelakaan lalu lintas, kondisi medis tertentu, kebijakan pemerintah (force majeure), yang menyebabkan keterlambatan, gaji tidak akan dipotong dengan syarat Karyawan wajib mengirimkan bukti foto menggunakan <strong>Aplikasi Timestamp</strong> dan upload foto melalui aplikasi HRIS (Talenta).</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

   <section class="py-5 bg-light">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeInUp mb-5">
            <div class="card-body p-4 p-lg-5">
                <h2 class="fw-bold text-dark mb-5 text-center">
                    <i class="bi bi-cpu me-2 text-primary"></i>Fungsi Fitur Sistem HRIS
                </h2>
                
                <div class="row g-4 justify-content-center mb-5">
                    <div class="col-md-8 col-lg-5 text-center">
                        <div class="hris-image-wrapper p-3 bg-light rounded-4 shadow-sm border">
                            <img src="{{ asset('img/Absen1.png') }}" alt="HRIS Interface 1" class="img-fluid rounded-3">
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center text-start">
                    <div class="col-lg-10">
                        <ol class="ketentuan-main-list fs-6 text-secondary">
                            <li class="mb-3 text-dark">Wajib absen masuk menggunakan fitur <strong>Clock in</strong> di lokasi penempatan kerja yang sah.</li>
                            <li class="mb-3 text-dark">Wajib absen keluar menggunakan fitur <strong>Clock out</strong> di lokasi penempatan kerja yang sah.</li>
                            <li class="mb-3 text-dark">Fitur <strong>Attendance Log</strong> untuk melihat riwayat kehadiran per hari dan per bulan.</li>
                            <li class="mb-3 text-dark">Fitur <strong>Calendar</strong> untuk melihat karyawan yang sedang ulang tahun maupun cuti.</li>
                            <li class="mb-3 text-dark">Fitur <strong>Time Off</strong> untuk pengajuan cuti, izin, dan sakit.</li>
                            <li class="mb-3 text-dark">Fitur <strong>Live Attendance</strong> fungsinya sama dengan fitur clock in dan clock out.</li>
                            <li class="mb-3 text-dark">Fitur <strong>Overtime (Lembur)</strong>:
                                <ul class="sub-list mt-2 small text-muted">
                                    <li>Lembur <strong>Overtime after shift</strong> untuk lembur setelah shift berakhir.</li>
                                    <li>Lembur <strong>Overtime before shift</strong> untuk lembur sebelum shift dimulai.</li>
                                    <li>Lembur wajib diajukan maksimal <strong>H-1</strong> dan disetujui Atasan Langsung.</li>
                                    <li>Atasan berhak menolak pengajuan jika perintah tidak ada atau alasan tidak jelas.</li>
                                </ul>
                            </li>
                            <li class="text-dark">Fitur <strong>Request</strong> untuk pengajuan time off, change shift, lembur, maupun perubahan data personal (rekening, foto profil, status PTKP, dll).</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden animate__animated animate__fadeInUp">
            <div class="card-body p-4 p-lg-5">
                <h2 class="fw-bold text-dark mb-4 text-center">Panduan Cek Riwayat Kehadiran</h2>
                <div class="row align-items-center g-4">
                    <div class="col-md-5 text-center">
                        <div class="hris-image-wrapper p-2 bg-light rounded-4 border d-inline-block shadow-sm">
                            <img src="{{ asset('img/absen2.png') }}" alt="HRIS Interface 2" class="img-fluid rounded-3" style="max-width: 300px;">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <ol class="ketentuan-main-list fs-6 text-secondary">
                            <li class="mb-3 text-dark">Klik fitur <strong>Attendance Log</strong> pada dashboard aplikasi.</li>
                            <li class="text-dark">Apabila pada riwayat tersebut terdapat absen yang tidak terisi (kosong), segera ajukan <strong>Request Attendance</strong> agar data tervalidasi.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="card border-0 shadow-sm rounded-4 p-4 p-lg-5 bg-white">
                <h2 class="fw-bold text-dark text-center mb-5">Ketentuan Berdasarkan Level Karyawan</h2>
                
                <div class="accordion accordion-vilo" id="accordionLevel">
                    
                    <div class="accordion-item mb-3 border rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartTimer">
                                <i class="bi bi-person-circle me-3 text-primary"></i> Part-timer, Magang, Freelance
                            </button>
                        </h2>
                        <div id="collapsePartTimer" class="accordion-collapse collapse" data-bs-parent="#accordionLevel">
                            <div class="accordion-body p-4 small">
                                <ol class="ps-3 mb-4 text-secondary">
                                    <li>Sistem kerja & absensi bersifat fleksibel namun terikat pada Shifting yang ditentukan oleh Atasan Langsung. Karyawan tidak diperbolehkan mengatur jam kerja sendiri tanpa persetujuan.</li>
                                    <li>Pastikan saat melakukan absen penampilan sesuai standar perusahaan yang telah ditetapkan.</li>
                                    <li>Jika tidak hadir sebanyak 3 kali dari jadwal yang diberikan maka akan dianggap <strong>MENGUNDURKAN DIRI</strong>.</li>
                                    <li>Perhitungan upah harian berdasarkan absen harian yang tercatat pada sistem HRIS.</li>
                                </ol>
                                <div class="sanksi-box p-3 rounded-4 bg-danger bg-opacity-10 border border-danger border-opacity-25 mb-3 shadow-sm">
                                    <h4 class="h6 fw-bold text-danger mb-3">5. Struktur Sanksi Keterlambatan:</h4>
                                    <ul class="list-unstyled text-danger mb-0">
                                        <li>• Terlambat 1-15 menit: Rp 10.000</li>
                                        <li>• Terlambat 16-30 menit: Rp 20.000</li>
                                        <li>• Terlambat >30 menit: Rp 40.000</li>
                                        <li>• Tidak absen masuk/pulang: Rp 40.000</li>
                                        <li>• Keterlambatan >30 menit selama 3 kali dalam sebulan mendapatkan <strong>SP 1</strong>.</li>
                                        <li>• Penampilan tidak sesuai standar: pemotongan upah Rp 5.000.</li>
                                    </ul>
                                </div>
                                <div class="penting-box p-3 rounded-4 bg-primary bg-opacity-10 border border-primary border-opacity-25 shadow-sm text-primary">
                                    <h4 class="h6 fw-bold mb-2">6. Pentingnya Update Shift pada Sistem HRIS:</h4>
                                    <ul class="mb-0">
                                        <li>Menghindari potongan absen otomatis oleh sistem.</li>
                                        <li>Menghindari lembur yang tidak diakumulasi.</li>
                                        <li>Menjamin perhitungan upah harian akurat.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseStaff">
                                <i class="bi bi-person-vcard me-3 text-primary"></i> Staff Level
                            </button>
                        </h2>
                        <div id="collapseStaff" class="accordion-collapse collapse" data-bs-parent="#accordionLevel">
                            <div class="accordion-body p-4 small text-secondary">
                                <div class="bg-light p-3 rounded-4 mb-3">
                                    <h4 class="h6 fw-bold text-dark">1. Hari dan Jam Kerja yang Berlaku:</h4>
                                    <ul class="mb-0">
                                        <li>Project, GA, R&D, IT, Purchasing, Marketing, L&D: Sen-Jum 09:00-17:00 & Sab 09:00-15:00</li>
                                        <li>FAT, Legal, HRD: Sen-Jum 09:00-18:00</li>
                                        <li>PPIC: Sen-Min 09:00-17:00 (Libur 1 hari/minggu)</li>
                                        <li>Operations (Store): Sen-Min, shift sesuai kebutuhan</li>
                                    </ul>
                                </div>
                                <ol start="2" class="ps-3">
                                    <li>Karyawan off Sabtu (Kantor Pusat) wajib info User setiap tanggal 24, atau dianggap hangus.</li>
                                    <li>Tidak berlaku sistem jam kerja mundur. Terlambat tercatat jika presensi pkl 09.01 ke atas.</li>
                                    <li>Tidak berlaku perubahan shift bagi jadwal tetap.</li>
                                    <li>Lupa absen & izin terlambat maksimal 1 kali dalam sebulan.</li>
                                </ol>
                                <div class="p-3 border border-danger border-opacity-25 rounded-4 mt-3 bg-danger bg-opacity-10 text-danger">
                                    <h4 class="h6 fw-bold">8. Struktur Sanksi Keterlambatan:</h4>
                                    <p class="mb-0">1-15m: Rp10k | 16-30m: Rp20k | >30m: Rp40k | Tidak Absen: Rp40k | 3x terlambat >30m: SP 1.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item mb-3 border rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSupervisor">
                                <i class="bi bi-person-gear me-3 text-primary"></i> Supervisor Level
                            </button>
                        </h2>
                        <div id="collapseSupervisor" class="accordion-collapse collapse" data-bs-parent="#accordionLevel">
                            <div class="accordion-body p-4 small text-secondary">
                                <div class="bg-light p-3 rounded-4 mb-3"><strong>Jam Kerja:</strong> Senin - Jumat 09.00 - 18.00 WIB.</div>
                                <ol start="2" class="ps-3">
                                    <li>Presensi pukul 09.01 tercatat terlambat. Tidak berlaku jam kerja mundur.</li>
                                    <li>Tidak berlaku perubahan shift bagi staff non-shifting.</li>
                                </ol>
                                <div class="alert alert-danger rounded-4 py-2 px-3 small">Sanksi Keterlambatan: 1-15m: Rp10k | 16-30m: Rp20k | >30m: Rp40k | 3x terlambat >30m: SP 1.</div>
                                
                                <p class="fw-bold text-dark mt-3">Tanggung Jawab Approval:</p>
                                <ul class="ps-3">
                                    <li>Melakukan persetujuan/penolakan lembur, kehadiran, & data di HRIS.</li>
                                    <li><strong>BATAS APPROVAL:</strong> Maksimal pukul 12.00 WIB tanggal 23 setiap bulannya.</li>
                                    <li>Cuti tahunan < 14 hari dapat ditolak supervisor.</li>
                                    <li>Berhak menolak pengajuan tanpa bukti foto valid.</li>
                                </ul>

                                <div class="p-3 bg-light rounded-4 border">
                                    <p class="fw-bold text-primary mb-2">Tutorial Shifting Tim:</p>
                                    <div class="row g-2 text-center">
                                        <div class="col-4"><img src="{{ asset('img/Absen4.png') }}" class="img-fluid border rounded"></div>
                                        <div class="col-4"><img src="{{ asset('img/Absen5.png') }}" class="img-fluid border rounded"></div>
                                        <div class="col-4"><img src="{{ asset('img/Absen6.png') }}" class="img-fluid border rounded"></div>
                                    </div>
                                    <p class="xsmall mt-2 mb-0 italic">*Export data → Update Shifting di Excel → Import kembali ke HRIS.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border rounded-4 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-bold py-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseManager">
                                <i class="bi bi-person-badge me-3 text-primary"></i> Manager Level
                            </button>
                        </h2>
                        <div id="collapseManager" class="accordion-collapse collapse" data-bs-parent="#accordionLevel">
                            <div class="accordion-body p-4 small text-secondary">
                                <p><strong>Jam Kerja:</strong> Senin - Jumat 09.00 - 18.00 WIB (Bersedia hadir hari Sabtu/Minggu jika dibutuhkan).</p>
                                <div class="alert alert-danger rounded-4 py-2 px-3 small mb-3">Sanksi: 1-15m: Rp10k | 16-30m: Rp20k | >30m: Rp40k | 3x terlambat >30m: SP 1.</div>
                                
                                <p class="fw-bold text-dark">Tanggung Jawab Manager:</p>
                                <ul class="ps-3">
                                    <li><strong>BATAS APPROVAL:</strong> Maksimal pukul 09.00 WIB tanggal 23 setiap bulannya.</li>
                                    <li>Approval Request Overtime, Day Off, dan Change Shift anggota tim.</li>
                                    <li>Dapat melihat riwayat kehadiran anggota tim melalui PC (Menu Time > Attendance).</li>
                                </ul>

                                <div class="row g-2 text-center bg-light p-3 rounded-4">
                                    <div class="col-6"><img src="{{ asset('img/Absen17.png') }}" class="img-fluid border rounded"></div>
                                    <div class="col-6"><img src="{{ asset('img/Absen18.png') }}" class="img-fluid border rounded"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white mb-5 shadow-sm">
        <div class="container">
            <h2 class="fw-bold text-dark text-center mb-5">FAQ (Frequently Asked Questions)</h2>
            <div class="accordion accordion-flush" id="accordionFAQ">
                <div class="accordion-item mb-3 border rounded-4 overflow-hidden shadow-sm">
                    <h2 class="accordion-header"><button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">Apa yang harus dilakukan jika tidak sengaja Clock out di fitur Clock in?</button></h2>
                    <div id="faq1" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted small">Situasi 1: Jika sudah clock in, jam tidak otomatis terganti. Situasi 2: Jika tidak clock in, ajukan <strong>Request Attendance</strong> dan tetap lakukan live attendance Clock out.</div>
                    </div>
                </div>
                <div class="accordion-item mb-3 border rounded-4 overflow-hidden shadow-sm">
                    <h2 class="accordion-header"><button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">Kapan pengajuan via Talenta di approve?</button></h2>
                    <div id="faq2" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted small"><strong>Alur approval:</strong> Atasan Langsung (Max tgl 24 jam 09.00) dan HRD (Max tgl 24 jam 12.00).</div>
                    </div>
                </div>
                <div class="accordion-item border rounded-4 shadow-sm overflow-hidden">
                    <h2 class="accordion-header"><button class="accordion-button collapsed py-3" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">Mengapa perhitungan lembur berbeda dengan rekap manual?</button></h2>
                    <div id="faq3" class="accordion-collapse collapse">
                        <div class="accordion-body text-muted small">Faktor utama: Tidak clock out, shift belum di-update, atau terlambat clock in (waktu kerja mundur).</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@endsection
