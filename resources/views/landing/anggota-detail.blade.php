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
            padding: 0 20px;
            position: relative;
            margin-top: -100px;
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
            display: block;
            margin-left: auto;
            margin-right: auto;
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

        /* --- TAMBAHAN: STYLING SOSIAL MEDIA --- */
        .social-links {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 2rem;
        }

        .social-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            background: #f8fafc;
            color: var(--primary);
            border-radius: 50%;
            font-size: 1.3rem;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .social-icon:hover {
            background: var(--accent);
            color: var(--white);
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        /* -------------------------------------- */

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

            @if (
                $member->profile &&
                    ($member->profile->instagram ||
                        $member->profile->linkedin ||
                        $member->profile->github ||
                        $member->profile->personal_link))
                <div class="social-links">
                    @if ($member->profile->instagram)
                        <a href="{{ $member->profile->instagram }}" target="_blank" class="social-icon" title="Instagram">
                            <i class="ri-instagram-line"></i>
                        </a>
                    @endif

                    @if ($member->profile->linkedin)
                        <a href="{{ $member->profile->linkedin }}" target="_blank" class="social-icon" title="LinkedIn">
                            <i class="ri-linkedin-fill"></i>
                        </a>
                    @endif

                    @if ($member->profile->github)
                        <a href="{{ $member->profile->github }}" target="_blank" class="social-icon" title="GitHub">
                            <i class="ri-github-fill"></i>
                        </a>
                    @endif

                    @if ($member->profile->personal_link)
                        <a href="{{ $member->profile->personal_link }}" target="_blank" class="social-icon"
                            title="Personal Website">
                            <i class="ri-global-line"></i>
                        </a>
                    @endif
                </div>
            @endif

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
            <h3 class="bio-heading"><i class="ri-user-smile-line"></i> Tentang {{ $member->name }}</h3>
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
                @forelse($member->projects as $project)
                    <div class="project-card">
                        <img src="{{ asset('uploads/projects/' . $project->image) ?? '' }}" class="project-thumb">
                        <div class="project-content">
                            <span class="project-cat">{{ $project->division }}</span>
                            <h4 class="project-title">{{ $project->title }}</h4>
                            <p class="project-desc">{{ Str::limit($project->description, 100, '...') }}</p>
                            <a href="{{ route('landing.creation.detail', $project->slug) }}" class="project-link">Lihat
                                Detail <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                @empty
                    <p style="color: #666; text-align: center;">Anggota ini belum mengunggah karya.</p>
                @endforelse

            </div>
        </div>

    </div>
@endsection
