@component('mail::message')
Pesan dari: {{ $message['name'] }}.<br>
Ke Anda.

{{ $message['message'] }}

Thanks,<br>
{{ $message['name'] }}
@endcomponent
