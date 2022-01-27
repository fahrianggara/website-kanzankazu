<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Angga" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    {{-- SELECT 2 --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-dashboard/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/my-dashboard/assets/plugins/select2/css/select2-bootstrap4.min.css') }}">
    {{-- SWEETALERT2 --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/sweetalert2/sweetalert2.css') }}">
    <script src="{{ asset('vendor/my-blog/assets/sweetalert2/sweetalert2.js') }}"></script>
    {{-- MAIN CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/all-web.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link href="{{ asset('vendor/my-dashboard/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/my-dashboard/assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('vendor/my-dashboard/assets/css/main.css') }}" rel="stylesheet" type="text/css">
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
            <footer class="footer">
                {{ config('app.name') }} - Made with ❤
            </footer>

        </div>
        <!-- End Right content here -->

    </div>
    <!-- END wrapper -->

    <!-- jQuery  -->
    <script src="{{ asset('vendor/my-dashboard/assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/modernizr.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/detect.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/fastclick.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/waves.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/js/jquery.scrollTo.min.js') }}"></script>
    {{-- select2 --}}
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}">
    </script>
    <!-- App js -->
    <script src="{{ asset('vendor/my-dashboard/assets/js/app.js') }}"></script>
    {{-- CALL JS --}}
    @stack('js-external')
    @stack('js-internal')

    {{-- CALL SWEETALERT2 --}}
    @include('sweetalert::alert')
</body>

</html>
