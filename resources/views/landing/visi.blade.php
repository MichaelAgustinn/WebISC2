<!-- Values Section -->
<section id="values" class="values section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Visi & Misi</h2>
        <p>Visi dan Misi Informatics Study Club<br></p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                <div class="card">
                    <img src="{{ asset($visi->image) }}" class="img-fluid" alt="">

                    {{-- ? visi (judul) --}}
                    <h3>{{ $visi->title }}</h3>

                    {{-- ? visi (deskripsi) --}}
                    <p>{{ $visi->description }}</p>

                </div>
            </div><!-- End Card Item -->

            <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">
                <div class="card">
                    <img src="{{ asset($misi->image) }}" class="img-fluid" alt="">

                    {{-- ? misi (judul) --}}
                    <h3>{{ $misi->title }}</h3>

                    {{-- ? misi (deskripsi) --}}
                    <p>{{ $misi->description }}</p>
                </div>
            </div><!-- End Card Item -->

        </div>

    </div>

</section><!-- /Values Section -->
