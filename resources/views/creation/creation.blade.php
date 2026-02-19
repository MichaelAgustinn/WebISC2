@extends('landing.master')

@section('content')
    <header class="blog-header">
        <h1>Karya & Inovasi</h1>
        <p>Galeri hasil karya anggota Informatics Study Club dalam mengembangkan solusi teknologi tepat guna.</p>
    </header>

    <section class="blog-container">
        <div class="blog-wrapper">

            <div class="blog-main">
                <div class="blog-list">

                    @forelse($projects as $project)
                        <article class="blog-card">
                            <div class="card-img">
                                <span class="category-tag">{{ ucwords(str_replace('_', ' ', $project->division)) }}</span>
                                <img src="{{ asset('uploads/projects/' . $project->image) }}" alt="{{ $project->title }}">
                            </div>
                            <div class="blog-content">
                                <div class="blog-meta">
                                    <span><i class="ri-calendar-line"></i> {{ $project->created_at->format('M Y') }}</span>
                                    <span><i class="ri-group-line"></i>
                                        {{ $project->users->count() > 0 ? $project->users->first()->name . ($project->users->count() > 1 ? ' & Team' : '') : 'ISC Member' }}
                                    </span>
                                </div>
                                <h3 class="blog-title">{{ $project->title }}</h3>
                                <p class="blog-desc">{{ Str::limit($project->description, 100, '...') }}</p>
                                <a href="{{ route('landing.creation.detail', $project->slug) }}" class="read-more">Lihat
                                    Detail <i class="ri-arrow-right-line"></i></a>
                            </div>
                        </article>
                    @empty
                        <div style="grid-column: 1/-1; text-align: center; padding: 3rem;">
                            <h3>Belum ada karya ditemukan.</h3>
                            <p>Coba kata kunci lain atau kembali nanti.</p>
                        </div>
                    @endforelse

                </div>

                <div class="pagination">
                    {{ $projects->withQueryString()->links('pagination::simple-default') }}
                </div>
            </div>

            <aside class="sidebar">

                <div class="sidebar-widget">
                    <h4 class="widget-title">Cari Karya</h4>
                    <form class="search-form" action="{{ route('landing.creation') }}" method="GET">
                        <input type="text" name="q" placeholder="Nama project..." value="{{ request('q') }}">
                        <button type="submit"><i class="ri-search-2-line"></i></button>
                    </form>
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Karya Terbaru</h4>

                    @foreach ($recentProjects as $recent)
                        <div class="recent-post-item">
                            <img src="{{ asset('uploads/projects/' . $recent->image) }}" alt="{{ $recent->title }}"
                                class="rp-thumb">
                            <div class="rp-info">
                                <h5><a
                                        href="{{ route('landing.creation.detail', $recent->slug) }}">{{ Str::limit($recent->title, 25) }}</a>
                                </h5>
                                <span class="rp-divisi"><i class="ri-price-tag-3-line"></i>
                                    {{ ucwords(str_replace('_', ' ', $recent->division)) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="sidebar-widget">
                    <h4 class="widget-title">Divisi</h4>
                    <ul class="category-list">
                        <li><a href="{{ route('landing.creation', ['category' => 'mobile']) }}">Mobile Apps <span
                                    class="cat-count">{{ $categories['mobile'] }}</span></a></li>
                        <li><a href="{{ route('landing.creation', ['category' => 'website']) }}">Website <span
                                    class="cat-count">{{ $categories['website'] }}</span></a></li>
                        <li><a href="{{ route('landing.creation', ['category' => 'uiux']) }}">UI/UX Design <span
                                    class="cat-count">{{ $categories['uiux'] }}</span></a></li>
                        <li><a href="{{ route('landing.creation', ['category' => 'iot']) }}">Internet of Things <span
                                    class="cat-count">{{ $categories['iot'] }}</span></a></li>
                        <li><a href="{{ route('landing.creation', ['category' => 'sistem_cerdas']) }}">Sistem Cerdas <span
                                    class="cat-count">{{ $categories['sistem_cerdas'] }}</span></a></li>
                    </ul>
                </div>

            </aside>
        </div>
    </section>
@endsection
