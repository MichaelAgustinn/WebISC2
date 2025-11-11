  <!-- About Section -->
  <section id="about" class="about section">

      <div class="container" data-aos="fade-up">
          <div class="row gx-0">

              <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                  <div class="content">
                      <h3>About ISC</h3>

                      {{-- ? ini judul --}}
                      <h2>{{ $about->title }}
                      </h2>

                      {{-- ? ini paragraf --}}
                      <p style="text-align: justify">
                          {{ $about->description }}
                      </p>
                  </div>
              </div>

              <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
                  <img src="{{ asset($about->image) }}" class="img-fluid" alt="">
              </div>

          </div>
      </div>

  </section><!-- /About Section -->
