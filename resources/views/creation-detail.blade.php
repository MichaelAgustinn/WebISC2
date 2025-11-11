@extends('landing.master')

@section('title', 'Creation - ' . $creation->slug)

@section('content')
    <style>
        .btn-outline-danger:hover i {
            transform: scale(1.2);
            transition: transform 0.2s ease;
        }

        .btn-danger i {
            color: white;
        }
    </style>
    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <div class="heading">
            </div>
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route('creation.page') }}">Creation</a></li>
                        <li class="current">{{ $creation->title }}</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    <!-- creation Details Section -->
                    <section id="blog-details" class="blog-details section">
                        <div class="container">
                            <article class="article">

                                {{-- Featured Image (optional, if using separate image column later) --}}
                                {{-- <div class="post-img">
                                <img src="{{ asset('storage/' . $data->image_path) }}" class="img-fluid" alt="">
                            </div> --}}

                                <h2 class="title">{{ $creation->title }}</h2>

                                <div class="meta-top">
                                    <ul>
                                        <li class="d-flex align-items-center"><i class="bi bi-person"></i>
                                            <a href="#">{{ $creation->creator->first()->name }}</a>
                                        </li>
                                        <li class="d-flex align-items-center"><i class="bi bi-clock"></i>
                                            <a href="#"><time
                                                    datetime="{{ $creation->created_at }}">{{ $creation->created_at->format('M d, Y') }}</time></a>
                                        </li>
                                    </ul>
                                </div><!-- End meta top -->

                                <div class="content">
                                    {!! $creation->content !!}
                                </div><!-- End post content -->

                                <div class="meta-bottom d-flex justify-content-between align-items-center">
                                    {{-- Tags --}}
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-tags me-2"></i>
                                        <ul class="tags mb-0">
                                            @foreach ($creation->users as $user)
                                                <li class="d-inline me-2">
                                                    <a href="">{{ $user->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    <form action="{{ route('creation.like', $creation->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @php
                                            $liked = $creation->likes->contains(auth()->id());
                                        @endphp
                                        <button type="submit"
                                            class="btn btn-sm d-flex align-items-center gap-1  {{ $liked ? '' : '' }}"
                                            title="{{ $liked ? 'Batal menyukai' : 'Sukai karya ini' }}">
                                            <i class=" {{ $liked ? 'fas fa-heart' : 'far fa-heart' }}"
                                                style="font-size: 1.2rem; {{ $liked ? 'color: red;' : '' }}"></i>

                                            {{-- <i class="fa-solid fa-user"></i> --}}

                                            <span>{{ $creation->likes->count() }}</span>
                                        </button>

                                    </form>
                                </div>

                            </article>
                        </div>
                    </section><!-- /creation Details Section -->

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

                        <div class="categories-widget widget-item">
                            <h3 class="widget-title">Categories</h3>
                            <ul class="mt-3">
                                @foreach ($divisis as $divisi)
                                    <li>
                                        <a href="{{ route('creation.divisi', ['divisi' => Str::slug($divisi->divisi)]) }}">
                                            {{ $divisi->divisi }}
                                            <span>({{ $divisi->creations_count }})</span>
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
                                        <time datetime="2020-01-01">{{ $creation->created_at->format('M j, Y') }}</time>
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
