@extends('landing.master')

@section('title', 'All Blogs')

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
                        <li class="current">Blog</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <div class="container">
            <div class="row">

                <div class="col-lg-8">

                    <!-- Blog Posts Section -->
                    <section id="blog-posts" class="blog-posts section">

                        <div class="container">

                            <div class="row gy-4">

                                @foreach ($blogs as $blog)
                                    <div class="col-12">
                                        <article>

                                            <div class="post-img text-center">
                                                <img src="{{ asset($blog->first_image) }}" class="img-fluid mx-auto d-block"
                                                    alt="">
                                            </div>

                                            <h2 class="title">
                                                <a href="blog-details.html">{{ $blog->title }}</a>
                                            </h2>

                                            <div class="meta-top">
                                                <ul>
                                                    <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                                                            href="blog-details.html">{{ $blog->user->name }}</a></li>
                                                    <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a
                                                            href="blog-details.html"><time
                                                                datetime="2022-01-01">{{ $blog->created_at->format('M j, Y') }}</time></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="content">
                                                <p>
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($blog->content), 100) }}
                                                </p>

                                                <div class="d-flex justify-content-end gap-2">
                                                    @if ((Auth::user() && Auth::user()->role == 'Admin') || (Auth::user() && Auth::user()->role == 'Pengurus'))
                                                        <div
                                                            class="
                                                    btn btn-danger">
                                                            <a style="color: rgb(255, 255, 255)"
                                                                onclick="return confirm('Yakin Ingin Menghapus?')"
                                                                href="{{ route('blog.delete', $blog->id) }}">Hapus</a>
                                                        </div>
                                                        <div
                                                            class="
                                                    btn btn-warning">
                                                            <a style="color: black"
                                                                href="{{ route('blog.edit', $blog->slug) }}">Edit</a>
                                                        </div>
                                                    @endif

                                                    <div class="read-more">
                                                        <a href="{{ route('blog.landing', $blog->slug) }}">Read More</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </article>
                                    </div><!-- End post list item -->
                                @endforeach


                            </div><!-- End blog posts list -->

                        </div>

                    </section><!-- /Blog Posts Section -->

                    <!-- Blog Pagination Section -->
                    <section id="blog-pagination" class="blog-pagination section">

                        <div class="container">
                            <div class="d-flex justify-content-center">
                                <ul>
                                    {{-- Tombol Previous --}}
                                    @if ($blogs->onFirstPage())
                                        <li><a href="#"><i class="bi bi-chevron-left"></i></a></li>
                                    @else
                                        <li><a href="{{ $blogs->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a>
                                        </li>
                                    @endif

                                    {{-- Nomor halaman --}}
                                    @php
                                        $start = max($blogs->currentPage() - 1, 1);
                                        $end = min($blogs->currentPage() + 2, $blogs->lastPage());
                                    @endphp

                                    @for ($i = $start; $i <= $end; $i++)
                                        <li>
                                            <a href="{{ $blogs->url($i) }}"
                                                class="{{ $i == $blogs->currentPage() ? 'active' : '' }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Tampilkan "..." jika halaman belum sampai akhir --}}
                                    @if ($end < $blogs->lastPage() - 1)
                                        <li>...</li>
                                    @endif

                                    {{-- Tampilkan link ke halaman terakhir --}}
                                    @if ($end < $blogs->lastPage())
                                        <li><a href="{{ $blogs->url($blogs->lastPage()) }}">{{ $blogs->lastPage() }}</a>
                                        </li>
                                    @endif

                                    {{-- Tombol Next --}}
                                    @if ($blogs->hasMorePages())
                                        <li><a href="{{ $blogs->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a>
                                        </li>
                                    @else
                                        <li><a href="#"><i class="bi bi-chevron-right"></i></a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>


                    </section><!-- /Blog Pagination Section -->

                </div>

                <div class="col-lg-4 sidebar">

                    <div class="widgets-container">

                        <!-- Search Widget -->
                        <div class="search-widget widget-item">
                            <h3 class="widget-title">Search</h3>
                            <form onsubmit="return false;">
                                <input type="text" id="searchBlog" placeholder="Search...">
                                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
                            </form>
                        </div>
                        <div id="searchResults" class="recent-posts-widget widget-item"></div>

                        <!--/Search Widget -->

                        <!-- Categories Widget -->
                        <div class="categories-widget widget-item">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="mt-3">
                                @foreach ($categories as $category)
                                    <li>
                                        <a href="{{ route('blog.tag', $category->slug) }}">
                                            {{ $category->name }}
                                            <span>({{ $category->blogs_count }})</span>
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
                                        <h4><a href="{{ route('blog.landing', $blog->slug) }}">{{ $data->title }}</a>
                                        </h4>
                                        <time datetime="2020-01-01">{{ $blog->created_at->format('M j, Y') }}</time>
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
            const searchInput = document.getElementById('searchBlog');
            const searchResults = document.getElementById('searchResults');

            searchInput.addEventListener('keyup', function() {
                const query = this.value.trim();

                if (query.length < 2) {
                    searchResults.innerHTML = '';
                    return;
                }

                fetch(`{{ route('blog.search') }}?query=${encodeURIComponent(query)}`)
                    .then(res => res.json())
                    .then(data => {
                        let html = '';
                        if (data.length > 0) {
                            data.forEach(blog => {
                                html += `
                            <div class="post-item">
                                <img src="${blog.first_image}" style="width:50px;height:50px;object-fit:cover;border-radius:5px" alt="">
                                <div>
                                    <h4><a href="/blog/${blog.slug}">${blog.title}</a></h4>
                                    <time>${new Date(blog.created_at).toLocaleDateString()}</time>
                                </div>
                            </div>
                        `;
                            });
                        } else {
                            html = `<p style="padding:5px;">No results found.</p>`;
                        }

                        searchResults.innerHTML = `
                    <h3 class="widget-title">Search Results</h3>
                    ${html}
                `;
                    })
                    .catch(err => {
                        console.error(err);
                    });
            });
        });
    </script>
@endsection
