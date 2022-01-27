<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Primary Meta Tags --}}
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta name="title" content="@yield('title') - {{ config('app.name') }}">
    <meta name="description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
      okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
      it's very fun.">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="keywords" content="Personal, Blog, Angga, Fahri Anggara, Personal Website">
    <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1" />
    <meta name="content" content="@yield('title')">
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ config('app.url') }}">
    <meta property="og:title" content="@yield('title') - {{ config('app.name') }}">
    <meta property="og:description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
      okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
      it's very fun.">
    <meta property="og:image" content="{{ asset('vendor/my-blog/img/home-img/about.jpeg') }}">
    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ config('app.url') }}">
    <meta property="twitter:title" content="@yield('title') - {{ config('app.name') }}">
    <meta property="twitter:description" content="Hello, my name is Fahri Anggara, you can call me Angga. I hope you enjoy my Website!
      okay.. First I will explain.. why I made this website? because I like coding. Well my hobby is coding, 
      it's very fun.">
    <meta property="twitter:image" content="{{ asset('vendor/my-blog/img/home-img/about.jpeg') }}">

    {{-- Logo --}}
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">
    {{-- Assets CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/bootstrap/css/bootstrap.min.css') }}">
    {{-- Icon --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/icofont/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/fontawesome/css/all.min.css') }}">
    {{-- jQuery Ui --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/assets/jquery-ui/jquery-ui.css') }}">
    {{-- Main CSS --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-blog/css/css.css') }}">
    {{-- CSS EXT --}}
    @stack('css-external')
    {{-- CSS INT --}}
    @stack('css-internal')

</head>

<body>

    @include('layouts._blog.navbar')

    <main id="main">

        <section id="main-blog" class="main-blog">
            @yield('content')
        </section>

    </main>



    @include('layouts._blog.footer')

    <a href="#" class="to-the-top btn-tooltip-hide" data-toggle="tooltip" data-placement="left"
        title="{{ trans('blog.tooltip.top') }}">
        <i class="uil uil-angle-up"></i>
    </a>
    {{-- Assets JS --}}
    <script src="{{ asset('vendor/my-blog/assets/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/jquery-sticky/jquery.sticky.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/jquery.easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/sharerjs/sharer.min.js') }}"></script>
    <script src="{{ asset('vendor/my-blog/assets/prehighlight/prehighlights.js') }}"></script>
    {{-- Main Js --}}
    <script src="{{ asset('vendor/my-blog/js/blog.js') }}"></script>
    {{-- JS Ext --}}
    @stack('js-external')
    {{-- JS Int --}}
    @stack('js-internal')

    <script>
        $(document).ready(function() {
            // tooltip
            $(".btn-tooltip-hide").tooltip().on("click", function() {
                $(this).tooltip("hide")
            });

            // Remove anchor with 0 sec
            setTimeout(() => {
                history.replaceState('', document.title, window.location.origin + window
                    .location.pathname + window
                    .location.search);
            }, 0);

            // Progress bar
            function progress() {

                var windowScrollTop = $(window).scrollTop();
                var docHeight = $(document).height();
                var windowHeight = $(window).height();
                var progress = (windowScrollTop / (docHeight - windowHeight)) * 100;
                var $bgColor = progress > 99 ? '#60e4ff' : '#00b2cc';

                $('.progress-read .bar').width(progress + '%').css({
                    backgroundColor: $bgColor
                });
            }

            progress();
            $(document).on('scroll', progress);

            // ====== LOADING SKELETON ====== //
            // Remove Loading
            const cardImages = document.querySelectorAll(".entry-img");
            const cardTitles = document.querySelectorAll(".entry-title");
            const cardMetas = document.querySelectorAll(".entry-meta div");
            const cardTexts = document.querySelectorAll(".entry-content div");
            const cardButtons = document.querySelectorAll(".read-more a");
            const sidImages = document.querySelectorAll(".imgSidebar");
            const sidTitles = document.querySelectorAll(".titleSidebar");
            const sidTimes = document.querySelectorAll(".timeSidebar");
            const sidArcvs = document.querySelectorAll('.linkArchives');
            const comImages = document.querySelectorAll('.comImg');
            const comTitles = document.querySelectorAll('.comTitle');
            const comTexts = document.querySelectorAll('.comText');
            const comTitleTimes = document.querySelectorAll('.comTitleTime');
            const moreImages = document.querySelectorAll('.img-moreBlog');
            const moreLinks = document.querySelectorAll('.link-moreblog');
            const moreDates = document.querySelectorAll('.img-moredate');
            const popImages = document.querySelectorAll('.post-img');
            const popTitles = document.querySelectorAll('.post-title');
            const popTimes = document.querySelectorAll('.post-time');
            const blogCatTags = document.querySelectorAll('.tagCats');
            // Show Content
            const cardImgs = document.querySelectorAll(".entry-img img");
            const cardTtls = document.querySelectorAll(".entry-title a");
            const cardMets = document.querySelectorAll(".entry-meta i,span, .iconAuthor");
            const cardTxts = document.querySelectorAll(".entry-content p");
            const cardBtns = document.querySelectorAll(".read-more a");
            const sidTtls = document.querySelectorAll(".titleSidebar a");
            const sidTms = document.querySelectorAll(".timeSidebar p,span");
            const sidImgs = document.querySelectorAll(".imgSidebar img")
            const sidArcs = document.querySelectorAll(".linkArchives i");
            const comImgs = document.querySelectorAll('.comImg img');
            const comTtls = document.querySelectorAll('.comTitle .comment-title');
            const comTxts = document.querySelectorAll('.comText .comment-text');
            const comTtlTimes = document.querySelectorAll('.comTitleTime small');
            const moreImgs = document.querySelectorAll('.img-moreBlog img');
            const moreLnks = document.querySelectorAll('.link-moreblog .link-textMoreBlog');
            const popImgs = document.querySelectorAll('.post-img .img');
            const popTtls = document.querySelectorAll('.post-title .text-links');
            const popTms = document.querySelectorAll('.post-time .text-time');
            const blogTagCats = document.querySelectorAll('.tagCats i, .link-tagCats');

            const renderCard = () => {
                // REMOVE CLASS LOADING
                blogCatTags.forEach((blogCatTag) => {
                    blogCatTag.classList.remove('loading');
                });
                // SHOW CONTENT
                blogTagCats.forEach((blogTagCat) => {
                    blogTagCat.style.visibility = "visible";
                });
                // REMOVE CLASS LOADING
                popImages.forEach((popImage) => {
                    popImage.classList.remove('loading');
                });
                popTitles.forEach((popTitle) => {
                    popTitle.classList.remove('loading');
                });
                popTimes.forEach((popTime) => {
                    popTime.classList.remove('loading');
                });
                // SHOW CONTENT
                popImgs.forEach((popImg) => {
                    popImg.style.visibility = "visible";
                });
                popTtls.forEach((popTtl) => {
                    popTtl.style.visibility = "visible";
                });
                popTms.forEach((popTm) => {
                    popTm.style.visibility = "visible";
                });
                // REMOVE CLASS LOADING
                moreImages.forEach((moreImage) => {
                    moreImage.classList.remove('loading');
                });
                moreLinks.forEach((moreLink) => {
                    moreLink.classList.remove('loading');
                });
                moreDates.forEach((moreDate) => {
                    moreDate.classList.remove('loading');
                });
                // SHOW CONTENT
                moreImgs.forEach((moreImg) => {
                    moreImg.style.visibility = 'visible';
                })
                moreLnks.forEach((moreLnk) => {
                    moreLnk.style.visibility = "visible";
                })
                // REMOVE CLASS LOADING
                comImages.forEach((comImage) => {
                    comImage.classList.remove('loading-cicle');
                })
                comTitles.forEach((comTitle) => {
                    comTitle.classList.remove('loading');
                });
                comTitleTimes.forEach((comTitleTime) => {
                    comTitleTime.classList.remove('loading');
                });
                comTexts.forEach((comText) => {
                    comText.classList.remove('loading');
                });
                // SHOW CONTENT
                comImgs.forEach((comImg) => {
                    comImg.style.visibility = "visible";
                });
                comTtls.forEach((comTtl) => {
                    comTtl.style.visibility = "visible";
                });
                comTtlTimes.forEach((comTtlTime) => {
                    comTtlTime.style.visibility = "visible";
                });
                comTxts.forEach((comTxt) => {
                    comTxt.style.visibility = "visible";
                });
                // REMOVE CLASS LOADING
                cardImages.forEach((cardImage) => {
                    cardImage.classList.remove("loading")
                });
                cardTitles.forEach((cardTitle) => {
                    cardTitle.classList.remove("loading")
                });
                cardMetas.forEach((cardMeta) => {
                    cardMeta.classList.remove("loading")
                });
                cardTexts.forEach((cardText) => {
                    cardText.classList.remove("loading")
                });
                cardButtons.forEach((cardButton) => {
                    cardButton.classList.remove("loading")
                });
                // SHOW CONTENT
                cardImgs.forEach((cardImg) => {
                    cardImg.style.visibility = "visible";
                });
                cardTtls.forEach((cardTtl) => {
                    cardTtl.style.visibility = "visible";
                });
                cardMets.forEach((cardMet) => {
                    cardMet.style.visibility = "visible";
                });
                cardTxts.forEach((cardTxt) => {
                    cardTxt.style.visibility = "visible";
                });
                cardBtns.forEach((cardBtn) => {
                    cardBtn.style.visibility = "visible";
                });
                // REMOVE CLASS LOADING
                sidImages.forEach((sidImage) => {
                    sidImage.classList.remove("loading")
                });
                sidTitles.forEach((sidTitle) => {
                    sidTitle.classList.remove("loading")
                });
                sidTimes.forEach((sidTime) => {
                    sidTime.classList.remove("loading")
                });
                sidArcvs.forEach((sidArcv) => {
                    sidArcv.classList.remove('loading')
                });
                // SHOW
                sidTtls.forEach((sidTtl) => {
                    sidTtl.style.visibility = "visible";
                });
                sidTms.forEach((sidTm) => {
                    sidTm.style.visibility = "visible";
                });
                sidImgs.forEach((sidImg) => {
                    sidImg.style.visibility = "visible";
                });
                sidArcs.forEach((sidArc) => {
                    sidArc.style.visibility = "visible";
                });
            }

            window.onload = (event) => {
                renderCard();
            };

            // setTimeout(() => {
            //     renderCard();
            // }, 2000);
        });
    </script>
</body>

</html>
