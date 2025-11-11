<!-- Testimonials Section -->
<section id="testimonials" class="testimonials section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Testimonials</h2>
        <p>What they are saying about us<br></p>
    </div><!-- End Section Title -->

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              },
              "breakpoints": {
                "320": {
                  "slidesPerView": 1,
                  "spaceBetween": 40
                },
                "1200": {
                  "slidesPerView": 3,
                  "spaceBetween": 1
                }
              }
            }
          </script>
            <div class="swiper-wrapper">

                @foreach ($testimonials as $testimonial)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="stars">
                                @for ($i = 0; $i < $testimonial->rating; $i++)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @endfor
                            </div>
                            <p>
                                {{ $testimonial->message }}
                            </p>
                            <div class="profile mt-auto">
                                {{-- @dd($testimonial->user->profile->foto) --}}
                                <img src="{{ asset($testimonial->user->profile->image) }}" class="testimonial-img"
                                    alt="">
                                {{-- <img src="{{ asset('landingpages') }}/assets/img/testimonials/testimonials-1.jpg"
                                    class="testimonial-img" alt=""> --}}
                                <h3>{{ $testimonial->user->name }}</h3>
                                <h4>{{ $testimonial->user->profile->jabatan }}</h4>
                            </div>
                        </div>
                    </div><!-- End testimonial item -->
                @endforeach

            </div>
            <div class="swiper-pagination"></div>
        </div>

    </div>

</section><!-- /Testimonials Section -->
