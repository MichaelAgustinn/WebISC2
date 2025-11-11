<section id="portfolio" class="portfolio section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Karya Anggota</h2>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">

            <ul class="portfolio-filters isotope-filters" data-aos="fade-up" data-aos-delay="100">
                <li data-filter="*" class="filter-active">Terbaru</li>
                <li data-filter=".filter-Mobile">Mobile</li>
                <li data-filter=".filter-Website">Website</li>
                <li data-filter=".filter-IoT">IoT</li>
                <li data-filter=".filter-UI-UX">UI/UX</li>
                <li data-filter=".filter-SistemCerdas">Sistem Cerdas</li>
                <a href="{{ route('creation.page') }}">
                    <li class="">Semua</li>
                </a>
            </ul><!-- End Portfolio Filters -->

            {{-- ? style untuk creation --}}
            <style>
                /* Pastikan wrapper menyesuaikan proporsi */
                .image-wrapper {
                    width: 100%;
                    height: 220px;
                    /* Sesuaikan tinggi sesuai desain */
                    overflow: hidden;
                    border-radius: 8px;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-color: #f5f5f5;
                }

                /* Gambar responsif penuh */
                .creation-image {
                    max-width: 100%;
                    max-height: 100%;
                    width: auto;
                    height: auto;
                    object-fit: cover;
                    display: block;
                }
            </style>
            {{-- ? style untuk creation end --}}

            <div class="row gy-4 isotope-container" data-aos="fade-up" data-aos-delay="200">
                @foreach ($creations as $creation)
                    @php
                        // Ambil gambar pertama dari konten
                        if (preg_match('/<img[^>]+src="([^">]+)"/', $creation->content, $matches)) {
                            $thumbnail = $matches[1];
                        } else {
                            $thumbnail = asset('images/no-image.png');
                        }
                    @endphp

                    <div
                        class="col-lg-4 col-md-6 portfolio-item isotope-item filter-{{ str_replace('/', '-', $creation->divisi) }}">
                        <div class="portfolio-content h-100">
                            <div class="image-wrapper">
                                <img src="{{ $thumbnail }}" alt="{{ $creation->title }}" class="creation-image">
                            </div>

                            <div class="portfolio-info">
                                <h4>{{ $creation->title }}</h4>
                                <p>{{ Str::limit(strip_tags($creation->content), 120) }}</p>

                                <a href="{{ $thumbnail }}" title="Judul Karya : {{ $creation->title }}"
                                    data-gallery="portfolio-gallery" class="glightbox preview-link">
                                    <i class="bi bi-zoom-in"></i>
                                </a>

                                <a href="{{ route('creation.landing', $creation->slug) }}" title="More Details"
                                    class="details-link">
                                    <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <!-- End Portfolio Container -->

        </div>

    </div>

</section>
