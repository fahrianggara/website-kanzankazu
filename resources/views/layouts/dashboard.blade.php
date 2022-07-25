<!DOCTYPE html>
<html lang="id">

<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-8KX39QL4MK"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'G-8KX39QL4MK');
    </script>
    {{-- Meta --}}
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="title" content="@yield('title') - {{ $setting->site_name }}">
    <meta name="description" content="@yield('description', $setting->site_description)">
    <meta name="keywords" content="@yield('keywords', $setting->meta_keywords)">
    <meta name="language" content="id">
    <meta name="author" content="@yield('author', Auth::user()->name)">
    {{-- Meta OG --}}
    <meta property="og:title" content="@yield('title') - {{ $setting->site_name }}" />
    <meta property="og:description" content="{{ $setting->site_description }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ asset('logo-web/android-chrome-512x512.png') }}" />
    {{-- title --}}
    @if (url()->current() == route('dashboard.index'))
        <title>Dashboard - {{ $setting->site_name }}</title>
    @else
        <title>@yield('title') | Dashboard - {{ $setting->site_name }}</title>
    @endif
    {{-- Logo / icon --}}
    <link rel="shortcut icon" href="{{ asset('logo-web/favicon.ico') }}" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('logo-web/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('logo-web/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo-web/favicon-16x16.png') }}">
    {{-- MAIN CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/select2/css/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/alertify/css/alerts.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/ijabocroptool/ijaboCropTool.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/datatables/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/datatables/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/dashboard/plugins/colorpicker/jquery-asColorPicker/dist/css/asColorPicker.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/dropzone/dist/dropzone.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/dropify/css/dropify.min.css') }}">
    {{-- icons --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/whoms.css') }}" rel="stylesheet" type="text/css">
    {{-- CALL CSS --}}
    @stack('css-external')
    @stack('css-internal')

    <style>


    </style>
</head>


<body class="fixed-left">

    {{-- Session message status --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div id="wrapper">

        @include('layouts._dashboard.sidebar')

        <div class="content-page">

            <div class="content">

                @include('layouts._dashboard.topbar')

                <div class="page-content-wrapper ">

                    <div class="container-fluid">

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="page-title-box">
                                    <div class="btn-group float-right">
                                        @yield('breadcrumbs')
                                    </div>
                                    <h4 class="page-title">@yield('title')</h4>
                                </div>
                            </div>
                        </div>

                        @yield('content')

                    </div>

                </div>

            </div>

            {{-- footer --}}
            <footer class="footer site_footer">
                {{ $setting->site_footer }}
            </footer>

        </div>

    </div>

    <script src="{{ asset('vendor/dashboard/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/colorpicker/jquery-asColor/dist/jquery-asColor.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/colorpicker/jquery-asGradient/dist/jquery-asGradient.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/colorpicker/jquery-asColorPicker/dist/jquery-asColorPicker.js') }}">
    </script>
    <script src="{{ asset('vendor/blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/detect.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/fastclick.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/waves.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/alertify/js/alerts.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/ijabocroptool/ijaboCropTool.min.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('vendor/blog/assets/prehighlight/prehighlights.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/dropzone/dist/dropzone.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/dropify/js/dropify.min.js') }}"></script>
    {{-- ttiny mce --}}
    <script src="{{ asset('vendor/dashboard/plugins/tinymce5/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/tinymce5/tinymce.min.js') }}"></script>
    {{-- select2 --}}
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    {{-- DATATABLE --}}
    <script src="{{ asset('vendor/dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <!-- App js -->
    <script src="{{ asset('vendor/dashboard/js/apps.js') }}"></script>
    {{-- CALL JS --}}
    @stack('js-external')
    @stack('js-internal')

    <script>
        $(".complex-colorpicker").asColorPicker();

        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }

        setTimeout(() => {
            history.replaceState('', document.title, window.location.origin + window
                .location.pathname + window
                .location.search);
        }, 0);

        $(function() {
            $("[data-toggle='tooltip']").tooltip().on("click", function() {
                $(this).tooltip("hide")
            });

            $('.dataTables_wrapper').find('.col-sm-12.col-md-5').remove();

            $(document).on('keyup', function(e) {
                e.preventDefault();

                if ($('#modalDelete').hasClass('show')) {
                    if (e.which == 13) {
                        $('.btnDelete').click();
                    }
                }

                if (e.which == 16) {
                    $('[data-target="#modalCreate"]').click();
                }
            });

            $('.dropify').dropify({
                messages: {
                    'default': 'Klik atau tarik dan lepaskan gambar untuk diupload',
                    'replace': 'Ganti',
                    'remove': 'Hapus',
                    'error': 'error'
                },
                error: {
                    'fileSize': 'Ukuran file terlalu besar (maks. 1 MB)',
                    'imageFormat': 'Format gambar tidak didukung'
                }
            });
        });

        // Notif status
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(5000)
                .log(notif);
        }

        // CONTENT
        $("#input_post_content").tinymce({
            relative_urls: false,
            language: "en",
            selector: 'textarea',
            skin: 'oxide-dark',
            height: 500,
            width: '100%',
            content_css: [
                "{{ asset('vendor/dashboard/plugins/tinymce5/skins/ui/oxide-dark/content.min.css') }}",
                "{{ asset('vendor/dashboard/plugins/tinymce5/skins/content/default/content.min.css') }}"
            ],
            extended_valid_elements: 'img[class=popup img-fluid|src|width|height|style=z-index:9999999!important]',
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak emoticons save",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table directionality",
                "emoticons template paste textpattern",
                "tabfocus",
                "codesample",
                "autosave",
            ],
            content_style: "@import url('https://fonts.googleapis.com/css2?family=Anek+Latin:wght@300;500;700&family=Lato:ital,wght@0,300;0,400;0,700;1,300;1,700&family=Noto+Sans+Display:ital,wght@0,300;0,400;0,500;0,700;1,400&family=Noto+Sans+JP:wght@300;400;700&family=Poppins:ital,wght@0,300;0,500;0,700;1,300;1,500&family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,500&family=Rubik:ital,wght@0,300;0,500;0,600;1,300;1,500&display=swap');",
            font_formats: "Anek Latin=anek latin,sans-serif;Lato=lato,sans-serif;Noto Sans JP=noto sans jp,sans-serif;Poppins=poppins,sans-serif;Roboto=roboto;Rubik=rubik,sans-serif;Roboto Condensed=roboto condensed,sans-serif;Noto Sans Display=noto sans display,sans-serif;Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
            fontsize_formats: '8pt 9pt 10pt 11pt 12pt 14pt 18pt 24pt 30pt 36pt 48pt 60pt 72pt 96pt',
            codesample_global_prismjs: true,
            codesample_languages: [{
                    text: 'HTML/XML',
                    value: 'markup'
                },
                {
                    text: 'Javascript',
                    value: 'javascript'
                },
                {
                    text: 'CSS',
                    value: 'css'
                },
                {
                    text: 'PHP',
                    value: 'php'
                },
                {
                    text: 'Python',
                    value: 'python'
                },
                {
                    text: 'C++',
                    value: 'cpp'
                },
                {
                    text: "JSON",
                    value: "json"
                },
                {
                    text: "bash",
                    value: "bash"
                },
                {
                    text: "Mel",
                    value: "mel"
                },
            ],
            toolbar1: "restoredraft save | insertfile undo redo | fullscreen preview | styleselect fontselect fontsizeselect | bold italic | codesample emoticons | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
            // MENGKONEKKAN CONTENT GAMBAR KE FILE MANAGER
            file_picker_callback: function(callback, value, meta) {
                let x = window.innerWidth || document.documentElement.clientWidth || document
                    .getElementsByTagName('body')[0].clientWidth;
                let y = window.innerHeight || document.documentElement.clientHeight || document
                    .getElementsByTagName('body')[0].clientHeight;

                let cmsURL = "{{ route('unisharp.lfm.show') }}" + '?editor=' + meta.fieldname;
                if (meta.filetype == 'image') {
                    cmsURL = cmsURL + "&type=Images";
                } else {
                    cmsURL = cmsURL + "&type=Files";
                }

                tinyMCE.activeEditor.windowManager.openUrl({
                    url: cmsURL,
                    title: 'Filemanager',
                    width: x * 0.8,
                    height: y * 0.8,
                    resizable: "yes",
                    close_previous: "no",
                    onMessage: (api, message) => {
                        callback(message.content);
                    }
                });
            }
        });
    </script>

    {{-- CALL SWEETALERT2 --}}
    @include('sweetalert::alert')
</body>

</html>
