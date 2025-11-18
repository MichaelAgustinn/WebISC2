<!-- Pricing Section -->
<section id="pricing" class="pricing section">

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Event</h2>
        <p>Current Event<br></p>
    </div><!-- End Section Title -->

    <div class="container">

        <div class="row gy-4">

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <h3 style="color: #263fc8;">Divisi Mobile</h3>

                    <div class="icon">
                        <img src="{{ asset('storage/logo/logo_69059386f26cc.webp') }}" alt="Starter Icon"
                            style="width: 200px; height: auto;">
                    </div>

                    <ul>
                        <li>Pertemuan 1</li>
                        <li>Fakultas Teknik</li>
                        <li>16:00 - 17:00</li>
                    </ul>
                    <a href="#" class="btn-buy" onclick="openCameraModal()">Tandai Kehadiran</a>
                </div>
            </div>
            <!-- End Pricing Item -->

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <h3 style="color: #263fc8;">Divisi Website</h3>

                    <div class="icon">
                        <img src="{{ asset('storage/logo/logo_69058c1f5c989.webp') }}" alt="Starter Icon"
                            style="width: 200px; height: auto;">
                    </div>

                    <ul>
                        <li>Pertemuan 1</li>
                        <li>Fakultas Teknik</li>
                        <li>16:00 - 17:00</li>
                    </ul>
                    <a href="#" class="btn-buy" onclick="openCameraModal()">Tandai Kehadiran</a>
                </div>
            </div>
            <!-- End Pricing Item -->

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <h3 style="color: #263fc8;">Divisi IoT</h3>

                    <div class="icon">
                        <img src="{{ asset('storage/logo/logo_69058beacb841.webp') }}" alt="Starter Icon"
                            style="width: 200px; height: auto;">
                    </div>

                    <ul>
                        <li>Pertemuan 1</li>
                        <li>Fakultas Teknik</li>
                        <li>16:00 - 17:00</li>
                    </ul>
                    <a href="#" class="btn-buy" onclick="openCameraModal()">Tandai Kehadiran</a>
                </div>
            </div>
            <!-- End Pricing Item -->

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <h3 style="color: #263fc8;">Divisi UI/UX</h3>

                    <div class="icon">
                        <img src="{{ asset('storage/logo/logo_690593ab91eca.webp') }}" alt="Starter Icon"
                            style="width: 200px; height: auto;">
                    </div>

                    <ul>
                        <li>Pertemuan 1</li>
                        <li>Fakultas Teknik</li>
                        <li>16:00 - 17:00</li>
                    </ul>
                    <a href="#" class="btn-buy" onclick="openCameraModal()">Tandai Kehadiran</a>
                </div>
            </div>
            <!-- End Pricing Item -->

            <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="pricing-tem">
                    <h3 style="color: #263fc8;">Divisi Sistem Cerdas</h3>

                    <div class="icon">
                        <img src="{{ asset('storage/logo/logo_6905939addf9e.webp') }}" alt="Starter Icon"
                            style="width: 200px; height: auto;">
                    </div>

                    <ul>
                        <li>Pertemuan 1</li>
                        <li>Fakultas Teknik</li>
                        <li>16:00 - 17:00</li>
                    </ul>
                    <a href="#" class="btn-buy" onclick="openCameraModal()">Tandai Kehadiran</a>
                </div>
            </div>
            <!-- End Pricing Item -->

        </div><!-- End pricing row -->

    </div>


    <!-- ======================= MODAL KAMERA ======================= -->
    <div id="cameraModal" class="modal">
        <div class="modal-content">

            <button class="close-btn">&times;</button>

            <h3 class="modal-title">Ambil Foto Kehadiran</h3>

            <div class="camera-box">
                <video id="video" autoplay></video>
                <canvas id="canvas" style="display:none;"></canvas>
            </div>

            <div class="modal-actions">
                <button id="captureBtn" class="btn-primary">Ambil Gambar</button>
                <button id="submitBtn" class="btn-disabled" disabled>
                    Tandai Kehadiran
                </button>
            </div>

        </div>
    </div>

    <style>
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            backdrop-filter: blur(6px);
            background: rgba(0, 0, 0, 0.45);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-content {
            width: 100%;
            max-width: 380px;
            background: #ffffff;
            padding: 25px 20px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: fadeIn 0.25s ease-out;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .close-btn {
            position: absolute;
            top: 12px;
            right: 12px;
            background: none;
            border: none;
            font-size: 26px;
            cursor: pointer;
            color: #444;
            transition: 0.2s;
        }

        .modal-title {
            margin-bottom: 15px;
            font-size: 20px;
            font-weight: 600;
            color: #263fc8;
        }

        .camera-box {
            width: 100%;
            background: #000;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 18px;
            position: relative;
        }

        video,
        canvas {
            width: 100%;
            height: auto;
            object-fit: contain;
            background: #000;
            display: block;
        }

        .modal-actions {
            display: flex;
            justify-content: space-between;
            gap: 12px;
        }

        .btn-primary {
            flex: 1;
            background: #263fc8;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.25s;
        }

        .btn-disabled {
            flex: 1;
            background: #a9a9a9;
            color: #fff;
            border: none;
            padding: 12px;
            border-radius: 8px;
            cursor: not-allowed;
            font-weight: 600;
        }

        /* HIJAU TERANG BAGUS */
        .btn-primary-active {
            background: #1fd655 !important;
        }
    </style>


    <script>
        const modal = document.getElementById('cameraModal');
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const captureBtn = document.getElementById('captureBtn');
        const submitBtn = document.getElementById('submitBtn');
        let stream;

        function openCameraModal() {
            modal.style.display = 'flex';

            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(s => {
                    stream = s;
                    video.srcObject = s;
                })
                .catch(() => alert("Kamera tidak dapat diakses!"));
        }

        video.onloadedmetadata = () => {
            const ratio = video.videoHeight / video.videoWidth;
            const cameraBox = document.querySelector(".camera-box");
            cameraBox.style.height = cameraBox.offsetWidth * ratio + "px";
        };

        document.querySelector(".close-btn").onclick = () => {
            modal.style.display = "none";
            if (stream) stream.getTracks().forEach(t => t.stop());
            video.style.display = "block";
            canvas.style.display = "none";
        };

        captureBtn.onclick = () => {
            const vw = video.videoWidth;
            const vh = video.videoHeight;

            canvas.width = vw;
            canvas.height = vh;

            const ctx = canvas.getContext("2d");
            ctx.drawImage(video, 0, 0, vw, vh);

            canvas.style.display = "block";
            video.style.display = "none";

            submitBtn.disabled = false;
            submitBtn.classList.add("btn-primary-active");

            stream.getTracks().forEach(t => t.stop());
        };

        submitBtn.onclick = () => {
            const imageData = canvas.toDataURL("image/png");

            fetch("/kehadiran/store", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        foto: imageData,
                        event: "Divisi Mobile"
                    })
                }).then(res => res.json())
                .then(() => {
                    alert("Kehadiran berhasil ditandai!");
                    modal.style.display = "none";
                });
        };
    </script>

</section>
