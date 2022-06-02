@component('mail::message')
    Halo, Pelanggan yang terhormat.

    Terimakasih sudah berlangganan di website kami, kamu akan mendapatkan informasi lebih awal dari kami

    @component('mail::button', ['url' => route('homepage')])
        Visit Website
    @endcomponent

    Terima Kasih,<br>
    {{ $setting->site_name }}
@endcomponent
