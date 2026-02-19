@extends('landing.master')

@push('styles')
    <style>
        /* --- 1. STYLE GLOBAL (Header, Layout, Sidebar) --- */
        .article-header {
            padding: 160px 5% 80px;
            background: linear-gradient(135deg, var(--primary) 0%, #081226 100%);
            color: var(--white);
            text-align: left;
        }

        .article-breadcrumb {
            color: var(--accent);
            font-size: 0.9rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .article-breadcrumb a {
            color: var(--accent);
            text-decoration: none;
        }

        .article-header h1 {
            font-size: 2.8rem;
            line-height: 1.3;
            margin-bottom: 1.5rem;
            color: var(--white);
            max-width: 900px;
        }

        .article-meta-header {
            display: flex;
            gap: 20px;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.8);
            align-items: center;
            flex-wrap: wrap;
        }

        .article-meta-header i {
            color: var(--accent);
            margin-right: 5px;
        }

        .meta-divider {
            width: 5px;
            height: 5px;
            background: var(--accent);
            border-radius: 50%;
        }

        .blog-container {
            width: 90%;
            max-width: 1400px;
            margin: 0 auto;
            padding: 4rem 0;
        }

        .blog-wrapper {
            display: grid;
            grid-template-columns: 3fr 1.2fr;
            gap: 3rem;
            align-items: start;
        }

        .blog-detail-content {
            background: var(--white);
            border-radius: 15px;
        }

        .featured-image {
            width: 100%;
            height: auto;
            max-height: 500px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 2.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .article-body {
            color: #334155;
            font-size: 1.05rem;
            line-height: 1.8;
        }

        .article-body p {
            margin-bottom: 1.5rem;
        }

        .article-body h2 {
            font-size: 1.8rem;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary);
            position: relative;
            padding-left: 15px;
            font-weight: 700;
        }

        .article-body h2::before {
            content: '';
            position: absolute;
            left: 0;
            top: 5px;
            bottom: 5px;
            width: 4px;
            background: var(--accent);
            border-radius: 2px;
        }

        .article-body h3 {
            font-size: 1.4rem;
            margin-top: 2rem;
            margin-bottom: 0.8rem;
            font-weight: 700;
            color: var(--primary);
        }

        .article-body ul,
        .article-body ol {
            margin-bottom: 1.5rem;
            padding-left: 1.5rem;
        }

        .article-body li {
            margin-bottom: 0.5rem;
        }

        .article-body blockquote {
            background: #f8fafc;
            border-left: 4px solid var(--accent);
            padding: 1.5rem 2rem;
            margin: 2rem 0;
            font-style: italic;
            color: var(--primary);
            font-weight: 500;
            border-radius: 0 10px 10px 0;
        }

        .article-body img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin: 1rem 0;
        }

        .article-footer {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .tag-item {
            background: #f1f5f9;
            color: #64748b;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            transition: 0.3s;
            text-decoration: none;
        }

        .tag-item:hover {
            background: var(--primary);
            color: var(--accent);
        }

        .share-buttons {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .share-label {
            font-weight: 600;
            color: var(--primary);
        }

        .share-btn {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: var(--white);
            border: 1px solid #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary);
            transition: 0.3s;
            text-decoration: none;
        }

        .share-btn:hover {
            background: var(--accent);
            color: var(--primary);
            border-color: var(--accent);
        }

        .author-box {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 15px;
            margin-top: 3rem;
            display: flex;
            gap: 1.5rem;
            align-items: center;
            border: 1px solid #eee;
        }

        .author-img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--accent);
        }

        .author-info h4 {
            font-size: 1.2rem;
            margin-bottom: 0.3rem;
            font-weight: 700;
            color: var(--primary);
        }

        .author-info span {
            font-size: 0.85rem;
            color: #64748b;
            display: block;
            margin-bottom: 0.5rem;
        }

        .author-info p {
            font-size: 0.95rem;
            margin: 0;
            color: #334155;
        }

        .post-navigation {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 3rem;
        }

        .nav-card {
            background: var(--white);
            border: 1px solid #eee;
            padding: 1.5rem;
            border-radius: 10px;
            transition: 0.3s;
            text-decoration: none;
            display: block;
        }

        .nav-card.disabled {
            opacity: 0.5;
            cursor: default;
            pointer-events: none;
        }

        .nav-card:hover {
            border-color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .nav-label {
            font-size: 0.8rem;
            color: #94a3b8;
            text-transform: uppercase;
            font-weight: 700;
            display: block;
            margin-bottom: 5px;
        }

        .nav-title {
            font-weight: 600;
            color: var(--primary);
            margin: 0;
            font-size: 1rem;
            line-height: 1.4;
        }

        .sidebar {
            position: sticky;
            top: 100px;
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-widget {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            border: 1px solid #eee;
        }

        .widget-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid var(--accent);
            display: inline-block;
            color: var(--primary);
        }

        .search-form {
            display: flex;
            position: relative;
        }

        .search-form input {
            width: 100%;
            padding: 12px 15px;
            padding-right: 45px;
            border: 1px solid #ddd;
            border-radius: 50px;
            outline: none;
            background: #f8fafc;
        }

        .search-form input:focus {
            border-color: var(--accent);
            background: #fff;
        }

        .search-form button {
            position: absolute;
            right: 5px;
            top: 5px;
            width: 35px;
            height: 35px;
            background: var(--primary);
            color: #fff;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: 0.3s;
        }

        .search-form button:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .recent-post-item {
            display: flex;
            gap: 15px;
            margin-bottom: 1.2rem;
            align-items: center;
        }

        .recent-post-item:last-child {
            margin-bottom: 0;
        }

        .rp-thumb {
            width: 70px;
            height: 70px;
            border-radius: 10px;
            object-fit: cover;
            flex-shrink: 0;
        }

        .rp-info h5 {
            font-size: 0.95rem;
            margin: 0 0 5px;
            line-height: 1.3;
        }

        .rp-info h5 a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
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

        .active-cat {
            color: var(--primary) !important;
            font-weight: 700 !important;
            background: #f1f5f9 !important;
            border-left: 3px solid var(--accent);
        }

        /* --- 2. STYLE KHUSUS KOMENTAR & DROPDOWN --- */
        .comments-section {
            margin-top: 4rem;
        }

        .comments-title {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--accent);
            display: inline-block;
            color: var(--primary);
            font-weight: 700;
        }

        /* Layout Item Komentar - PENTING: Overflow Visible */
        .comment-item {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            border-bottom: 1px dashed #e2e8f0;
            padding-bottom: 2rem;
            position: relative;
            overflow: visible !important;
            /* Agar dropdown tidak terpotong */
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            flex-shrink: 0;
        }

        .comment-content {
            flex: 1;
            position: relative;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 5px;
        }

        .comment-author h5 {
            font-size: 1rem;
            margin: 0;
            color: var(--primary);
            font-weight: 700;
        }

        .comment-date {
            font-size: 0.8rem;
            color: #94a3b8;
            display: block;
        }

        .comment-text {
            color: #475569;
            line-height: 1.6;
            margin: 0;
        }

        /* Tombol Titik Tiga */
        .comment-actions {
            position: relative;
            display: inline-block;
        }

        .btn-more {
            background: transparent;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 5px;
            border-radius: 50%;
            transition: 0.3s;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-more:hover {
            background: #f1f5f9;
            color: var(--primary);
        }

        /* Dropdown Menu - Menggunakan Class Unik (.comment-dropdown) BUKAN .dropdown-item */
        .comment-dropdown-menu {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            width: 140px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
            z-index: 100;
            /* Lebih tinggi dari elemen biasa */
            overflow: hidden;
        }

        .comment-dropdown-menu.active {
            display: block !important;
        }

        .comment-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 15px;
            text-align: left;
            background: #fff;
            border: none;
            cursor: pointer;
            font-size: 0.85rem;
            color: #64748b;
            transition: 0.2s;
            text-decoration: none;
        }

        .comment-dropdown-item:hover {
            background: #f8fafc;
            color: var(--primary);
        }

        .comment-dropdown-item.text-red {
            color: #ef4444;
        }

        .comment-dropdown-item.text-red:hover {
            background: #fef2f2;
        }

        /* Form Edit Inline */
        .edit-form-container {
            display: none;
            margin-top: 10px;
        }

        .edit-form-container.active {
            display: block !important;
        }

        .comment-form {
            background: #f8fafc;
            padding: 2rem;
            border-radius: 15px;
            margin-bottom: 3rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary);
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            outline: none;
            transition: 0.3s;
            font-family: inherit;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(212, 175, 55, 0.1);
        }

        .btn-submit {
            background: var(--primary);
            color: var(--white);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: var(--accent);
            color: var(--primary);
        }

        .btn-login-comment {
            display: inline-block;
            background: var(--primary);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 0.8rem;
            cursor: pointer;
            margin-right: 5px;
        }

        .btn-save {
            background: var(--primary);
            color: #fff;
            border: none;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 0.8rem;
            cursor: pointer;
        }

        @media (max-width: 1024px) {
            .blog-wrapper {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                margin-top: 3rem;
            }

            .article-header {
                padding: 120px 5% 60px;
            }

            .article-header h1 {
                font-size: 2rem;
            }
        }
    </style>
@endpush

@push('meta')
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->description), 150) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image"
        content="{{ $post->thumbnail ? asset($post->thumbnail) : asset('images/default-thumbnail.jpg') }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->description), 150) }}">
    <meta name="twitter:image"
        content="{{ $post->thumbnail ? asset($post->thumbnail) : asset('images/default-thumbnail.jpg') }}">
@endpush

@section('content')
    <header class="article-header">
        <div class="article-breadcrumb">
            <a href="{{ route('home') }}">Home</a> <i class="ri-arrow-right-s-line"></i>
            <a href="{{ route('blog.index') }}">Blog</a> <i class="ri-arrow-right-s-line"></i>
            <span>{{ Str::limit($post->title, 20) }}</span>
        </div>
        <h1>{{ $post->title }}</h1>
        <div class="article-meta-header">
            <span><i class="ri-user-line"></i> {{ $post->user->name }}</span>
            <div class="meta-divider"></div>
            <span><i class="ri-calendar-line"></i> {{ $post->created_at->format('d M Y') }}</span>
            <div class="meta-divider"></div>
            <span><i class="ri-folder-line"></i>
                {{ $post->categories->isNotEmpty() ? $post->categories->first()->name : 'General' }}
            </span>
        </div>
    </header>

    <section class="blog-container">
        <div class="blog-wrapper">

            <div class="blog-main">
                <div class="blog-detail-content">

                    @if ($post->thumbnail)
                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="featured-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1558346490-a72e53ae2d4f?auto=format&fit=crop&w=1200&q=80"
                            alt="Default" class="featured-image">
                    @endif

                    <div class="article-body">
                        {!! $post->description !!}
                    </div>

                    <div class="article-footer">
                        <div class="tags">
                            @foreach ($post->categories as $category)
                                <a href="{{ route('blog.index', ['category' => $category->slug]) }}"
                                    class="tag-item">#{{ $category->name }}</a>
                            @endforeach
                        </div>
                        <div class="share-buttons">
                            <span class="share-label">Share:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                target="_blank" class="share-btn"><i class="ri-facebook-fill"></i></a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}"
                                target="_blank" class="share-btn"><i class="ri-twitter-x-fill"></i></a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                                target="_blank" class="share-btn"><i class="ri-whatsapp-line"></i></a>
                        </div>
                    </div>

                    <div class="author-box">
                        @php
                            $userPhoto = null;
                            if ($post->user->profile && $post->user->profile->photo) {
                                $userPhoto = asset('uploads/profiles/' . $post->user->profile->photo);
                            } else {
                                $userPhoto =
                                    'https://ui-avatars.com/api/?name=' .
                                    urlencode($post->user->name) .
                                    '&background=0F204B&color=D4AF37';
                            }
                        @endphp

                        <img src="{{ $userPhoto }}" alt="Author" class="author-img">
                        <div class="author-info">
                            <h4>{{ $post->user->name }}</h4>
                            <span>Penulis Konten</span>
                            <p>Artikel ini ditulis oleh anggota aktif ISC.</p>
                        </div>
                    </div>

                    <div class="post-navigation">
                        @if ($prevPost)
                            <a href="{{ route('blog.show', $prevPost->slug) }}" class="nav-card">
                                <span class="nav-label"><i class="ri-arrow-left-line"></i> Sebelumnya</span>
                                <h5 class="nav-title">{{ Str::limit($prevPost->title, 40) }}</h5>
                            </a>
                        @else
                            <div class="nav-card disabled">
                                <span class="nav-label"><i class="ri-arrow-left-line"></i> Sebelumnya</span>
                                <h5 class="nav-title">-</h5>
                            </div>
                        @endif

                        @if ($nextPost)
                            <a href="{{ route('blog.show', $nextPost->slug) }}" class="nav-card"
                                style="text-align: right;">
                                <span class="nav-label">Selanjutnya <i class="ri-arrow-right-line"></i></span>
                                <h5 class="nav-title">{{ Str::limit($nextPost->title, 40) }}</h5>
                            </a>
                        @else
                            <div class="nav-card disabled" style="text-align: right;">
                                <span class="nav-label">Selanjutnya <i class="ri-arrow-right-line"></i></span>
                                <h5 class="nav-title">-</h5>
                            </div>
                        @endif
                    </div>

                    <div class="comments-section" id="comments">
                        <h3 class="comments-title">{{ $post->comments->count() }} Komentar</h3>

                        @if (session('success'))
                            <div
                                class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="comment-list">
                            @forelse($post->comments as $comment)
                                <div class="comment-item" id="comment-{{ $comment->id }}">

                                    <img src="{{ $comment->user->profile && $comment->user->profile->photo ? asset('uploads/profiles/' . $comment->user->profile->photo) : 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=random' }}"
                                        alt="User" class="comment-avatar">

                                    <div class="comment-content">
                                        <div class="comment-header">
                                            <div class="comment-author">
                                                <h5>{{ $comment->user->name }}</h5>
                                                <span
                                                    class="comment-date">{{ $comment->created_at->diffForHumans() }}</span>
                                            </div>

                                            @if (Auth::id() === $comment->user_id)
                                                <div class="comment-actions">
                                                    <button type="button" class="btn-more"
                                                        onclick="toggleCmtMenu({{ $comment->id }}, event)">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>

                                                    <div id="cmt-menu-{{ $comment->id }}" class="comment-dropdown-menu">
                                                        <button type="button"
                                                            onclick="enableCmtEdit({{ $comment->id }})"
                                                            class="comment-dropdown-item">
                                                            <i class="ri-pencil-line"></i> Edit
                                                        </button>

                                                        <form action="{{ route('comments.destroy', $comment->id) }}"
                                                            method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="comment-dropdown-item text-red">
                                                                <i class="ri-delete-bin-line"></i> Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <p id="comment-body-{{ $comment->id }}" class="comment-text">
                                            {{ $comment->body }}
                                        </p>

                                        @if (Auth::id() === $comment->user_id)
                                            <div id="edit-form-{{ $comment->id }}" class="edit-form-container">
                                                <form action="{{ route('comments.update', $comment->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <textarea name="body" class="form-control" rows="3" required>{{ $comment->body }}</textarea>
                                                    <div style="margin-top: 10px; text-align: right;">
                                                        <button type="button" class="btn-cancel"
                                                            onclick="cancelCmtEdit({{ $comment->id }})">Batal</button>
                                                        <button type="submit" class="btn-save">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="text-center py-6 bg-gray-50 rounded-lg border border-dashed border-gray-300 mb-6">
                                    <p class="text-gray-500 italic">Belum ada komentar. Jadilah yang pertama berkomentar!
                                    </p>
                                </div>
                            @endforelse
                        </div>

                        <div class="comment-form">
                            <h4 style="margin-bottom: 1.5rem; color: var(--primary);">Tinggalkan Komentar</h4>
                            @auth
                                <form action="{{ route('posts.comment', $post->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Komentar Anda</label>
                                        <textarea name="body" class="form-control" rows="5" placeholder="Tulis komentar..." required></textarea>
                                    </div>
                                    <button type="submit" class="btn-submit">Kirim Komentar</button>
                                </form>
                            @else
                                <div class="text-center py-4 bg-white rounded border border-gray-200">
                                    <p class="mb-3 text-gray-600">Silakan login untuk ikut berdiskusi.</p>
                                    <a href="{{ route('login') }}" class="btn-login-comment">Login Sekarang</a>
                                </div>
                            @endauth
                        </div>
                    </div>

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
                        @forelse($popularCategories as $cat)
                            <li>
                                <a href="{{ route('blog.index', ['category' => $cat->slug]) }}">
                                    {{ $cat->name }}
                                    <span class="cat-count">{{ $cat->posts_count }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 italic">Belum ada kategori.</li>
                        @endforelse
                    </ul>
                </div>
            </aside>
        </div>
    </section>
@endsection

<script>
    /** 1. Toggle Comment Menu */
    function toggleCmtMenu(id, event) {
        if (event) event.stopPropagation();

        // Tutup semua menu komentar lain
        document.querySelectorAll('.comment-dropdown-menu').forEach(el => {
            if (el.id !== 'cmt-menu-' + id) el.classList.remove('active');
        });

        // Toggle menu ini
        const menu = document.getElementById('cmt-menu-' + id);
        if (menu) menu.classList.toggle('active');
    }

    /** 2. Enable Edit Comment */
    function enableCmtEdit(id) {
        // Hide Text
        const textBody = document.getElementById('comment-body-' + id);
        if (textBody) textBody.style.display = 'none';

        // Show Form
        const editForm = document.getElementById('edit-form-' + id);
        if (editForm) editForm.classList.add('active');

        // Hide Menu
        const menu = document.getElementById('cmt-menu-' + id);
        if (menu) menu.classList.remove('active');
    }

    /** 3. Cancel Edit Comment */
    function cancelCmtEdit(id) {
        // Show Text
        const textBody = document.getElementById('comment-body-' + id);
        if (textBody) textBody.style.display = 'block';

        // Hide Form
        const editForm = document.getElementById('edit-form-' + id);
        if (editForm) editForm.classList.remove('active');
    }

    /** 4. Click Outside (Khusus Comment Dropdown) */
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.btn-more')) {
            document.querySelectorAll('.comment-dropdown-menu').forEach(el => {
                el.classList.remove('active');
            });
        }
    });
</script>
