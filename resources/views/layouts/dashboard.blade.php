<!DOCTYPE html>
<html lang="en">

<head>
    {{-- Meta --}}
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta content="Admin Dashboard" name="description" />
    <meta content="{{ Auth::user()->name }}" name="author" />
    <meta http-equiv="Pragma" CONTENT="no-cache">
    <meta http-equiv="Expires" CONTENT="-1">
    {{-- title --}}
    <title>@yield('title') - {{ $setting->site_name }}</title>
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
    {{-- icons --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="{{ asset('vendor/blog/assets/fontawesome/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/dashboard/css/style.css') }}" rel="stylesheet" type="text/css">
    {{-- CALL CSS --}}
    @stack('css-external')
    @stack('css-internal')
</head>


<body class="fixed-left">

    <!-- Loader -->
    {{-- <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div> --}}

    <!-- Begin page -->
    <div id="wrapper">

        <!-- ========== Left Sidebar Start ========== -->
        @include('layouts._dashboard.sidebar')
        <!-- Left Sidebar End -->

        <!-- Start right Content here -->

        <div class="content-page">
            <!-- Start content -->
            <div class="content">

                <!-- Top Bar Start -->
                @include('layouts._dashboard.topbar')
                <!-- Top Bar End -->

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
                        <!-- end page title end breadcrumb -->

                        @yield('content')

                    </div><!-- container -->

                </div> <!-- Page content Wrapper -->

            </div> <!-- content -->

            {{-- footer --}}
            <footer class="footer site_footer">
                {{ $setting->site_footer }}
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="{{ asset('vendor/dashboard/js/jquery.min.js') }}"></script>
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
    {{-- select2 --}}
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('vendor/dashboard/js/apps.js') }}"></script>
    {{-- CALL JS --}}
    @stack('js-external')
    @stack('js-internal')

    <script>
        window.onload = function() {
            if (!localStorage.justOnce) {
                localStorage.setItem("justOnce", "true");
                window.location.reload();
            }
        }
    </script>

    {{-- CALL SWEETALERT2 --}}
    @include('sweetalert::alert')
</body>

</html>
