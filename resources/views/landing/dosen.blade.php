@extends('landing.master')

@push('styles')
    <style>
        /* 1. HEADER HALAMAN */
        .dosen-page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            /* Padding bawah dikurangi sedikit karena sudah tidak ada overlap */
            padding: 140px 5% 80px;
            text-align: center;
            color: var(--white);
        }

        .dosen-page-header h1 {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 0.8rem;
            font-family: 'Poppins', sans-serif;
        }

        .dosen-page-header p {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* 2. SECTION CONTENT */
        .dosen-section {
            padding: 0 5% 5rem;
            background: var(--bg-light);
            min-height: 60vh;
        }

        /* PERBAIKAN JARAK (GRID SYSTEM) */
        .dosen-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2.5rem;
            /* Jarak antar kartu */
            max-width: 1200px;
            margin: 0 auto;

            /* --- INI BAGIAN YANG MEMBERIKAN JARAK --- */
            margin-top: 4rem;
            /* Jarak positif dari header ke kartu (sekitar 64px) */
        }

        /* 3. DOSEN CARD DESIGN */
        .dosen-card {
            background: var(--white);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            /* Shadow lebih halus */
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            z-index: 2;
            text-align: center;

            /* Ukuran Kartu */
            width: 260px;
            display: flex;
            flex-direction: column;
        }

        .dosen-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -10px rgba(15, 32, 75, 0.15);
            border-color: var(--accent);
        }

        /* Wrapper Foto */
        .dosen-img-wrapper {
            position: relative;
            height: 280px;
            width: 100%;
            overflow: hidden;
            background-color: #f1f5f9;
        }

        .dosen-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top center;
            transition: transform 0.5s ease;
        }

        .dosen-card:hover .dosen-img-wrapper img {
            transform: scale(1.05);
        }

        /* Card Info */
        .dosen-info {
            padding: 1.5rem 1rem;
            background: white;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            border-top: 1px solid #f1f5f9;
        }

        .dosen-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .dosen-position {
            display: inline-block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            background: rgba(212, 175, 55, 0.1);
            padding: 4px 12px;
            border-radius: 50px;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .dosen-page-header {
                padding: 120px 5% 60px;
            }

            .dosen-page-header h1 {
                font-size: 2rem;
            }

            .dosen-card {
                width: 100%;
                max-width: 320px;
            }

            .dosen-grid {
                margin-top: 2rem;
                /* Jarak lebih kecil di HP */
                gap: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <header class="dosen-page-header">
        <h1>Dosen Pembimbing</h1>
        <div style="width: 60px; height: 3px; background: var(--accent); margin: 0 auto 1.2rem auto; border-radius: 2px;">
        </div>
        <p>Para akademisi ahli yang membimbing dan mendukung visi Informatics Study Club.</p>
    </header>

    <section id="dosen" class="dosen-section">
        <div class="dosen-grid">

            @forelse($advisors as $dosen)
                <div class="dosen-card">
                    <div class="dosen-img-wrapper">
                        @if ($dosen->photo)
                            <img src="{{ asset('uploads/advisors/' . $dosen->photo) }}" alt="{{ $dosen->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($dosen->name) }}&background=0f204b&color=fff&size=500"
                                alt="{{ $dosen->name }}">
                        @endif
                    </div>

                    <div class="dosen-info">
                        <h3 class="dosen-name">{{ $dosen->name }}</h3>
                        <div>
                            <span class="dosen-position">{{ $dosen->position }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="width: 100%; text-align: center; color: var(--text-light); padding: 4rem;">
                    <i class="ri-user-unfollow-line"
                        style="font-size: 3rem; color: #cbd5e1; display: block; margin-bottom: 1rem;"></i>
                    <p class="text-lg">Belum ada data Dosen Pembimbing.</p>
                </div>
            @endforelse

        </div>
    </section>
@endsection
