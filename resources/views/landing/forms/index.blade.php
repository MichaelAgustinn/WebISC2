@extends('landing.master')

@section('content')
    <header class="blog-header">
        <h1>Formulir & Pendaftaran</h1>
        <p>Temukan berbagai formulir pendaftaran kegiatan, event, dan pendataan anggota Informatics Study Club.</p>
    </header>

    <section class="blog-container">
        <div class="blog-wrapper">

            <div class="blog-main">
                <div class="blog-list">

                    @forelse($forms as $form)
                        <article class="blog-card">
                            <div class="card-img">
                                <span class="category-tag">Formulir</span>

                                @if ($form->cover_image)
                                    <img src="{{ asset($form->cover_image) }}" alt="{{ $form->title }}">
                                @else
                                    <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=500&q=80"
                                        alt="Default Form Cover">
                                @endif
                            </div>

                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="ri-calendar-line"></i> {{ $form->created_at->format('d M Y') }}</span>
                                    <span><i class="ri-list-check"></i> {{ $form->fields_count ?? 0 }} Pertanyaan</span>
                                </div>

                                <h3 class="blog-title">{{ $form->title }}</h3>
                                <p class="blog-desc">{{ Str::limit($form->description, 100, '...') }}</p>

                                <a href="{{ route('landing.forms.show', $form->slug) }}" class="read-more">
                                    Isi Formulir <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </article>
                    @empty
                        <div
                            style="grid-column: 1/-1; text-align: center; padding: 3rem; background: #fff; border-radius: 15px; border: 1px dashed #ccc;">
                            <h3 style="color: var(--primary); margin-bottom: 10px;">Belum ada formulir tersedia.</h3>
                            <p style="color: #666;">Coba gunakan kata kunci pencarian yang lain atau kembali lagi nanti.</p>
                        </div>
                    @endforelse

                </div>

                <div class="pagination mt-5">
                    {{ $forms->withQueryString()->links('pagination::simple-default') }}
                </div>
            </div>

            <aside class="sidebar">

                <div class="sidebar-widget">
                    <h4 class="widget-title">Cari Formulir</h4>
                    <form class="search-form" action="{{ route('landing.forms.index') }}" method="GET">
                        <input type="text" name="search" placeholder="Ketik judul formulir..."
                            value="{{ request('search') }}">
                        <button type="submit"><i class="ri-search-2-line"></i></button>
                    </form>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Formulir Terbaru</h4>

                    @forelse ($recentForms as $recent)
                        <div class="recent-post-item">
                            @if ($recent->cover_image)
                                <img src="{{ asset($recent->cover_image) }}" alt="{{ $recent->title }}" class="rp-thumb">
                            @else
                                <img src="https://images.unsplash.com/photo-1554224155-8d04cb21cd6c?auto=format&fit=crop&w=150&q=80"
                                    alt="Thumb" class="rp-thumb">
                            @endif

                            <div class="rp-info">
                                <h5>
                                    <a
                                        href="{{ route('landing.forms.show', $recent->id) }}">{{ Str::limit($recent->title, 30) }}</a>
                                </h5>
                                <span class="rp-divisi"><i class="ri-time-line"></i>
                                    {{ $recent->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @empty
                        <p style="font-size: 0.9rem; color: #666; text-align: center;">Belum ada formulir.</p>
                    @endforelse
                </div>

            </aside>
        </div>
    </section>
@endsection
