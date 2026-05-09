<div class="row">

    @forelse ($members as $member)
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">

            <div class="card border-0 shadow-sm h-100 rounded-4 overflow-hidden">

                @if ($member->profile && $member->profile->photo)
                    <img src="{{ asset('uploads/profiles/' . $member->profile->photo) }}" class="card-img-top"
                        style="height: 250px; object-fit: cover;" alt="{{ $member->name }}">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($member->name) }}&background=0f204b&color=d4af37&size=500"
                        class="card-img-top" style="height: 250px; object-fit: cover;" alt="{{ $member->name }}">
                @endif

                <div class="card-body d-flex flex-column">

                    <h5 class="fw-bold mb-1">
                        {{ $member->name }}
                    </h5>

                    <p class="text-muted small mb-2">
                        {{ $member->profile->division ?? 'Anggota' }}
                    </p>

                    <p class="small text-secondary mb-3">
                        Angkatan:
                        {{ $member->profile->angkatan ?? '-' }}
                    </p>

                    <a href="{{ route('anggota.detail', $member->id) }}" class="btn btn-dark mt-auto rounded-pill">
                        Lihat Profil
                    </a>

                </div>

            </div>

        </div>

    @empty

        <div class="col-12 text-center">

            <h5 class="text-muted">
                Data anggota tidak ditemukan.
            </h5>

        </div>
    @endforelse

</div>

<div class="d-flex justify-content-center mt-4">

    {{ $members->links() }}

</div>
