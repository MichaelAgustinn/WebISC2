<section id="team">
    <div class="section-header">
        <h2>Pengurus ISC</h2>
        <div class="line"></div>
    </div>

    <div class="team-container">
        @foreach ($teams as $team)
            <div class="team-card">
                <img src="{{ asset('uploads/team/' . $team->photo) }}" alt="{{ $team->name }}" class="team-photo">
                <h4 class="team-name">{{ $team->name }}</h4>
                <span class="team-role">{{ $team->role }}</span>
            </div>
        @endforeach

        @if ($teams->isEmpty())
            <p style="text-align:center; width:100%; color:gray;">Belum ada data pengurus.</p>
        @endif
    </div>
</section>
