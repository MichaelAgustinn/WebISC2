@extends('landing.master')

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
        <p>Talenta-talenta muda yang berdedikasi membangun inovasi dan teknologi masa depan.</p>
    </header>

    <div class="member-search-container">
        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Cari nama, divisi, atau angkatan...">
            <button><i class="ri-search-line"></i></button>
        </div>
    </div>

    <section class="member-section">
        <div class="member-grid" id="memberGrid">

            @forelse($members as $member)
                <div class="member-card">
                    <div class="member-img-wrapper">
                        @if ($member->profile && $member->profile->photo)
                            <img src="{{ asset('uploads/profiles/' . $member->profile->photo) }}" alt="{{ $member->name }}">
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=0f204b&color=d4af37&size=500"
                                alt="{{ $member->name }}">
                        @endif

                        {{-- ? untuk nanti jika ingin menambah table soscial untuk setiap anggota --}}
                        {{-- <div class="member-social">
                            <a href="#"><i class="ri-github-line"></i></a>
                            <a href="#"><i class="ri-linkedin-fill"></i></a>
                            <a href="#"><i class="ri-instagram-line"></i></a>
                        </div> --}}
                    </div>
                    <div class="member-info">
                        <h3 class="member-name">{{ $member->name }}</h3>

                        <span class="member-divisi">
                            {{ $member->profile->division ? ucwords(str_replace('_', ' ', $member->profile->division)) : 'Anggota Baru' }}
                        </span>

                        <span class="member-year">
                            Angkatan {{ $member->profile->angkatan ?? '-' }}
                        </span>

                        <a href="{{ route('anggota.show', $member->id) }}" class="btn-follow"
                            style="text-decoration:none; display:inline-block;">Detail Profil</a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; color: var(--text-light); padding: 2rem;">
                    <p>Belum ada data anggota yang terdaftar.</p>
                </div>
            @endforelse

        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const memberCards = document.querySelectorAll('.member-card');

            if (searchInput) {
                searchInput.addEventListener('keyup', function(e) {
                    const term = e.target.value.toLowerCase();

                    memberCards.forEach(card => {
                        const name = card.querySelector('.member-name').textContent.toLowerCase();
                        const divisi = card.querySelector('.member-divisi').textContent
                            .toLowerCase();
                        const year = card.querySelector('.member-year').textContent.toLowerCase();

                        // Cari berdasarkan Nama, Divisi, atau Angkatan
                        if (name.includes(term) || divisi.includes(term) || year.includes(term)) {
                            card.style.display = "block"; // Kembalikan ke block/default grid item
                        } else {
                            card.style.display = "none";
                        }
                    });
                });
            }
        });
    </script>
@endsection
