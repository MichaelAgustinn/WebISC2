@props(['url'])
<tr>
    <td class="header" style="background-color: #263C8F; text-align: center; padding: 30px 0;">
        <a href="{{ $url }}" style="display: inline-block; text-decoration: none; text-align: center;">
            {{-- Logo --}}
            {{-- <img src="{{ public_path('images/logo-isc-email.png') }}" alt="{{ config('app.name') }} Logo" width="80"
                height="80" style="display:block; border-radius:50%; margin:0 auto 10px; object-fit:cover;"> --}}


            {{-- Nama Aplikasi --}}
            <div style="font-size: 22px; font-weight: 700; color: #FFFFFF; letter-spacing: 0.5px;">
                {{ config('app.name') }}
            </div>

            {{-- Garis Aksen Emas --}}
            {{-- <div style="margin: 12px auto 0; width: 80px; height: 4px; background-color: #F7C70F; border-radius: 2px;">
            </div> --}}
        </a>
    </td>
</tr>
