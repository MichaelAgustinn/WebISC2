<!-- Faq Section -->
<section id="faq" class="faq section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>F.A.Q</h2>
        <p>Frequently Asked Questions</p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row">
            @foreach ($faqs->chunk(ceil($faqs->count() / 2)) as $faqColumn)
                <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="faq-container">
                        @foreach ($faqColumn as $faq)
                            <div class="faq-item">
                                <h3>{{ $faq->question }}</h3>
                                <div class="faq-content">
                                    <p>{{ $faq->answered }}</p>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</section><!-- /Faq Section -->
