@extends('landing.master')

@section('content')
    <header class="blog-header">
        <h1>Wawasan & Informasi</h1>
        <div class="header-line"></div>
        <p>Temukan artikel terbaru, tutorial teknologi, dan dokumentasi kegiatan kami.</p>
    </header>

    <section class="blog-container">
        <div class="blog-wrapper">

            <div class="blog-main">
                <div class="blog-list">
                    @forelse($posts as $post)
                        <article class="blog-card">
                            <div class="card-img">
                                <span class="category-tag">
                                    {{ $post->categories->isNotEmpty() ? $post->categories->first()->name : 'General' }}
                                </span>

                                <a href="{{ route('blog.show', $post->slug) }}">
                                    @if ($post->thumbnail)
                                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1499750310159-5b5f22138751?auto=format&fit=crop&w=500&q=80"
                                            alt="Default">
                                    @endif
                                </a>
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="ri-calendar-line"></i> {{ $post->created_at->format('d M Y') }}</span>
                                    <span><i class="ri-user-line"></i> {{ Str::limit($post->user->name, 10) }}</span>
                                </div>
                                <h3 class="blog-title">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ Str::limit($post->title, 50) }}</a>
                                </h3>
                                <p class="blog-desc">
                                    {{ Str::limit(strip_tags($post->description), 100) }}
                                </p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                    Baca Selengkapnya <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div class="empty-state">
                            <h3>Belum ada artikel ditemukan.</h3>
                            <p>Coba kata kunci lain atau kembali nanti.</p>
                            @if (request('search'))
                                <a href="{{ route('blog.index') }}">Reset Pencarian</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                <div class="pagination-wrapper mt-5">
                    {{ $posts->withQueryString()->links('vendor.pagination.custom') }}
                </div>
            </div>

            <aside class="sidebar">

                <div class="sidebar-widget search-widget">
                    <h4 class="widget-title">Cari Artikel</h4>
                    <form class="search-form" action="{{ route('blog.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Ketik kata kunci..."
                            value="{{ request('search') }}">
                        <button type="submit"><i class="ri-search-2-line"></i></button>
                    </form>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Artikel Terbaru</h4>
                    <div class="recent-posts-list">
                        @foreach ($recentPosts as $recent)
                            <div class="recent-post-item">
                                <a href="{{ route('blog.show', $recent->slug) }}" class="rp-thumb-link">
                                    @if ($recent->thumbnail)
                                        <img src="{{ asset($recent->thumbnail) }}" alt="Thumb" class="rp-thumb">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($recent->title) }}&background=random"
                                            alt="Thumb" class="rp-thumb">
                                    @endif
                                </a>

                                <div class="rp-info">
                                    <h5><a
                                            href="{{ route('blog.show', $recent->slug) }}">{{ Str::limit($recent->title, 40) }}</a>
                                    </h5>
                                    <span class="rp-date"><i class="ri-calendar-line"></i>
                                        {{ $recent->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Kategori Populer</h4>
                    <ul class="category-list">
                        @forelse($popularCategories as $category)
                            <li>
                                <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                    class="{{ request('category') == $category->slug ? 'active-cat' : '' }}">

                                    {{ $category->name }}

                                    <span class="cat-count">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 italic">Belum ada kategori.</li>
                        @endforelse
                    </ul>

                    @if (request('category'))
                        <div class="mt-4 text-center">
                            <a href="{{ route('blog.index') }}" class="text-sm text-indigo-500 hover:underline">
                                <i class="ri-refresh-line"></i> Tampilkan Semua
                            </a>
                        </div>
                    @endif
                </div>

            </aside>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* --- 1. HEADER NAVY (FIXED) --- */
        .blog-header {
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            /* Warna Navy Gelap */
            padding: 160px 5% 80px;
            text-align: center;
            color: var(--white);
            position: relative;
        }

        .blog-header h1 {
            font-size: 3rem;
            font-weight: 800;
            color: var(--accent);
            /* Warna Emas */
            margin-bottom: 1rem;
        }

        .header-line {
            width: 80px;
            height: 4px;
            background: var(--accent);
            margin: 0 auto 1.5rem auto;
            border-radius: 2px;
        }

        .blog-header p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.8);
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .active-cat {
            color: var(--primary) !important;
            font-weight: 700 !important;
            background: #f1f5f9 !important;
            border-left: 3px solid var(--accent);
            /* Indikator garis emas di kiri */
        }

        /* --- LAYOUT UTAMA --- */
        .blog-container {
            padding: 5rem 5%;
            background-color: #f8f9fa;
        }

        .blog-wrapper {
            display: grid;
            grid-template-columns: 2.5fr 1fr;
            gap: 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Blog Grid */
        .blog-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        /* --- CARD STYLE --- */
        .blog-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            border: 1px solid #eee;
            display: flex;
            flex-direction: column;
            position: relative;
            /* Penting untuk tag absolute */
        }

        .blog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(15, 32, 75, 0.1);
            border-color: var(--accent);
        }

        .card-img {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .blog-card:hover .card-img img {
            transform: scale(1.05);
        }

        /* --- 2. TAG ARTIKEL (FIXED) --- */
        .category-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            z-index: 10;

            /* KUNCI PERBAIKAN: */
            display: inline-flex;
            /* Agar lebar menyesuaikan konten */
            width: auto;
            /* Reset lebar default */
            max-width: fit-content;
            /* Memastikan tidak full width */
            align-items: center;
            justify-content: center;

            background: var(--accent);
            /* Warna Emas */
            color: var(--primary);
            /* Warna Navy */

            padding: 6px 14px;
            border-radius: 50px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .blog-content {
            padding: 25px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-meta {
            display: flex;
            gap: 15px;
            font-size: 0.8rem;
            color: #888;
            margin-bottom: 12px;
        }

        .blog-meta span {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .blog-meta i {
            color: var(--accent);
        }

        .blog-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
            line-height: 1.4;
            font-weight: 700;
        }

        .blog-title a {
            color: var(--primary);
            text-decoration: none;
            transition: 0.3s;
        }

        .blog-title a:hover {
            color: var(--accent);
        }

        .blog-desc {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 20px;
            flex: 1;
        }

        .read-more {
            margin-top: auto;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
            font-size: 0.9rem;
        }

        .read-more:hover {
            gap: 8px;
            color: var(--accent);
        }

        /* --- SIDEBAR --- */
        .sidebar-widget {
            background: #fff;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #eee;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 800;
            color: var(--primary);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f1f5f9;
            position: relative;
        }

        .widget-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: var(--accent);
        }

        /* Search Form */
        .search-form {
            display: flex;
            position: relative;
        }

        .search-form input {
            width: 100%;
            padding: 12px 20px;
            border: 1px solid #e2e8f0;
            border-radius: 50px;
            outline: none;
            transition: 0.3s;
            background: #f8fafc;
            color: var(--primary);
        }

        .search-form input:focus {
            border-color: var(--accent);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .search-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            background: var(--primary);
            color: #fff;
            border: none;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            cursor: pointer;
            transition: 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .search-form button:hover {
            background: var(--accent);
            color: var(--primary);
        }

        /* Recent Post */
        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
            align-items: center;
            padding-bottom: 20px;
            border-bottom: 1px dashed #f1f5f9;
        }

        .recent-post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .rp-thumb {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            transition: 0.3s;
        }

        .rp-thumb-link:hover .rp-thumb {
            transform: scale(1.05);
        }

        .rp-info h5 {
            font-size: 0.95rem;
            margin: 0 0 5px;
            line-height: 1.4;
            font-weight: 700;
        }

        .rp-info h5 a {
            color: var(--primary);
            text-decoration: none;
            transition: 0.2s;
        }

        .rp-info h5 a:hover {
            color: var(--accent);
        }

        .rp-date {
            font-size: 0.75rem;
            color: #94a3b8;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Category List */
        .category-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .category-list li {
            margin-bottom: 12px;
        }

        .category-list li:last-child {
            margin-bottom: 0;
        }

        .category-list a {
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #64748b;
            text-decoration: none;
            font-size: 0.95rem;
            transition: 0.3s;
            padding: 8px 10px;
            border-radius: 8px;
            background: #f8fafc;
        }

        .category-list a:hover {
            color: var(--primary);
            background: #fff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            transform: translateX(5px);
        }

        .cat-count {
            background: var(--primary);
            color: #fff;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        /* Empty State */
        .empty-state {
            width: 100%;
            text-align: center;
            padding: 60px;
            background: #fff;
            border-radius: 15px;
            border: 1px dashed #cbd5e1;
            grid-column: 1 / -1;
        }

        .empty-state h3 {
            color: var(--primary);
            margin-bottom: 10px;
            font-weight: 700;
        }

        .empty-state p {
            color: #64748b;
            margin-bottom: 20px;
        }

        .empty-state a {
            color: var(--accent);
            font-weight: 700;
            text-decoration: underline;
        }

        /* Custom Pagination (Jika belum pakai file view terpisah) */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
        }

        .page-link {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #fff;
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            border: 1px solid #eee;
            margin: 0 5px;
            transition: 0.3s;
        }

        .page-link:hover,
        .page-link.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .blog-wrapper {
                grid-template-columns: 1fr;
            }

            .blog-header {
                padding-top: 120px;
            }
        }
    </style>
@endpush
