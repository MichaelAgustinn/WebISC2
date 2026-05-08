<section id="visi-misi">
    <div class="section-header">
        <h2 style="color: var(--white);">Visi & Misi</h2>
        <div class="line" style="background: var(--accent);"></div>
    </div>

    <div class="vm-container">
        <div class="vm-card">
            <i class="ri-eye-2-line vm-icon"></i>
            <h3>Visi</h3>
            <p style="text-align: justify">
                {!! nl2br(e($data['visi'] ?? 'Visi belum diatur.')) !!}
            </p>
        </div>

        <div class="vm-card">
            <i class="ri-rocket-line vm-icon"></i>
            <h3>Misi</h3>

            @php
                $misiText = $data['misi'] ?? 'Misi belum diatur.';
                $misiLines = array_filter(array_map('trim', explode("\n", $misiText)));
            @endphp

            @if (count($misiLines) > 0)
                <div style="text-align: justify; margin-top: 15px; display: flex; flex-direction: column; gap: 10px;">
                    @foreach ($misiLines as $line)
                        <div style="display: flex; align-items: flex-start; gap: 8px;">
                            <span style="color: var(--accent); font-size: 1.2rem; line-height: 1.2;">&bull;</span>
                            <span style="line-height: 1.5; color: inherit;">{{ $line }}</span>
                        </div>
                    @endforeach
                </div>
            @else
                <p>Misi belum diatur.</p>
            @endif
        </div>
    </div>
</section>
