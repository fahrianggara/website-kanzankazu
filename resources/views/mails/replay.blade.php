@component('mail::message')
# Halo, {{ $contact['name'] }}.

Balasan dari inbox : {{ $contact['message'] }}
<br>

{{ $contact['replay'] }}

<br>
Hormat,<br>
{{$setting->site_name}}
@endcomponent
