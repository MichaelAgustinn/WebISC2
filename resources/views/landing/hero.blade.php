<!-- Hero Section -->
<section id="hero" class="hero section">

    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center text-center text-lg-start">

                {{-- ? ini judul --}}
                <h1 data-aos="fade-up">{{ $hero->title }}</h1>

                {{-- ? ini deskripsi --}}
                <p data-aos="fade-up" data-aos-delay="100">{{ $hero->description }}</p>
            </div>

            <div class="col-lg-6 order-1 order-lg-2 hero-img" style="background-color: transparent;" data-aos="zoom-out">
                <img src="{{ asset($hero->image) }}" class="img-fluid animated" alt="Hero Image">
            </div>

        </div>
    </div>

</section><!-- /Hero Section -->
