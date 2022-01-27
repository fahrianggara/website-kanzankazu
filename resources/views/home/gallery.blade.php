<section id="gallery" class="gallery section-bg">
    <div class="container">
        <div class="section-title">
            <h2>{{ trans('home.gallery.title') }}</h2>
        </div>

        {{-- filter image --}}
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center">
                <ul id="gallery-filters">
                    <li data-filter="*" class="filter-active">{{ trans('home.gallery.filter.all') }}</li>
                    <li data-filter=".filter-family">{{ trans('home.gallery.filter.family') }}</li>
                    <li data-filter=".filter-friend">{{ trans('home.gallery.filter.friend') }}</li>
                    <li data-filter=".filter-nature">{{ trans('home.gallery.filter.nature') }}</li>
                </ul>
            </div>
        </div>

        {{-- gallery content --}}
        <div class="row gallery-container">

            <div class="col-lg-4 col-md-6 gallery-item filter-family">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/family1.jpeg') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.family') }}</h4>
                        <p>{{ trans('home.gallery.filter.family') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/family1.jpeg') }}"
                            title="{{ trans('home.gallery.filter.family') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item filter-friend">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/yadika.jpeg') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.friend') }}</h4>
                        <p>{{ trans('home.gallery.filter.friend') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/yadika.jpeg') }}"
                            title="{{ trans('home.gallery.filter.friend') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item filter-nature">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/nature1.jpeg') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.nature') }}</h4>
                        <p>{{ trans('home.gallery.filter.nature') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/nature1.jpeg') }}"
                            title="{{ trans('home.gallery.filter.nature') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item filter-friend">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/cim.jpeg') }}" class="img-fluid"
                            alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.friend') }}</h4>
                        <p>{{ trans('home.gallery.filter.friend') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/cim.jpeg') }}"
                            title="{{ trans('home.gallery.filter.friend') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item filter-nature">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/nature2.jpeg') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.nature') }}</h4>
                        <p>{{ trans('home.gallery.filter.nature') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/nature2.jpeg') }}"
                            title="{{ trans('home.gallery.filter.nature') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 gallery-item filter-family">
                <div class="gallery-wrap">
                    <div class="img_gallery loading">
                        <img src="{{ asset('vendor/my-blog/img/home-img/gallery/family2.jpg') }}"
                            class="img-fluid" alt="">
                    </div>
                    <div class="gallery-info">
                        <h4>{{ trans('home.gallery.filter.family') }}</h4>
                        <p>{{ trans('home.gallery.filter.family') }}
                        </p>
                    </div>
                    <div class="gallery-links">
                        <a href="{{ asset('vendor/my-blog/img/home-img/gallery/family2.jpg') }}"
                            title="{{ trans('home.gallery.filter.family') }}" data-gall="galleryData"
                            class="venobox"><i class="uil uil-external-link-alt"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
