<!-- Recent Posts Section -->
<section id="recent-posts" class="recent-posts section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Blog Terbaru</h2>
        <p>Postingan Blog Terbaru</p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-5">

            @foreach ($blogs as $blog)
                <div class="col-xl-4 col-md-6">
                    <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

                        <div class="post-img position-relative overflow-hidden">
                            <img src="{{ asset($blog->first_image) }}" class="img-fluid" alt="">
                            <span class="post-date"> {{ $blog->created_at->format('M j, Y') }} </span>
                        </div>

                        <div class="post-content d-flex flex-column">

                            <h3 class="post-title">{{ $blog->title }}</h3>

                            <div class="meta d-flex align-items-center">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-person"></i> <span class="ps-2">{{ $blog->user->name }}</span>
                                </div>

                            </div>

                            <hr>

                            <a href="{{ Route('blog.landing', $blog->slug) }}"
                                class="readmore stretched-link"><span>Read More</span><i
                                    class="bi bi-arrow-right"></i></a>

                        </div>

                    </div>
                </div><!-- End post item -->
            @endforeach


        </div>

    </div>

</section><!-- /Recent Posts Section -->
