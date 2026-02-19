<section id="home">
    <canvas id="smokeCanvas"></canvas>

    <div class="hero-watermark">ISC</div>

    <div class="hero-content">
        <h1 class="hero-title">
            {{ $data['home_title'] ?? 'Informatics Study Club' }}
        </h1>

        <p class="hero-subtitle">
            {!! nl2br(
                e(
                    $data['home_subtitle'] ??
                        'Satu-satunya wadah yang fokus untuk meningkatkan Skill Informatika di Universitas Sulawesi Barat',
                ),
            ) !!}
        </p>
    </div>
</section>
