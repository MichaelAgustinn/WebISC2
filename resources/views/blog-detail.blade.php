@extends('landing.master')

@section('title', 'Blog - ' . $blog->slug)

@section('content')
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('blog.page') }}">Blog</a></li>
                        <li class="current">{{ $blog->title }}</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <!-- Blog Details Section -->
                    <section id="blog-details" class="blog-details section">
                        <div class="container">
                            <article class="article">

                                {{-- Featured Image (optional, if using separate image column later) --}}
                                {{-- <div class="post-img">
                                <img src="{{ asset('storage/' . $data->image_path) }}" class="img-fluid" alt="">
                            </div> --}}

                                <h2 class="title">{{ $blog->title }}</h2>

                                <div class="meta-top">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                            <a href="#">{{ $blog->user->name ?? 'Unknown' }}</a>
                                        </li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i>
                                            <a href="#"><time
                                                    datetime="{{ $blog->created_at }}">{{ $blog->created_at->format('M d, Y') }}</time></a>
                                        </li>
                                    </ul>
                                </div><!-- End meta top -->

                                <div class="content">
                                    {!! $blog->content !!}
                                </div><!-- End post content -->

                                <div class="meta-bottom">
                                    {{-- Tags --}}
                                    <i class="bi bi-tags"></i>
                                    <ul class="tags">
                                        @foreach ($blog->tags as $tag)
                                            <li>
                                                <a href="{{ route('blog.tag', $tag->slug) }}">
                                                    {{ $tag->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div><!-- End meta bottom -->


                            </article>
                        </div>
                    </section><!-- /Blog Details Section -->

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
                                        <h4><a href="">{{ $data->title }}</a>
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
