<section id="visi-misi">
    <div class="section-header">
        <h2 style="color: var(--white);">Visi & Misi</h2>
        <div class="line" style="background: var(--accent);"></div>
    </div>

    <div class="vm-container">
        <div class="vm-card">
            <i class="ri-eye-2-line vm-icon"></i>
            <h3>Visi</h3>
            <p>
                {!! nl2br(e($data['visi'] ?? 'Visi belum diatur.')) !!}
            </p>
        </div>

        <div class="vm-card">
            <i class="ri-rocket-line vm-icon"></i>
            <h3>Misi</h3>
            <p>
                {!! nl2br(e($data['misi'] ?? 'Misi belum diatur.')) !!}
            </p>
        </div>
    </div>
</section>
