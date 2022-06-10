<section id="home" class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 banner_image">
                {{-- @if (file_exists('vendor/blog/img/home-img/' . $setting->image_banner))
                    <img src="{{ asset('vendor/blog/img/home-img/' . $setting->image_banner) }}" width="300"
                        height="300">
                @else
                    <img src="{{ asset('vendor/blog/img/home-img/banner.png') }}" width="310" height="310">
                @endif --}}

            </div>

            <div class="col-lg-8 banner_content justify-content-center">
                <h3>{{ $setting->site_name }}</h3>
                <p>
                    {{ $setting->site_description }}
                </p>
                <a href="#blog" class="bannerLinks">
                    Explore
                </a>
            </div>
        </div>
    </div>
</section>
