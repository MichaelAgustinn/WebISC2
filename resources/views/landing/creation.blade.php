<section id="creation">
    <div class="section-header">
        <h2>Karya Terbaru</h2>
        <div class="line"></div>
    </div>

    <div class="filter-menu">
        <button class="filter-btn active" data-filter="all">All</button>
        <button class="filter-btn" data-filter="mobile">Mobile</button>
        <button class="filter-btn" data-filter="website">Website</button>
        <button class="filter-btn" data-filter="iot">IoT</button>
        <button class="filter-btn" data-filter="sc">Sistem Cerdas</button>
        <button class="filter-btn" data-filter="uiux">UI/UX</button>
    </div>

    <div class="creation-grid">
        @forelse($recentProjects as $project)
            @php
                // Mapping divisi DB ke filter HTML (data-category)
                $categoryMap = [
                    'mobile' => 'mobile',
                    'website' => 'website',
                    'iot' => 'iot',
                    'uiux' => 'uiux',
                    'sistem_cerdas' => 'sc', // Konversi khusus
                ];
                $dataCategory = $categoryMap[$project->division] ?? 'other';
            @endphp

            <div class="creation-card" data-category="{{ $dataCategory }}">
                <div class="card-img">
                    <a href="{{ route('landing.creation.detail', $project->slug) }}">
                        @if ($project->image)
                            <img src="{{ asset('uploads/projects/' . $project->image) }}" alt="{{ $project->title }}">
                        @else
                            <div
                                style="height: 220px; background: #eee; display: flex; align-items: center; justify-content: center; color: #aaa;">
                                No Image
                            </div>
                        @endif
                    </a>
                </div>
                <div class="card-content">
                    <span class="card-tag">{{ ucwords(str_replace('_', ' ', $project->division)) }}</span>
                    <h3 class="card-title">
                        <a href="{{ route('landing.creation.detail', $project->slug) }}">{{ $project->title }}</a>
                    </h3>
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; text-align: center; color: #888; padding: 2rem;">
                <p>Belum ada karya yang ditampilkan.</p>
            </div>
        @endforelse
    </div>

    <div style="text-align: center; margin-top: 3rem;">
        <a href="{{ route('landing.creation') }}" class="filter-btn"
            style="border: 1px solid var(--primary); display: inline-block; text-decoration: none; padding: 10px 25px;">
            Lihat Semua Karya <i class="ri-arrow-right-line" style="vertical-align: middle;"></i>
        </a>
    </div>
</section>
