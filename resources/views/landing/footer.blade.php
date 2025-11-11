<footer id="footer" class="footer">
    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="index.html" class="d-flex align-items-center">
                    <span class="sitename">Informatics Study Club</span>
                </a>
                <div class="footer-contact pt-3">
                    <p>Hubungi Kami:</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>{{ $footer->nomor_telepon }}</span></p>
                    <p><strong>Email:</strong> <span>{{ $footer->email }}</span></p>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Link Navigasi</h4>
                <ul>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#hero">Home</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#about">About us</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#portfolio">Creation</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="/#team">Team</a></li>
                    <li><i class="bi bi-chevron-right"></i> <a href="{{ route('blog.page') }}">Blog</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Karya Divisi</h4>
                <ul>
                    <li>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('creation.divisi', ['divisi' => 'website']) }}">Website</a>
                    </li>
                    <li>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('creation.divisi', ['divisi' => 'uiux']) }}">UI/UX</a>
                    </li>
                    <li>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('creation.divisi', ['divisi' => 'mobile']) }}">Mobile</a>
                    </li>
                    <li>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('creation.divisi', ['divisi' => 'sistemcerdas']) }}">Sistem Cerdas</a>
                    </li>
                    <li>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('creation.divisi', ['divisi' => 'iot']) }}">Internet of Things</a>
                    </li>
                </ul>

            </div>

            <div class="col-lg-4 col-md-12">
                <h4>Ikuti Kami</h4>
                <p>Unuk Info Terbaru Silahkan Iktui Sosial Media Kami</p>
                <div class="social-links d-flex">
                    <a href="{{ $footer->link_tiktok }}" target="_blank"><i class="bi bi-discord"></i></a>
                    <a href="{{ $footer->link_facebook }}" target="_blank"><i class="bi bi-youtube"></i></a>
                    <a href="{{ $footer->link_instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Informatics Study Club</strong> <span>All Rights
                Reserved</span></p>
    </div>

</footer>
