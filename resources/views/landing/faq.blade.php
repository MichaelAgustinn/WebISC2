<section id="faq">
    <div class="section-header">
        <h2>F.A.Q</h2>
        <div class="line"></div>
    </div>
    <div class="faq-container">

        @foreach ($faqs as $faq)
            <div class="faq-item">
                <div class="faq-question">
                    {{ $faq->question }}
                    <i class="ri-arrow-down-s-line"></i>
                </div>
                <div class="faq-answer">
                    {{ $faq->answer }}
                </div>
            </div>
        @endforeach

    </div>
</section>
