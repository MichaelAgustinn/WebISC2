<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat Peringatan {{ $detail->peringatan_ke }}</title>
    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin: 56px;
            position: relative;
            min-height: 100vh;
        }

        h3,
        h4,
        h5 {
            text-align: center;
            margin: 0;
            line-height: 1.4;
        }

        .kop {
            margin: 0;
            padding: 0;
            text-align: center;
        }

        /* buat tabel logo dan teks tengah benar-benar sejajar vertikal */
        .kop table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
        }

        .kop td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }

        .kop h4 {
            font-size: 16pt;
            margin: 0;
            line-height: 1.2;
        }

        .kop h5 {
            font-size: 13pt;
            margin: 0;
            line-height: 1.2;
        }

        .kop p {
            margin: 2px 0 0 0;
            font-size: 9pt;
            font-weight: bold;
        }

        .kop img {
            width: 80px;
            height: auto;
            object-fit: contain;
        }

        /* garis bawah kop */
        .kop hr {
            border: 1px solid black;
            margin: 4px 0;
        }

        .content {
            text-align: justify;
            margin-top: 25px;
        }

        .footer {
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            flex-direction: column;
            page-break-inside: avoid;
            height: 180px;
            /* tinggi ruang footer */
            margin-top: 60px;
            text-align: right;
        }

        .footer p {
            margin: 0;
            line-height: 1.3;
        }

        .lampiran {
            page-break-before: always;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- KOP SURAT --}}
    <div class="kop">
        @include('letters.templates.kop')
    </div>



    {{-- ISI SURAT --}}
    <div class="content" style="margin-bottom: 100px;">
        <p><strong>Nomor :</strong> {{ $letter->nomor_surat }}</p>
        <p><strong>Lampiran :</strong> 1</p>
        <p><strong>Perihal :</strong> Surat Peringatan {{ $detail->peringatan_ke }}</p>

        <br>
        <p><b>Kepada Yth.</b></p>
        <p><b>Anggota Informatics Study Club</b></p>
        {{-- <br> --}}

        <p>
            Dengan ini kami, pengurus Informatics Study Club, menyampaikan surat keputusan sebagai berikut:
        </p>
        <p>
            Setelah melakukan evaluasi atas partisipasi dan kontribusi aktif dalam kegiatan ISC, kami memutuskan
            untuk mengeluarkan Surat Peringatan {{ $detail->peringatan_ke }} untuk beberapa anggota yang tidak
            memenuhi kriteria yang telah ditetapkan oleh ISC.<span>
                <b>Nama-nama yang masuk kriteria akan dilampirkan
                    di halaman berikutnya.</b>
            </span>
        </p>
        <p>
            Demikian surat keputusan ini kami sampaikan untuk menjadi perhatian bersama. Apabila ada pertanyaan
            atau kekhawatiran mengenai keputusan ini, silakan hubungi kami.
        </p>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="footer">
        <p>Majene, {{ \Carbon\Carbon::parse($letter->tanggal)->translatedFormat('d F Y') }}</p>
        <p>{{ $letter->jabatan_ketua }}</p>

        <div style="height: 70px;"></div>

        <p><strong><u>{{ $letter->nama_ketua }}</u></strong></p>
        <p>NIM: D0223511</p>
    </div>




    {{-- LAMPIRAN --}}
    <div class="lampiran">
        <div class="kop">
            @include('letters.templates.kop')
        </div>

        <h4 class="center">DAFTAR NAMA ANGGOTA YANG DIBERIKAN SURAT PERINGATAN {{ $detail->peringatan_ke }}</h4>

        <table>
            <thead>
                <tr>
                    <th class="center">No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>Angkatan</th>
                    <th>Divisi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $i => $user)
                    <tr>
                        <td class="center">{{ $i + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->profile->nim ?? '-' }}</td>
                        <td>{{ $user->profile->angkatan ?? '-' }}</td>
                        <td>{{ $user->profile->divisi ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    {{-- NOMOR HALAMAN --}}
    <script type="text/php">
    if (isset($pdf)) {
        $x = 515; // posisi horizontal (kanan)
        $y = 820; // posisi vertikal (bawah)
        $text = "Halaman {PAGE_NUM} dari {PAGE_COUNT}";
        $font = $fontMetrics->get_font("Times New Roman", "normal");
        $size = 9;
        $pdf->page_text($x, $y, $text, $font, $size);
    }
</script>
</body>

</html>
