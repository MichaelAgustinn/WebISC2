<section id="blog">
    <div class="section-header">
        <h2>Berita & Artikel</h2>
        <div class="line"></div>
    </div>

    <div class="blog-grid">
        @foreach ($posts as $post)
            <article class="blog-card">
                <div class="card-img">
                    @if ($post->thumbnail)
                        <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}">
                    @else
                        <img src="https://images.unsplash.com/photo-1499750310159-5b5f22138751?auto=format&fit=crop&w=500&q=80"
                            alt="Blog">
                    @endif
                </div>
                <div class="blog-date">{{ $post->created_at->format('d-m-Y') ?? '' }}</div>
                <div class="blog-content">
                    <h3 class="blog-title">{{ $post->title ?? '' }}</h3>
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 1rem;">
                        {{ \Illuminate\Support\Str::words($post->description, 10, '...') }}</p>
                    <a href="{{ route('blog.show', $post->slug) }}" class="read-more">Baca Selengkapnya <i
                            class="ri-arrow-right-line"></i></a>
                </div>
            </article>
        @endforeach
    </div>
    <div class="btn-view-all-wrapper">
        <a href="{{ route('blog.index') }}" class="btn-view-all">
            Lihat Semua Artikel
            <i class="ri-arrow-right-line"></i>
        </a>
    </div>
</section>
