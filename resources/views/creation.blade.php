@extends('landing.master')

@section('title', 'All Creation')

@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="/">Home</a></li>
                        <li class="current">Creation</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <!-- creation Posts Section -->
                    <section id="blog-posts" class="blog-posts section">

                        <div class="container">

                            <div class="row gy-4">

                                @foreach ($creations as $creation)
                                    <div class="col-12">
                                        <article>

                                            <div class="post-img text-center">
                                                <img src="{{ asset($creation->first_image) }}"
                                                    class="img-fluid d-inline-block" alt="">
                                            </div>

                                            <h2 class="title">
                                                <a href="creation-details.html">{{ $creation->title }}</a>
                                            </h2>

                                            <div class="meta-top">
                                                <ul>
                                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                                            href="creation-details.html">{{ $creation->creator()->first()?->name ?? 'Unknown' }}</a>
                                                    </li>
                                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a
                                                            href="creation-details.html"><time
                                                                datetime="2022-01-01">{{ $creation->created_at->format('M j, Y') }}</time></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="content">
                                                <p>
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($creation->content), 100) }}
                                                </p>

                                                <div class="d-flex justify-content-end gap-2">
                                                    <div class="d-flex align-items-center gap-1 px-2">
                                                        <i class="fas fa-heart" style="font-size: 1.2rem; color: red;"></i>
                                                        <span>{{ $creation->likes->count() }}</span>
                                                    </div>
                                                    <div class="read-more text-center">
                                                        <a href="{{ route('creation.landing', $creation->slug) }}">
                                                            Lihat Detail Karya
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </article>
                                    </div><!-- End post list item -->
                                @endforeach


                            </div><!-- End creation posts list -->

                        </div>

                    </section><!-- /creation Posts Section -->

                    <!-- creation Pagination Section -->
                    <section id="blog-pagination" class="blog-pagination section">

                        <div class="container">
                            <div class="d-flex justify-content-center">
                                <ul>
                                    {{-- Tombol Previous --}}
                                    @if ($creations->onFirstPage())
                                        <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $creations->previousPageUrl() }}"><i
                                                    class="bi bi-chevron-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Nomor halaman --}}
                                    @php
                                        $start = max($creations->currentPage() - 1, 1);
                                        $end = min($creations->currentPage() + 2, $creations->lastPage());
                                    @endphp

                                    @for ($i = $start; $i <= $end; $i++)
                                        <li>
                                            <a href="{{ $creations->url($i) }}"
                                                class="{{ $i == $creations->currentPage() ? 'active' : '' }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Tampilkan "..." jika halaman belum sampai akhir --}}
                                    @if ($end < $creations->lastPage() - 1)
                                        <li>...</li>
                                    @endif

                                    {{-- Tampilkan link ke halaman terakhir --}}
                                    @if ($end < $creations->lastPage())
                                        <li><a
                                                href="{{ $creations->url($creations->lastPage()) }}">{{ $creations->lastPage() }}</a>
                                        </li>
                                    @endif

                                    {{-- Tombol Next --}}
                                    @if ($creations->hasMorePages())
                                        <li><a href="{{ $creations->nextPageUrl() }}"><i
                                                    class="bi bi-chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>


                    </section><!-- /creation Pagination Section -->

                </div>

                <div class="col-lg-4 sidebar">

                    <div class="widgets-container">

                        <!-- Search Widget -->
                        <div class="search-widget widget-item">
                            <h3 class="widget-title">Search</h3>
                            <form onsubmit="return false;">
                                <input type="text" id="searchCreation" placeholder="Search...">
                                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                            </form>
                        </div>
                        <div id="searchResults" class="recent-posts-widget widget-item"></div>

                        <!--/Search Widget -->

                        <!-- Categories Widget -->
                        <div class="categories-widget widget-item">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="mt-3">
                                @foreach ($divisis as $divisi)
                                    <li>
                                        <a href="{{ route('creation.divisi', ['divisi' => Str::slug($divisi->divisi)]) }}">
                                            {{ $divisi->divisi }}
                                            <span>({{ $divisi->total }})</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>


                        <!-- Recent Posts Widget -->
                        <div class="recent-posts-widget widget-item">

                            <h3 class="widget-title">Recent Posts</h3>

                            @foreach ($recent as $data)
                                <div class="post-item">
                                    <img src="{{ asset($data->first_image) }}" class="flex-shrink-0" alt=""
                                        style="max-width: 50px; max-height: 50px; object-fit: cover;">

                                    <div>
                                        <h4><a href="{{ route('creation.landing', $data->slug) }}">{{ $data->title }}</a>
                                        </h4>
                                        <time datetime="2020-01-01">{{ $data->created_at->format('M j, Y') }}</time>
                                    </div>
                                </div><!-- End recent post item-->
                            @endforeach

                        </div><!--/Recent Posts Widget -->

                    </div>

                </div>

            </div>
        </div>

    </main>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("searchCreation");
            const searchResults = document.getElementById("searchResults");

            if (!searchInput || !searchResults) return;

            searchInput.addEventListener("keyup", function() {
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.innerHTML = "";
                    return;
                }

                fetch(`{{ route('creation.search') }}?query=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        let html = "<h3 class='widget-title'>Search Results</h3>";

                        if (data.length === 0) {
                            html += `<p>No results found.</p>`;
                        } else {
                            data.forEach(item => {
                                html += `
                            <div class="post-item">
                                <img src="${item.first_image}" 
                                     style="width:50px;height:50px;object-fit:cover;border-radius:5px" alt="">
                                <div>
                                    <h4><a href="/creation/${item.slug}">${item.title}</a></h4>
                                    <small>By ${item.creator_name}</small><br>
                                    <time>${new Date(item.created_at).toLocaleDateString()}</time>
                                </div>
                            </div>`;
                            });
                        }

                        searchResults.innerHTML = html;
                    })
                    .catch(err => {
                        console.error("Search error:", err);
                        searchResults.innerHTML = "<p style='color:red;'>Search failed.</p>";
                    });
            });
        });
    </script>


@endsection
