<!-- Team Section -->
<section id="team" class="team section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Pengurus ISC</h2>
        <p>Our Best Hardwork Team</p>
    </div><!-- End Section Title -->

    <div class="container">
        <div class="row gy-4 justify-content-center">

            @php
                $total = count($penguruses);
                $rows = [];

                if ($total <= 5) {
                    $rows = [$total];
                } elseif ($total == 6) {
                    $rows = [3, 3];
                } elseif ($total == 7) {
                    $rows = [4, 3];
                } elseif ($total == 8) {
                    $rows = [4, 4];
                } elseif ($total == 9) {
                    $rows = [4, 5];
                } elseif ($total == 10) {
                    $rows = [5, 5];
                } elseif ($total == 11) {
                    $rows = [4, 4, 3];
                } elseif ($total == 12) {
                    $rows = [4, 4, 4];
                } else {
                    $rows = [];
                    $pattern = [4, 4, 3];
                    $remaining = $total;
                    $patternIndex = 0;
                    while ($remaining > 0) {
                        $take = min($pattern[$patternIndex], $remaining);
                        $rows[] = $take;
                        $remaining -= $take;
                        $patternIndex = ($patternIndex + 1) % count($pattern);
                    }
                }

                $currentIndex = 0;
            @endphp

            @foreach ($rows as $rowCount)
                <div class="row justify-content-center mb-4">
                    @for ($i = 0; $i < $rowCount && $currentIndex < $total; $i++, $currentIndex++)
                        @php
                            $member = $penguruses[$currentIndex];
                            $delay = 100 + $currentIndex * 100;
                            $col = 12 / $rowCount;
                            $colClass = 'col-lg-' . (int) $col;
                        @endphp

                        <div class="{{ $colClass }} d-flex align-items-stretch justify-content-center"
                            data-aos="fade-up" data-aos-delay="{{ $delay }}">
                            <div class="team-member text-center">
                                <img src="{{ asset($member->image) }}" class="img-fluid rounded"
                                    alt="{{ $member->name }}" style="max-height: 300px; object-fit: cover;">
                                <div class="member-info mt-2">
                                    <h4>{{ $member->name }}</h4>
                                    <span>{{ $member->jabatan }}</span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            @endforeach

        </div>
    </div>




</section><!-- /Team Section -->
