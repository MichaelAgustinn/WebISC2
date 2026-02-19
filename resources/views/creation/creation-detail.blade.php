@extends('landing.master')

@push('styles')
    <style>
        /* =========================================
                           PROJECT DETAIL STYLES
                           ========================================= */
        .project-header {
            padding: 160px 5% 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            color: var(--white);
            text-align: left;
        }

        .project-breadcrumb {
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .project-header h1 {
            font-size: 3rem;
            line-height: 1.2;
            margin-bottom: 1rem;
            color: var(--white);
        }

        .project-tag-line {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 300;
            max-width: 700px;
        }

        .project-container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 0;
        }

        .project-wrapper {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 3rem;
            align-items: start;
        }

        .featured-project-img {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(15, 32, 75, 0.15);
            margin-bottom: 3rem;
            border: 1px solid #eee;
        }

        .project-body h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            padding-bottom: 10px;
        }

        .project-body h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 60px;
            height: 3px;
            background: var(--accent);
        }

        .project-body p {
            color: var(--text-light);
            margin-bottom: 1.5rem;
            font-size: 1.05rem;
            line-height: 1.8;
            white-space: pre-line;
        }

        /* --- SIDEBAR INFO --- */
        .project-info-card {
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

        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tech-badge {
            font-size: 0.8rem;
            background: var(--bg-light);
            color: var(--primary);
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            border: 1px solid #e2e8f0;
        }

        /* --- BUTTONS --- */
        .project-actions {
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
            transition: all 0.2s ease;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-family: inherit;
            font-size: 1rem;
        }

        /* STYLE KHUSUS TOMBOL LIKE */
        .btn-like {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #ffe4e6;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-like:hover {
            background: #ffe4e6;
            transform: translateY(-2px);
        }

        .btn-like:active {
            transform: scale(0.95);
        }

        /* State LIKED (PENTING: !important agar menimpa warna default) */
        .btn-like.liked {
            background: #e11d48 !important;
            color: white !important;
            border-color: #e11d48 !important;
        }

        /* --- NAVIGATION FOOTER --- */
        .project-nav-footer {
            margin-top: 5rem;
            border-top: 1px solid #eee;
            padding-top: 3rem;
            display: flex;
            justify-content: space-between;
        }

        .nav-project-link {
            display: flex;
            align-items: center;
            gap: 15px;
            text-decoration: none;
        }

        .nav-project-text span {
            display: block;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 2px;
        }

        .nav-project-text h5 {
            font-size: 1.1rem;
            margin: 0;
            transition: 0.3s;
            color: var(--primary);
        }

        .nav-project-link:hover h5 {
            color: var(--accent);
        }

        .nav-icon-box {
            width: 50px;
            height: 50px;
            background: var(--bg-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--primary);
            transition: 0.3s;
        }

        .nav-project-link:hover .nav-icon-box {
            background: var(--primary);
            color: var(--accent);
        }

        @media (max-width: 1024px) {
            .project-wrapper {
                grid-template-columns: 1fr;
            }

            .project-info-card {
                position: static;
                margin-bottom: 3rem;
                order: -1;
            }

            .project-header {
                padding: 120px 5% 60px;
            }

            .project-header h1 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .project-nav-footer {
                flex-direction: column;
                gap: 2rem;
            }
        }
    </style>
@endpush

@section('content')
    <header class="project-header">
        <div class="project-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('landing.creation') }}">Creation</a> <i class="ri-arrow-right-s-line"></i>
            <span>Detail</span>
        </div>
        <h1>{{ $project->title }}</h1>
        <p class="project-tag-line">
            Proyek unggulan dari divisi {{ ucwords(str_replace('_', ' ', $project->division)) }} Informatics Study Club.
        </p>
    </header>

    <section class="project-container">
        <div class="project-wrapper">

            <div class="project-main">
                <img src="{{ asset('uploads/projects/' . $project->image) }}" alt="{{ $project->title }}"
                    class="featured-project-img">

                <div class="project-body">
                    <h2>Tentang Proyek Ini</h2>
                    <p>{!! nl2br(e($project->description)) !!}</p>
                    <br>
                </div>

                <div class="project-nav-footer">
                    @if ($prevProject)
                        <a href="{{ route('landing.creation.detail', $prevProject->slug) }}" class="nav-project-link">
                            <div class="nav-icon-box"><i class="ri-arrow-left-line"></i></div>
                            <div class="nav-project-text">
                                <span>Sebelumnya</span>
                                <h5>{{ Str::limit($prevProject->title, 20) }}</h5>
                            </div>
                        </a>
                    @else
                        <div></div>
                    @endif

                    @if ($nextProject)
                        <a href="{{ route('landing.creation.detail', $nextProject->slug) }}" class="nav-project-link"
                            style="text-align: right; flex-direction: row-reverse;">
                            <div class="nav-icon-box"><i class="ri-arrow-right-line"></i></div>
                            <div class="nav-project-text">
                                <span>Selanjutnya</span>
                                <h5>{{ Str::limit($nextProject->title, 20) }}</h5>
                            </div>
                        </a>
                    @endif
                </div>
            </div>

            <aside class="project-sidebar">
                <div class="project-info-card">
                    <div class="info-group">
                        <span class="info-label">Kategori Divisi</span>
                        <span class="info-value">{{ ucwords(str_replace('_', ' ', $project->division)) }}</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Tanggal Publish</span>
                        <span class="info-value">{{ $project->created_at->format('d F Y') }}</span>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Anggota Tim (Kontributor)</span>
                        <div class="tech-stack" style="flex-direction: column; gap: 10px;">

                            {{-- 1. TAMPILKAN KETUA (OWNER) PALING ATAS --}}
                            @if ($project->owner)
                                <div
                                    style="display: flex; align-items: center; gap: 10px; padding-bottom: 8px; border-bottom: 1px dashed #eee;">
                                    @if ($project->owner->profile && $project->owner->profile->photo)
                                        <img src="{{ asset('uploads/profiles/' . $project->owner->profile->photo) }}"
                                            style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent);">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($project->owner->name) }}&background=d4af37&color=fff"
                                            style="width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--accent);">
                                    @endif
                                    <div style="display: flex; flex-direction: column;">
                                        <span style="font-weight: 700; font-size: 0.95rem; color: var(--primary);">
                                            {{ $project->owner->name }}
                                        </span>
                                        <span
                                            style="font-size: 0.7rem; color: var(--accent); font-weight: 600; text-transform: uppercase;">
                                            Ketua / Creator
                                        </span>
                                    </div>
                                </div>
                            @endif

                            {{-- 2. LOOPING ANGGOTA TIM (Kecuali Ketua) --}}
                            @foreach ($project->users as $member)
                                {{-- Cek agar Ketua tidak muncul 2 kali --}}
                                @if ($project->user_id != $member->id)
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        @if ($member->profile && $member->profile->photo)
                                            <img src="{{ asset('uploads/profiles/' . $member->profile->photo) }}"
                                                style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}"
                                                style="width: 30px; height: 30px; border-radius: 50%;">
                                        @endif
                                        <span style="font-weight: 500; font-size: 0.9rem; color: var(--text-dark);">
                                            {{ $member->name }}
                                        </span>
                                    </div>
                                @endif
                            @endforeach

                            {{-- Jika tidak ada anggota selain ketua --}}
                            @if ($project->users->where('id', '!=', $project->user_id)->isEmpty() && !$project->owner)
                                <span style="font-size: 0.85rem; color: #aaa;">Tidak ada anggota tim.</span>
                            @endif

                        </div>
                    </div>

                    <div class="info-group">
                        <span class="info-label">Tech Stack</span>
                        <div class="tech-stack">
                            @if ($project->division == 'mobile')
                                <span class="tech-badge">Flutter</span><span class="tech-badge">Dart</span>
                            @elseif($project->division == 'website')
                                <span class="tech-badge">Laravel</span><span class="tech-badge">Tailwind</span>
                            @elseif($project->division == 'iot')
                                <span class="tech-badge">Arduino</span><span class="tech-badge">ESP32</span>
                            @elseif($project->division == 'sistem_cerdas')
                                <span class="tech-badge">Python</span><span class="tech-badge">TensorFlow</span>
                            @else
                                <span class="tech-badge">Figma</span><span class="tech-badge">Design Thinking</span>
                            @endif
                        </div>
                    </div>

                    <div class="project-actions">
                        <button onclick="toggleLike(this, {{ $project->id }})" id="like-btn-{{ $project->id }}"
                            class="btn-action btn-like {{ Auth::check() && $project->isLikedBy(Auth::id()) ? 'liked' : '' }}">

                            <i
                                class="{{ Auth::check() && $project->isLikedBy(Auth::id()) ? 'ri-heart-fill' : 'ri-heart-line' }} text-xl"></i>

                            <span id="like-count-{{ $project->id }}" style="margin-left: 5px; margin-right: 5px;">
                                {{ $project->likes()->count() }}
                            </span>
                            Suka
                        </button>

                        <button class="btn-action"
                            style="background: transparent; color: var(--primary); border: 2px solid #eee;">
                            <i class="ri-share-forward-line"></i> Bagikan
                        </button>
                    </div>

                </div>
            </aside>

        </div>
    </section>

    <script>
        function toggleLike(btn, projectId) {
            // 1. Cek Login
            @guest
            window.location.href = "{{ route('login') }}";
            return;
        @endguest

        // 2. Ambil Elemen Icon & Counter
        const icon = btn.querySelector('i');
        const countSpan = document.getElementById(`like-count-${projectId}`);
        let currentCount = parseInt(countSpan.innerText);

        // 3. Cek Status Saat Ini (Berdasarkan class 'liked')
        const isCurrentlyLiked = btn.classList.contains('liked');

        // 4. OPTIMISTIC UI UPDATE (Ubah tampilan DULUAN sebelum request selesai)
        if (isCurrentlyLiked) {
            // Jika tadinya liked -> jadi unlike (Hapus Merah)
            btn.classList.remove('liked');
            icon.classList.remove('ri-heart-fill');
            icon.classList.add('ri-heart-line');
            countSpan.innerText = currentCount - 1;
        } else {
            // Jika tadinya unliked -> jadi like (Tambah Merah)
            btn.classList.add('liked');
            icon.classList.remove('ri-heart-line');
            icon.classList.add('ri-heart-fill');
            countSpan.innerText = currentCount + 1;

            // Animasi kecil
            icon.style.transform = 'scale(1.2)';
            setTimeout(() => icon.style.transform = 'scale(1)', 200);
        }

        // 5. Kirim Request ke Server (Background Process)
        fetch(`/projects/${projectId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
            })
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.json();
            })
            .then(data => {
                // Sinkronisasi ulang angka dari server
                if (data.count !== undefined) {
                    countSpan.innerText = data.count;
                }
            })
            .catch(error => {
                console.error('Error:', error);

                // 6. ROLLBACK (Jika error, kembalikan tampilan ke awal)
                if (isCurrentlyLiked) {
                    btn.classList.add('liked');
                    icon.classList.replace('ri-heart-line', 'ri-heart-fill');
                    countSpan.innerText = currentCount;
                } else {
                    btn.classList.remove('liked');
                    icon.classList.replace('ri-heart-fill', 'ri-heart-line');
                    countSpan.innerText = currentCount;
                }
                alert('Gagal memproses like. Periksa koneksi internet Anda.');
            });
        }
    </script>
@endsection
