<footer>
    <div class="footer-container">
        <div class="footer-col">
            <h3>Contact Us</h3>
            <ul class="contact-info">
                <li>
                    <i class="ri-map-pin-line"></i>
                    {{ $data['contact_address'] ?? 'Alamat belum diisi' }}
                </li>
                <li>
                    <i class="ri-mail-line"></i>
                    {{ $data['contact_email'] ?? 'email@contoh.com' }}
                </li>
                <li>
                    <i class="ri-phone-line"></i>
                    {{ $data['contact_phone'] ?? '-' }}
                </li>

            </ul>
        </div>

        <div class="footer-col">
            <h3>Go to</h3>
            @if (request()->routeIs('home'))
                <div class="footer-nav">
                    <a href="#home">Home</a>
                    <a href="#about">About</a>
                    <a href="">Creation</a>
                    <a href="#team">Team</a>
                    <a href="">Blog</a>
                </div>
            @else
                <div class="footer-nav">
                    <a href="/#home">Home</a>
                    <a href="/#about">About</a>
                    <a href="">Creation</a>
                    <a href="/#team">Team</a>
                    <a href="">Blog</a>
                </div>
            @endif
        </div>

        <div class="footer-col">
            <h3>Social media</h3>
            <p style="color: #cbd5e1; margin-bottom: 1rem;">
                Dapatkan update terbaru kegiatan kami di sosial media.
            </p>
            <div class="social-links">
                @if (!empty($data['social_instagram']))
                    <a href="{{ $data['social_instagram'] }}" target="_blank"><i class="ri-instagram-line"></i></a>
                @endif

                @if (!empty($data['social_facebook']))
                    <a href="{{ $data['social_facebook'] }}" target="_blank"><i class="ri-facebook-fill"></i></a>
                @endif

                @if (!empty($data['social_youtube']))
                    <a href="{{ $data['social_youtube'] }}" target="_blank"><i class="ri-youtube-fill"></i></a>
                @endif

                @if (!empty($data['social_tiktok']))
                    <a href="{{ $data['social_tiktok'] }}" target="_blank"><i class="ri-tiktok-fill"></i></a>
                @endif
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Informatics Study Club. All rights reserved.</p>
    </div>
</footer>
