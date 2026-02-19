@extends('landing.master')

@push('styles')
    <style>
        /* 1. HEADER PROFILE (NAVY BACKGROUND) */
        .profile-header-bg {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            height: 350px;
            position: relative;
            width: 100%;
        }

        .back-btn-wrapper {
            position: absolute;
            top: 120px;
            left: 5%;
            z-index: 10;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(5px);
            color: var(--white);
            border-radius: 30px;
            font-weight: 600;
            transition: 0.3s;
            border: 1px solid rgba(255, 255, 255, 0.2);
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--accent);
            color: var(--primary);
            border-color: var(--accent);
        }

        /* 2. PROFILE CONTAINER & AVATAR FIX */
        .profile-content-wrapper {
            max-width: 900px;
            margin: 0 auto;
            /* Tengah secara horizontal container */
            padding: 0 20px;
            position: relative;
            margin-top: -100px;
            /* Menarik konten ke atas menimpa header */
            padding-bottom: 5rem;
        }

        .profile-avatar-lg {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            border: 6px solid var(--white);
            object-fit: cover;
            background: var(--white);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);

            /* --- PERBAIKAN POSISI TENGAH --- */
            display: block;
            /* Wajib agar margin auto bekerja */
            margin-left: auto;
            /* Dorong dari kiri */
            margin-right: auto;
            /* Dorong dari kanan */
            position: relative;
            z-index: 2;
        }

        .text-center-content {
            text-align: center;
            margin-top: 1.5rem;
        }

        .profile-name-lg {
            font-family: 'Poppins', sans-serif;
            font-size: 2.5rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .profile-role-badge {
            display: inline-block;
            background: var(--bg-light);
            color: var(--accent);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 6px 18px;
            border-radius: 20px;
            font-size: 0.9rem;
            border: 1px solid #e2e8f0;
            margin-bottom: 1.5rem;
        }

        .profile-stats {
            display: flex;
            justify-content: center;
            gap: 2rem;
            margin-bottom: 3rem;
            color: var(--text-light);
            flex-wrap: wrap;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 1rem;
            font-weight: 500;
        }

        .stat-item i {
            color: var(--primary);
            font-size: 1.2rem;
        }

        /* 3. BIO & INFO SECTION */
        .bio-box {
            background: var(--white);
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 4rem;
            text-align: left;
            /* Teks paragraf rata kiri agar rapi */
            border: 1px solid #eee;
        }

        .bio-heading {
            font-size: 1.5rem;
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 1rem;
        }

        .bio-text {
            color: var(--text-light);
            line-height: 1.8;
            font-size: 1.05rem;
            white-space: pre-line;
            /* Agar Enter terbaca sebagai baris baru */
        }

        /* 4. PROJECTS SECTION */
        .projects-section {
            margin-top: 3rem;
        }

        .section-title {
            text-align: center;
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 2.5rem;
            font-weight: 700;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .project-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #eee;
            text-align: left;
        }

        .project-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(15, 32, 75, 0.15);
            border-color: var(--accent);
        }

        .project-thumb {
            height: 200px;
            width: 100%;
            object-fit: cover;
        }

        .project-content {
            padding: 1.5rem;
        }

        .project-cat {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block;
        }

        .project-title {
            font-size: 1.2rem;
            color: var(--primary);
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .project-desc {
            font-size: 0.9rem;
            color: var(--text-light);
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .project-link {
            font-size: 0.9rem;
            color: var(--primary);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            text-decoration: none;
        }

        .project-link:hover {
            color: var(--accent);
            gap: 8px;
        }

        /* Responsif */
        @media (max-width: 768px) {
            .profile-header-bg {
                height: 280px;
            }

            .profile-avatar-lg {
                width: 160px;
                height: 160px;
            }

            .profile-name-lg {
                font-size: 1.8rem;
            }

            .profile-stats {
                flex-direction: column;
                gap: 0.8rem;
                align-items: center;
            }

            .back-btn-wrapper {
                top: 100px;
            }

            .bio-box {
                padding: 1.5rem;
            }
        }
    </style>
@endpush

@section('content')
    <div class="profile-header-bg">
        <div class="back-btn-wrapper">
            <a href="{{ route('anggota') }}" class="btn-back">
                <i class="ri-arrow-left-line"></i> Kembali
            </a>
        </div>
    </div>

    <div class="profile-content-wrapper">

        @if ($member->profile && $member->profile->photo)
            <img src="{{ asset('uploads/profiles/' . $member->profile->photo) }}" alt="{{ $member->name }}"
                class="profile-avatar-lg">
        @else
            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=0f204b&color=d4af37&size=500"
                alt="{{ $member->name }}" class="profile-avatar-lg">
        @endif

        <div class="text-center-content">
            <h1 class="profile-name-lg">{{ $member->name }}</h1>

            <span class="profile-role-badge">
                {{ $member->profile->division ? ucwords(str_replace('_', ' ', $member->profile->division)) : 'ANGGOTA' }}
            </span>

            <div class="profile-stats">
                <div class="stat-item">
                    <i class="ri-calendar-check-line"></i>
                    <span>Angkatan {{ $member->profile->angkatan ?? '-' }}</span>
                </div>
                <div class="stat-item">
                    <i class="ri-mail-send-line"></i>
                    <span>{{ $member->email }}</span>
                </div>
                <div class="stat-item">
                    <i class="ri-shield-user-line"></i>
                    <span>Status: {{ ucfirst($member->role) }}</span>
                </div>
            </div>
        </div>

        <div class="bio-box">
            <h3 class="bio-heading"><i class="ri-user-smile-line"></i> Tentang Saya</h3>
            <p class="bio-text">
                @if ($member->profile && $member->profile->bio)
                    {{ $member->profile->bio }}
                @else
                    Halo! Saya adalah anggota aktif di <strong>Informatics Study Club</strong>.
                    Saya memiliki ketertarikan besar di bidang teknologi dan inovasi.
                    Saat ini saya sedang fokus mengembangkan skill dan berkontribusi melalui berbagai kegiatan organisasi.
                @endif
            </p>
        </div>

        <div class="projects-section">
            <h2 class="section-title">Hasil Karya & Portofolio</h2>

            <div class="project-grid">

                <div class="project-card">
                    <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?auto=format&fit=crop&w=500&q=80"
                        class="project-thumb">
                    <div class="project-content">
                        <span class="project-cat">Mobile App</span>
                        <h4 class="project-title">Aplikasi E-Library</h4>
                        <p class="project-desc">Aplikasi perpustakaan digital berbasis Android yang memudahkan mahasiswa
                            meminjam buku secara online.</p>
                        <a href="#" class="project-link">Lihat Detail <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>

                <div class="project-card">
                    <img src="https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&w=500&q=80"
                        class="project-thumb">
                    <div class="project-content">
                        <span class="project-cat">Web Development</span>
                        <h4 class="project-title">Sistem Informasi UMKM</h4>
                        <p class="project-desc">Platform website untuk membantu UMKM lokal memasarkan produk mereka ke pasar
                            yang lebih luas.</p>
                        <a href="#" class="project-link">Lihat Detail <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>

                <div class="project-card">
                    <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=500&q=80"
                        class="project-thumb">
                    <div class="project-content">
                        <span class="project-cat">IoT Project</span>
                        <h4 class="project-title">Smart Home System</h4>
                        <p class="project-desc">Prototipe sistem kendali lampu dan kipas angin otomatis menggunakan sensor
                            suara dan Arduino.</p>
                        <a href="#" class="project-link">Lihat Detail <i class="ri-arrow-right-line"></i></a>
                    </div>
                </div>

            </div>
        </div>

    </div>
@endsection
