!(function ($) {
    "use strict";

    // Stick the header at top on scroll
    $("#header").sticky({
        topSpacing: 0,
        zIndex: '50'
    });

    // Smooth scroll for the navigation menu and links with .scrollto classes
    var scrolltoOffset = $('#header').outerHeight() - 1;
    $(document).on('click', '.nav-menu a, .mobile-nav a, .scrollto, .bannerLinks, .btn-explore', function (e) {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location
            .hostname == this.hostname) {
            var target = $(this.hash);
            if (target.length) {
                e.preventDefault();

                var scrollto = target.offset().top - scrolltoOffset;

                if ($(this).attr("href") == '#header') {
                    scrollto = 0;
                }

                $('html, body').animate({
                    scrollTop: scrollto
                }, 1500, 'easeInOutExpo');

                if ($(this).parents('.nav-menu, .mobile-nav').length) {
                    $('.nav-menu .active, .mobile-nav .active').removeClass('active');
                    $(this).closest('li').addClass('active');
                }

                if ($('body').hasClass('mobile-nav-active')) {
                    $('body').removeClass('mobile-nav-active');
                    $('.closeSideBar').removeClass('show');
                    // $('.mobile-nav-toggle i').toggleClass('uil uil-bars icofont-close');
                    $('.mobile-nav-overly').fadeOut();
                }
                return false;
            }
        }
    });

    // Activate smooth scroll on page load with hash links in the url
    $(document).ready(function () {
        if (window.location.hash) {
            var initial_nav = window.location.hash;
            if ($(initial_nav).length) {
                var scrollto = $(initial_nav).offset().top - scrolltoOffset;
                $('html, body').animate({
                    scrollTop: scrollto
                }, 1500, 'easeInOutExpo');
            }
        }
    });

    // Mobile Navigation
    if ($('.nav-menu').length) {
        var $mobile_nav = $('.nav-menu').clone().prop({
            class: 'mobile-nav d-lg-none'
        });
        $('body').append($mobile_nav);

        $('#header .container .tombolNavbar .menuButton').prepend(
            '<button type="button" class="mobile-nav-toggle d-lg-none"><i id="toggleNav" class="uil uil-bars"></i></button>'
        );

        $('body').append('<div id="mobileOverly" class="mobile-nav-overly"></div>');

        $(document).on('click', '.mobile-nav-toggle', function (e) {
            $('.closeSideBar').addClass('show');
            $('body').toggleClass('mobile-nav-active');
            // $('.mobile-nav-toggle i').toggleClass('uil uil-bars icofont-close');
            $('.mobile-nav-overly').toggle();

            let searchBtn = document.querySelector(".uil-search");
            let cancelBtn = document.querySelector(".uil-times");
            let form = document.querySelector("form");

            if ($('.uil-times').hasClass('show')) {
                searchBtn.classList.remove("hide");
                cancelBtn.classList.remove("show");
                form.classList.remove("active");
                // add readonly to input
                form.querySelector("input").readOnly = true;
                // reset input value
                form.querySelector("input").value = "";
                $('#overlay').removeClass('overlay-search');
                $('.overlay-search').fadeOut();

                if ($('body').filter('style')) {
                    $('body').removeAttr('style');
                }
            }

        });

        $(document).on('click', '.mobile-nav .drop-down > a', function (e) {
            e.preventDefault();

            $(this).parent().toggleClass('active');
            $(this).next().slideToggle(300);
        });


        $(document).click(function (e) {
            var container1 = $(".mobile-nav, .mobile-nav-toggle");
            if (!container1.is(e.target) && container1.has(e.target).length === 0) {
                if ($('body').hasClass('mobile-nav-active')) {
                    $('body').removeClass('mobile-nav-active');
                    $('.closeSideBar').removeClass('show');
                    // $('.mobile-nav-toggle i').toggleClass('uil uil-bars icofont-close');
                    $('.mobile-nav-overly').fadeOut();
                }
            }
        });
    } else if ($(".mobile-nav, .mobile-nav-toggle, .closeSideBar").length) {
        $(".mobile-nav, .mobile-nav-toggle,  .closeSideBar").hide();
    }

    // add shadow when scroll background header
    function scrollHeader() {
        const nav = document.getElementById('header')

        // Jadi ketika kita ngescroll >= (Lebih besar sama dengan) 80, maka kasih class yang namanya scroll-header
        if (this.scrollY >= 1) {
            nav.classList.add('scroll-header')
        } else {
            nav.classList.remove('scroll-header')
        }
    }
    window.addEventListener('scroll', scrollHeader)

    // darkmode
    const themeToggle = document.getElementById('theme-toggle')
    const darkTheme = 'dark-theme'
    const ligthTheme = 'uil-lightbulb-alt'

    const selectedTheme = localStorage.getItem('selected-theme')
    const selectedIcon = localStorage.getItem('selected-icon')

    const getCurrentTheme = () => document.body.classList.contains(darkTheme) ? 'dark' : 'light'
    const getCurrentIcon = () => themeToggle.classList.contains(ligthTheme) ? 'uil-moon' : 'uil_sun'

    const changeTitleTooltip = () => {
        const currentTheme = getCurrentTheme()
        if (currentTheme === 'dark') {
            themeToggle.setAttribute('data-original-title', 'Light Theme')
        } else {
            themeToggle.setAttribute('data-original-title', 'Dark Theme')
        }
    }

    if (selectedTheme) {
        document.body.classList[selectedTheme === 'dark' ? 'add' : 'remove'](darkTheme)
        themeToggle.classList[selectedIcon === 'uil-moon' ? 'add' : 'remove'](ligthTheme)

        changeTitleTooltip()
    }

    themeToggle.addEventListener('click', () => {
        document.body.classList.toggle(darkTheme)
        themeToggle.classList.toggle(ligthTheme)

        localStorage.setItem('selected-theme', getCurrentTheme())
        localStorage.setItem('selected-icon', getCurrentIcon())

        changeTitleTooltip()
    });

    //slide
    var slideCarousel = $("#slideCarousel");
    var slideCarouselIndicators = $("#slide-carousel-indicators");
    slideCarousel.find(".carousel-inner").children(".carousel-item").each(function (index) {
        (index === 0) ?
            slideCarouselIndicators.append("<li data-target='#slideCarousel' data-slide-to='" + index +
                "' class='active'></li>") :
            slideCarouselIndicators.append("<li data-target='#slideCarousel' data-slide-to='" + index +
                "'></li>");

        $(this).css("background-image", "url('" + $(this).children('.carousel-background').children(
            'img').attr('src') + "')");
        $(this).children('.carousel-background').remove();
    });

    slideCarousel.on('slid.bs.carousel', function (e) {
        $(this).find('h2').addClass('animate__animated animate__fadeInDown');
        $(this).find('p, .btn-get-started').addClass('animate__animated animate__fadeInUp');
    });

    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.to-the-top').fadeIn('slow');
        } else {
            $('.to-the-top').fadeOut('slow');
        }
    });

    $('.to-the-top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });

    // search


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

    // tooltip
    $(".btn-tooltip-hide").tooltip().on("click", function () {
        $(this).tooltip("hide")
    });

})(jQuery)
