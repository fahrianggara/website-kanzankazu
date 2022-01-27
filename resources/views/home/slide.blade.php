<section id="slide">
    <div class="slide-container">
        <div id="slideCarousel" class="carousel slide carousel-fade" data-ride="carousel">

            <ol class="carousel-indicators" id="slide-carousel-indicators"></ol>

            <div class="carousel-inner" role="listbox">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="carousel-background"><img
                            src="{{ asset('vendor/my-blog/img/home-img/slide/slide2.jpeg') }}" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2 class="animate__animated animate__fadeInDown">
                                {{ trans('home.slider.title.one') }}
                            </h2>
                            <p class="animate__animated animate__fadeInUp">
                                {{ trans('home.slider.subtitle.one') }}
                            </p>
                            <a href="#about"
                                class="btn-get-started btn_links animate__animated animate__fadeInUp scrollto">
                                {{ trans('home.slider.button') }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="carousel-background"><img
                            src="{{ asset('vendor/my-blog/img/home-img/slide/slide5.jpeg') }}" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2 class="animate__animated animate__fadeInDown"> {{ trans('home.slider.title.two') }}
                            </h2>
                            <p class="animate__animated animate__fadeInUp">{{ trans('home.slider.subtitle.two') }}</p>
                            <a href="#about"
                                class="btn-get-started btn_links animate__animated animate__fadeInUp scrollto">
                                {{ trans('home.slider.button') }}</a>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <div class="carousel-background"><img
                            src="{{ asset('vendor/my-blog/img/home-img/slide/slide3.jpeg') }}" alt=""></div>
                    <div class="carousel-container">
                        <div class="carousel-content">
                            <h2 class="animate__animated animate__fadeInDown"> {{ trans('home.slider.title.three') }}
                            </h2>
                            <p class="animate__animated animate__fadeInUp">{{ trans('home.slider.subtitle.three') }}
                            </p>
                            <a href="#about"
                                class="btn-get-started btn_links animate__animated animate__fadeInUp scrollto">
                                {{ trans('home.slider.button') }}</a>
                        </div>
                    </div>
                </div>

            </div>

            <a class="carousel-control-prev" href="#slideCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon icofont-thin-double-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>

            <a class="carousel-control-next" href="#slideCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon icofont-thin-double-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
    </div>
</section>
