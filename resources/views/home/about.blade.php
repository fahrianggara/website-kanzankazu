<section id="about" class="about">
    <div class="container">

        <div class="section-title">
            <h2>{{ trans('home.about.title.titleAbout') }}</h2>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="img_about loading">
                    <img src="{{ asset('vendor/my-blog/img/home-img/about.jpeg') }}" class="img-fluid">
                </div>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0 content">
                <p>
                    {{ trans('home.about.desc') }}
                </p>

                <h4>
                    {{ trans('home.about.title.titleSkills') }}
                </h4>

                {{-- SKILL SECTION --}}
                <ul id="accordion" class="accordion">
                    <li>
                        <div class="link">
                            <i class="uil uil-arrow"></i>
                            {{ trans('home.about.accTitle.titleTech') }}
                            <i class="uil uil-angle-down"></i>
                        </div>
                        <ul class="submenu">
                            <li>
                                <a href="https://www.w3schools.com/html/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/html.png') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    HTML
                                </a>
                            </li>
                            <li>
                                <a href="https://www.w3schools.com/css/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/css.png') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    CSS
                                </a>
                            </li>
                            <li>
                                <a href="https://www.w3schools.com/php/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/php.svg') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    PHP
                                </a>
                            </li>
                            <li>
                                <a href="https://codeigniter.com/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/ci.png') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    CodeIgniter 4
                                </a>
                            </li>
                            <li>
                                <a href="https://laravel.com/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/laravel.svg') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    Laravel 8
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="open">
                        <div class="link">
                            <i class="uil uil-object-group"></i>
                            {{ trans('home.about.accTitle.titleDesg') }}
                            <i class="uil uil-angle-down"></i>
                        </div>
                        <ul class="submenu" style="display: block;">
                            <li>
                                <a href="https://www.adobe.com/products/photoshop.html" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/photoshop.png') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    Photoshop
                                </a>
                            </li>
                            <li>
                                <a href="https://www.adobe.com/products/photoshop-lightroom.html" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/lr.svg') }}" alt=""
                                        width="25" class="img-fluid d-inline mr-2">
                                    Lightroom
                                </a>
                            </li>
                            <li>
                                <a href="https://www.figma.com/" target="_blank">
                                    <img src="{{ asset('vendor/my-blog/img/home-img/skills/figma.png') }}" alt=""
                                        width="20" class="img-fluid d-inline mr-2">
                                    Figma
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>

    </div>
</section>

@push('js-internal')
    <script>
        $(function() {
            // accordion
            var Accordion = function(el, multiple) {
                this.el = el || {};
                this.multiple = multiple || false;

                // Variables
                var links = this.el.find('.link');
                // Event
                links.on('click', {
                    el: this.el,
                    multiple: this.multiple
                }, this.dropdown)
            }

            Accordion.prototype.dropdown = function(e) {
                var $el = e.data.el;
                $this = $(this),
                    $next = $this.next();

                $next.slideToggle();
                $this.parent().toggleClass('open');

                if (!e.data.multiple) {
                    $el.find('.submenu').not($next).slideUp().parent().removeClass('open');
                };
            }

            var accordion = new Accordion($('#accordion'), false);
        });
    </script>
@endpush
