<!DOCTYPE html>

<html lang="id">

<head>
    {{-- Title website --}}
    <title>{{ $setting->site_name }}</title>
    {{-- Primary Meta Tags --}}
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="{{ $setting->site_name }}">
    <meta name="description" content="{{ $setting->site_description }}">
    <meta name="author" content="{{ $setting->site_name }}">
    <meta name="keywords" content="{{ $setting->meta_keywords }}">
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="@yield('url', route('homepage'))">
    <meta property="og:title" content="{{ $setting->site_name }}">
    <meta property="og:description" content="@yield('description', $setting->site_description)">
    <meta property="og:image" content="@yield('image', asset('vendor/blog/img/default.png'))">
    <meta property="og:site_name" content="{{ $setting->site_name }}">
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- Assets CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/venobox/venobox.css') }}" media="screen" />
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/owl.carousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/alertify/css/alertifi.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/blog/css/style.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')
</head>

<body>
    {{-- SLIDE --}}
    {{-- @include('home.slide') --}}

    {{-- HEADER --}}
    @include('layouts._layouts.navbar')

    <main id="main">

        {{-- ABOUT --}}
        {{-- @include('home.about') --}}

        {{-- SOCIAL MEDIA --}}
        {{-- @include('home.social-media') --}}

        {{-- Banner --}}
        @include('home.banner')

        {{-- BLOG --}}
        @include('home.blog')

        {{-- CATEGORIES --}}
        @include('home.category')

        {{-- GALLERY --}}
        {{-- @include('home.gallery') --}}

        {{-- CONTACT --}}
        {{-- @include('home.contact') --}}


    </main>

    {{-- FOOTER --}}
    @include('layouts._layouts.footer')

    <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left" title="Keatas">
        <i class="uil uil-angle-up"></i>
    </a>

    {{-- Assets JS --}}
    <script src="{{ asset('vendor/blog/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/jquery-sticky/jquery.sticky.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/venobox/venobox.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/owl.carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/alertify/js/alertify.js') }}"></script>
    {{-- Main Js --}}
    <script src="{{ asset('vendor/blog/js/main.js') }}"></script>
    {{-- JS Ext --}}
    @stack('js-external')
    {{-- JS Int --}}
    @stack('js-internal')

    <script>
        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        $(function() {

            $(".btn-tooltip-hide").tooltip().on("click", function() {
                $(this).tooltip("hide")
            });

            // Remove anchor with 0 sec
            setTimeout(() => {
                history.replaceState('', document.title, window.location.origin + window
                    .location.pathname + window
                    .location.search);
            }, 0);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input.form-control').removeClass(
                    'is-invalid');
                $(document).find('textarea.form-control').removeClass(
                    'is-invalid');
                $('#formContactUs')[0].reset();
            });

            // Contact Us Modal
            $('#formContactUs').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                        // button
                        $('#btn_contactUs').attr('disabled', true);
                        $('#btn_contactUs').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#btn_contactUs').attr('disabled', false);
                        $('#btn_contactUs').html('{{ trans('home.contact.buttonform') }}');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $('input#' + key).addClass('is-invalid');
                                $('textarea#' + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            $('#formContactUs')[0].reset();
                            $('#modalContactUs').modal('hide');
                            // Notif
                            alertify
                                .delay(3500)
                                .log(response.msg);
                        }
                    },
                    error: function(response) {
                        alert(response.status + "\n" + response.errors + "\n" + thrownError);
                    }
                });
            });

            // newsletter
            $('#formNewsletter').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn_newsletter').attr('disabled', true);
                        $('#btn_newsletter').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function(response) {
                        $('#btn_newsletter').attr('disabled', false);
                        $('#btn_newsletter').html('Subscribe');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            alertify
                                .delay(4000)
                                .error(response.error.email[0]);
                        } else {
                            $('#formNewsletter')[0].reset();
                            alertify
                                .delay(4000)
                                .log(response.msg);
                        }
                    }
                });
            });

        });
    </script>
</body>

</html>
