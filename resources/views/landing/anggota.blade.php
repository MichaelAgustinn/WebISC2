@extends('landing.master')

@section('title', 'Anggota')

@push('styles')
    <style>
        /* 1. HEADER HALAMAN (NAVY BACKGROUND) */
        .page-header {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            padding: 150px 5% 80px;
            text-align: center;
            color: var(--white);
        }

        .page-header h1 {
            font-size: 3rem;
            font-weight: 700;
            color: var(--accent);
            margin-bottom: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        .page-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* 2. SEARCH BAR */
        .member-search-container {
            margin-top: -30px;
            padding: 0 5%;
            position: relative;
            z-index: 10;
            display: flex;
            justify-content: center;
        }

        .search-bar {
            background: var(--white);
            padding: 10px 15px;
            border-radius: 50px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 600px;
            border: 1px solid #eee;
        }

        .search-bar input {
            flex: 1;
            border: none;
            outline: none;
            padding: 10px 15px;
            font-size: 1rem;
            color: var(--text-dark);
        }

        .search-bar button {
            background: var(--primary);
            color: var(--white);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        .search-bar button:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* 3. MEMBER SECTION */
        .member-section {
            padding: 5rem 5%;
            background: var(--bg-light);
            min-height: 60vh;
        }

        .member-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* 4. MEMBER CARD */
        .member-card {
            background: var(--white);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #eee;
            text-align: center;
            padding-bottom: 1.5rem;
        }

        .member-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(15, 32, 75, 0.15);
            border-color: var(--accent);
        }

        .member-img-wrapper {
            position: relative;
            height: 250px;
            width: 100%;
            overflow: hidden;
        }

        .member-img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .member-card:hover .member-img-wrapper img {
            transform: scale(1.1);
        }

        /* Social Overlay */
        .member-social {
            position: absolute;
            bottom: -50px;
            left: 0;
            width: 100%;
            background: rgba(15, 32, 75, 0.9);
            display: flex;
            justify-content: center;
            gap: 1rem;
            padding: 10px 0;
            transition: bottom 0.3s ease;
        }

        .member-card:hover .member-social {
            bottom: 0;
        }

        .member-social a {
            color: var(--white);
            font-size: 1.1rem;
            transition: color 0.3s;
        }

        .member-social a:hover {
            color: var(--accent);
        }

        /* Member Info */
        .member-info {
            padding: 1.5rem 1rem 0;
        }

        .member-name {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.2rem;
        }

        .member-divisi {
            display: block;
            font-size: 0.85rem;
            color: var(--accent);
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
        }

        .member-year {
            display: block;
            font-size: 0.8rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        .btn-follow {
            padding: 6px 20px;
            border: 1px solid var(--primary);
            background: transparent;
            color: var(--primary);
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-follow:hover {
            background: var(--primary);
            color: var(--white);
        }

        /* Responsif */
        @media (max-width: 768px) {
            .page-header {
                padding: 120px 5% 60px;
            }

            .page-header h1 {
                font-size: 2.2rem;
            }
        }
    </style>
@endpush

@section('content')
    <header class="page-header">
        <h1>Anggota Kami</h1>

        <div style="width: 80px; height: 4px; background: var(--accent); margin: 0 auto 1.5rem auto; border-radius: 2px;">
        </div>

        <p>
            Talenta-talenta muda yang berdedikasi membangun inovasi dan teknologi masa depan.
        </p>
    </header>

    <!-- SEARCH BAR -->
    <div class="member-search-container">

        <form action="{{ route('anggota') }}" method="GET" class="search-bar"
            style="width: 100%; max-width: 600px; display: flex;">

            <input type="text" name="search" id="searchInput" value="{{ request('search') }}"
                placeholder="Cari nama, divisi, atau angkatan...">

            <button type="submit">
                <i class="ri-search-line"></i>
            </button>

        </form>

    </div>

    <section class="member-section">

        {{-- WRAPPER --}}
        <div id="memberWrapper">

            <div class="member-grid" id="memberGrid">

                @forelse($members as $member)

                    <div class="member-card">

                        <div class="member-img-wrapper">

                            @if ($member->profile && $member->profile->photo)
                                <img src="{{ asset('uploads/profiles/' . $member->profile->photo) }}"
                                    alt="{{ $member->name }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=0f204b&color=d4af37&size=500"
                                    alt="{{ $member->name }}">
                            @endif

                            @if (
                                $member->profile &&
                                    ($member->profile->instagram ||
                                        $member->profile->linkedin ||
                                        $member->profile->github ||
                                        $member->profile->personal_link))
                                <div class="member-social">

                                    @if ($member->profile->github)
                                        <a href="{{ $member->profile->github }}" target="_blank">
                                            <i class="ri-github-line"></i>
                                        </a>
                                    @endif

                                    @if ($member->profile->linkedin)
                                        <a href="{{ $member->profile->linkedin }}" target="_blank">
                                            <i class="ri-linkedin-fill"></i>
                                        </a>
                                    @endif

                                    @if ($member->profile->instagram)
                                        <a href="{{ $member->profile->instagram }}" target="_blank">
                                            <i class="ri-instagram-line"></i>
                                        </a>
                                    @endif

                                    @if ($member->profile->personal_link)
                                        <a href="{{ $member->profile->personal_link }}" target="_blank">
                                            <i class="ri-global-line"></i>
                                        </a>
                                    @endif

                                </div>
                            @endif

                        </div>

                        <div class="member-info">

                            <h3 class="member-name">
                                {{ $member->name }}
                            </h3>

                            <span class="member-divisi">
                                {{ $member->profile->division ? ucwords(str_replace('_', ' ', $member->profile->division)) : 'Anggota Baru' }}
                            </span>

                            <span class="member-year">
                                Angkatan {{ $member->profile->angkatan ?? '-' }}
                            </span>

                            <a href="{{ route('anggota.show', $member->slug) }}" class="btn-follow"
                                style="text-decoration:none; display:inline-block;">

                                Detail Profil

                            </a>

                        </div>

                    </div>

                @empty

                    <div style="grid-column: 1 / -1; text-align: center; color: var(--text-light); padding: 2rem;">

                        <p>
                            Belum ada data anggota yang terdaftar.
                        </p>

                    </div>

                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if ($members->hasPages())
                <div style="margin-top: 3rem; display: flex; justify-content: center;">

                    {{ $members->links('vendor.pagination.custom') }}

                </div>
            @endif

        </div>

    </section>

    <script>
        const searchInput = document.getElementById('searchInput');
        const memberWrapper = document.getElementById('memberWrapper');

        let debounceTimer;

        // LIVE SEARCH
        searchInput.addEventListener('keyup', function() {

            clearTimeout(debounceTimer);

            debounceTimer = setTimeout(() => {

                fetch(`/anggota?search=${encodeURIComponent(this.value)}`, {

                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }

                    })

                    .then(response => response.text())

                    .then(html => {

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newWrapper = doc.getElementById('memberWrapper');

                        memberWrapper.innerHTML = newWrapper.innerHTML;

                    });

            }, 300);

        });

        // AJAX PAGINATION
        document.addEventListener('click', function(e) {

            const paginationLink = e.target.closest('.pagination a');

            if (paginationLink) {

                e.preventDefault();

                fetch(paginationLink.href, {

                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }

                    })

                    .then(response => response.text())

                    .then(html => {

                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');

                        const newWrapper = doc.getElementById('memberWrapper');

                        memberWrapper.innerHTML = newWrapper.innerHTML;

                    });

            }

        });
    </script>

@endsection
