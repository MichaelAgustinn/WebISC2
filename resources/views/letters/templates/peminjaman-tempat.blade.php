<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Surat {{ $data['perihal'] }}</title>

    <style>
        body {
            font-family: 'Times New Roman', serif;
            font-size: 12pt;
            margin-left: 56px;
            margin-right: 56px;
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
            margin-top: 60px;
            text-align: right;
        }

        .footer p {
            margin: 0;
            line-height: 1.3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: none;
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
        <p><strong>Lampiran :</strong> -</p>
        <p><strong>Perihal :</strong> {{ $data['perihal'] }}</p>

        <br>
        <p><b>Kepada Yth.</b></p>
        <p><b>{{ $data['tujuan'] }}</b></p>
        <p>Di-</p>
        <p>Tempat</p>

        <p>Assalamualaikum Wr. Wb</p>

        <p>
            Sehubungan dengan akan dilaksanakannya kegiatan
            <strong>{{ $data['dasar_kegiatan'] }}</strong>, maka kami bermaksud
            untuk meminjam <strong>{{ $data['nama_tempat_barang'] }}</strong> untuk kegiatan tersebut,
            yang akan dilaksanakan pada:
        </p>

        <table style="margin-left: 1cm;">
            <tr>
                <td>Hari/Tanggal</td>
                <td>:</td>
                <td>{{ $data['hari'] }}</td>
            </tr>
            <tr>
                <td>Waktu</td>
                <td>:</td>
                <td>{{ $data['jam'] }}</td>
            </tr>
        </table>

        <p>
            Besar harapan kami agar kegiatan tersebut dapat berjalan dengan lancar tanpa hambatan apa pun.
        </p>

        <p>
            Demikian surat peminjaman ini kami sampaikan. Atas perhatian dan kerja samanya kami ucapkan terima kasih.
        </p>

        <p>Wassalamualaikum Wr. Wb</p>
    </div>

    {{-- TANDA TANGAN --}}
    <div class="footer">
        <p>Majene, {{ \Carbon\Carbon::parse($letter->tanggal)->translatedFormat('d F Y') }}</p>
        <p>{{ $letter->jabatan_ketua ?? 'Ketua Umum ISC' }}</p>

        <div style="height: 70px;"></div>

        <p><strong><u>{{ $letter->nama_ketua }}</u></strong></p>
        <p>NIM: D0223511</p>
    </div>

</body>

</html>
