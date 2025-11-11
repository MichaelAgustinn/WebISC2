<!-- Stats Section -->
<section id="stats" class="stats section">

    <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

            <div class="col-lg-4 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-journal-richtext color-orange flex-shrink-0" style="color: #ee6c20;"></i>
                    <div>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $karya ?? '' }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Total Karya</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-4 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-people color-pink flex-shrink-0" style="color: #bb0852;"></i>
                    <div>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $anggota ?? '' }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Total Anggota Aktif</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

            <div class="col-lg-4 col-md-6">
                <div class="stats-item d-flex align-items-center w-100 h-100">
                    <i class="bi bi-headset color-green flex-shrink-0" style="color: #15be56;"></i>
                    <div>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $pengurus ?? '' }}"
                            data-purecounter-duration="1" class="purecounter"></span>
                        <p>Total Pengurus ISC</p>
                    </div>
                </div>
            </div><!-- End Stats Item -->

        </div>

    </div>

</section><!-- /Stats Section -->
