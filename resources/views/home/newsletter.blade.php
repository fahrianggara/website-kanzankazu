<form action="{{ route('newsletter.store') }}" id="formNewsletter" method="post" autocomplete="off">
    @method('post')
    @csrf

    <input type="text" id="emailNewsletter" name="email" placeholder="Alamat email">

    <button type="submit" id="btn_newsletter">
        Subscribe
    </button>
</form>

@push('js-internal')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
