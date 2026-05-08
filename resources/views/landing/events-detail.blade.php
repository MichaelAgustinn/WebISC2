@extends('landing.master')

@section('title', 'Event - ' . $event->name)

@push('styles')
    <style>
        .event-header {
            padding: 160px 5% 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            color: var(--white);
            text-align: left;
        }

        .event-breadcrumb {
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .event-breadcrumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .event-header h1 {
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--white);
        }

        .event-tag-line {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            max-width: 700px;
        }

        .event-container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 0;
        }

        .event-wrapper {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .featured-event-img {
            width: 100%;
            height: auto;
            max-height: 350px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 32, 75, 0.15);
            margin-bottom: 3rem;
            border: 1px solid #eee;
        }

        .event-body h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }

        .event-body h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--accent);
        }

        .event-body p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
            line-height: 1.8;
            white-space: pre-line;
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            -webkit-hyphens: auto;
        }

        /* --- SIDEBAR INFO --- */
        .event-info-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 15px;
            border: 1px solid #eee;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 100px;
        }

        .info-group {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-group:last-child {
            border-bottom: none;
            padding-bottom: 0;
            margin-bottom: 0;
        }

        .info-label {
            font-size: 0.85rem;
            color: var(--text-light);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
            display: block;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.1rem;
            color: var(--primary);
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }

        /* --- BUTTONS --- */
        .event-actions {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-action {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 12px;
            border-radius: 8px;
            font-weight: 700;
            transition: all 0.3s ease;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            width: 100%;
        }

        .btn-register {
            background: var(--primary, #4f46e5);
            color: white;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }

        .btn-register:hover {
            background: var(--accent);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
            transform: translateY(-2px);
        }

        .btn-whatsapp {
            background: #25D366;
            color: white;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .btn-whatsapp:hover {
            background: #20bd5a;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
            transform: translateY(-2px);
        }

        .btn-disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            border: 1px solid #e2e8f0;
        }

        .btn-share {
            background: transparent;
            color: var(--primary);
            border: 2px solid #eee;
        }

        .btn-share:hover {
            border-color: var(--primary);
            background: #f8fafc;
            transform: translateY(-2px);
        }

        .btn-share.copied {
            background: #10b981 !important;
            color: white !important;
            border-color: #10b981 !important;
        }

        /* Toast Notifikasi */
        .custom-toast {
            position: fixed;
            bottom: -100px;
            left: 50%;
            transform: translateX(-50%);
            background: #10b981;
            color: white;
            padding: 12px 24px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: bottom 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 9999;
        }

        .custom-toast.show {
            bottom: 40px;
        }

        /* Responsif */
        @media (max-width: 1024px) {
            .event-wrapper {
                grid-template-columns: 1fr;
            }

            .event-info-card {
                position: static;
                margin-bottom: 3rem;
                order: -1;
            }

            .event-header {
                padding: 120px 5% 60px;
            }

            .event-header h1 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .event-header {
                padding: 100px 5% 40px;
            }

            .event-header h1 {
                font-size: 1.8rem;
            }
        }
    </style>
@endpush

@section('content')
    <header class="event-header">
        <div class="event-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('events.public') }}">Event</a> <i class="ri-arrow-right-s-line"></i>
            <span>Detail</span>
        </div>
        <h1>{{ $event->name }}</h1>
        <p class="event-tag-line">
            Eksklusif untuk anggota Informatics Study Club. Daftarkan dirimu dan bergabunglah bersama kami!
        </p>
    </header>

    <section class="event-container">

        <!-- Notifikasi Berhasil -->
        @if (session('success'))
            <div
                style="background: #ecfdf5; color: #059669; padding: 15px; border-radius: 10px; margin-bottom: 30px; border: 1px solid #a7f3d0; display: flex; align-items: center; gap: 10px; font-weight: 500;">
                <i class="ri-checkbox-circle-fill" style="font-size: 1.5rem;"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="event-wrapper">

            <!-- BAGIAN KIRI: KONTEN UTAMA -->
            <div class="event-main">
                <img src="{{ asset($event->photo) }}" alt="{{ $event->name }}" class="featured-event-img">

                <div class="event-body">
                    <h2>Deskripsi Event</h2>
                    <p>{!! nl2br(e($event->deskripsi)) !!}</p>
                </div>
            </div>

            <!-- BAGIAN KANAN: SIDEBAR INFO & TOMBOL -->
            <aside class="event-sidebar">
                <div class="event-info-card">

                    <div class="info-group">
                        <span class="info-label">Tanggal Rilis</span>
                        <span class="info-value">{{ $event->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Status</span>
                        @if ($event->status)
                            <span class="info-value" style="color: #10b981; display:flex; align-items:center; gap:5px;">
                                <i class="ri-radio-button-line"></i> Dibuka
                            </span>
                        @else
                            <span class="info-value" style="color: #ef4444; display:flex; align-items:center; gap:5px;">
                                <i class="ri-close-circle-line"></i> Ditutup
                            </span>
                        @endif
                    </div>

                    <div class="info-group">
                        <span class="info-label">Anggota Terdaftar</span>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div
                                style="background: #f1f5f9; padding: 8px 15px; border-radius: 8px; color: var(--primary); font-weight: bold;">
                                <i class="ri-group-fill"></i> {{ $event->users->count() }} Orang
                            </div>
                        </div>
                    </div>

                    <!-- AREA AKSI / PENDAFTARAN -->
                    <div class="event-actions">

                        @guest
                            {{-- 1. JIKA BELUM LOGIN --}}
                            @if (!$event->status)
                                <button disabled class="btn-action btn-disabled"
                                    style="background: #fee2e2; color: #ef4444; border-color: #fca5a5;">
                                    <i class="ri-close-circle-line"></i> Pendaftaran Ditutup
                                </button>
                            @else
                                <button disabled class="btn-action btn-disabled">
                                    <i class="ri-lock-2-line"></i> Login untuk Daftar
                                </button>
                                <span style="font-size: 0.75rem; text-align: center; color: #ef4444; font-weight: 500;">
                                    *Khusus anggota terdaftar
                                </span>
                            @endif
                        @else
                            {{-- 2. JIKA SUDAH LOGIN --}}
                            @if ($event->users->contains(auth()->user()->id))
                                {{-- Sudah Daftar -> Tombol WA (Selalu tampil meski status event sudah ditutup) --}}
                                <a href="{{ $event->link }}" target="_blank" class="btn-action btn-whatsapp">
                                    <i class="ri-whatsapp-fill" style="font-size: 1.3rem;"></i> Gabung Grup WA
                                </a>
                                <span style="font-size: 0.75rem; text-align: center; color: #10b981; font-weight: 500;">
                                    <i class="ri-check-line"></i> Anda sudah terdaftar
                                </span>
                            @else
                                {{-- Belum Daftar -> Cek Status Event --}}
                                @if (!$event->status)
                                    <button disabled class="btn-action btn-disabled"
                                        style="background: #fee2e2; color: #ef4444; border-color: #fca5a5;">
                                        <i class="ri-close-circle-line"></i> Pendaftaran Ditutup
                                    </button>
                                @else
                                    <form action="{{ route('landing.events.register', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn-action btn-register">
                                            <i class="ri-checkbox-circle-line" style="font-size: 1.2rem;"></i> Daftar Sekarang
                                        </button>
                                    </form>
                                @endif
                            @endif
                        @endguest

                        <!-- Tombol Share -->
                        <button id="btnShare" class="btn-action btn-share" style="margin-top: 10px;">
                            <i id="shareIcon" class="ri-share-forward-line"></i>
                            <span id="shareText">Bagikan Event</span>
                        </button>
                    </div>
                </div>
            </aside>

        </div>
    </section>

    <div id="copyToast" class="custom-toast">
        <i class="ri-links-fill text-lg"></i> Link berhasil disalin ke clipboard!
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnShare = document.getElementById('btnShare');

            if (btnShare) {
                btnShare.addEventListener('click', async () => {
                    const icon = document.getElementById('shareIcon');
                    const text = document.getElementById('shareText');

                    const shareData = {
                        title: document.title,
                        text: 'Yuk ikuti event keren ini di Informatics Study Club!',
                        url: window.location.href
                    };

                    if (navigator.share && /Mobi|Android/i.test(navigator.userAgent)) {
                        try {
                            await navigator.share(shareData);
                        } catch (err) {
                            console.log('User membatalkan share:', err);
                        }
                    } else {
                        const copyText = window.location.href;

                        try {
                            await navigator.clipboard.writeText(copyText);
                            showSuccessState(btnShare, icon, text);
                        } catch (err) {
                            try {
                                const textArea = document.createElement("textarea");
                                textArea.value = copyText;

                                textArea.style.position = "fixed";
                                textArea.style.top = "-9999px";
                                textArea.style.left = "-9999px";

                                document.body.appendChild(textArea);
                                textArea.focus();
                                textArea.select();

                                const successful = document.execCommand('copy');
                                document.body.removeChild(textArea);

                                if (successful) {
                                    showSuccessState(btnShare, icon, text);
                                } else {
                                    alert(
                                        'Gagal menyalin link. Silakan salin URL di atas secara manual.'
                                    );
                                }
                            } catch (fallbackErr) {
                                console.error('Semua metode copy gagal:', fallbackErr);
                                alert('Gagal menyalin link. Silakan salin URL di atas secara manual.');
                            }
                        }
                    }
                });
            }

            // Fungsi untuk menampilkan animasi sukses
            function showSuccessState(btn, icon, text) {
                btn.classList.add('copied');
                icon.classList.replace('ri-share-forward-line', 'ri-check-double-line');
                text.innerText = 'Tersalin!';

                const toast = document.getElementById('copyToast');
                if (toast) toast.classList.add('show');

                setTimeout(() => {
                    btn.classList.remove('copied');
                    icon.classList.replace('ri-check-double-line', 'ri-share-forward-line');
                    text.innerText = 'Bagikan Event';
                    if (toast) toast.classList.remove('show');
                }, 3000);
            }
        });
    </script>
@endpush
