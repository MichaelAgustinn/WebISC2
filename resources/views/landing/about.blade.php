<section id="about">
    <div class="section-header">
        <h2>Tentang Kami</h2>
        <div class="line"></div>
    </div>

    <div class="about-container">
        <div class="about-img-wrapper">
            @if (!empty($data['about_image']))
                <img src="{{ asset('uploads/landing/' . $data['about_image']) }}" alt="About Image">
            @else
                <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop"
                    alt="Team working">
            @endif
        </div>

        <div class="about-text">
            <h3>{{ $data['about_title'] ?? 'Tentang Kami' }}</h3>

            <p>
                {!! nl2br(e($data['about_description'] ?? 'Deskripsi belum diisi.')) !!}
            </p>

        </div>
    </div>
</section>
