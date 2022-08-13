@extends('layouts.blog')

@section('content')
    @if ($user->id == 2)
        <section id="intro" class="intro">
            <div class="intro-container">
                <div class="intro-div">
                    <p data-aos="fade-in" data-aos-delay="100">Hi, my name is</p>
                    <div class="intro-visMis" data-aos="fade-in" data-aos-delay="200">
                        <h1>{{ $user->name }}</h1>
                        <h2><span class="kutip"></span>{{ $user->pf_vision }}.</h2>
                    </div>
                    <div class="intro-desc" data-aos="fade-in" data-aos-delay="300">
                        <span>
                            {{ $user->pf_mission }}
                        </span>
                    </div>
                    <div class="intro-btn" data-aos="fade-in" data-aos-delay="400">
                        <a href="#about" class="btn btn-explore">EXPLORE</a>
                        @if ($user->pf_resume != null)
                            <a href="{{ route('blog.author.resume', ['author' => $user->slug, 'resume' => $user->pf_resume]) }}"
                                target="_blank" class="btn btn-resume">RESUME</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="about section-bg">
            <div class="container">

                <div class="section-title text-center" data-aos="fade-in" data-aos-delay="100">
                    <h2>About me</h2>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="img_about loading" data-aos="fade-in" data-aos-delay="300">
                            @if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image))
                                <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                                    class="img-fluid">
                            @else
                                <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" class="img-fluid">
                            @endif

                        </div>
                    </div>
                    <div class="col-lg-6 pt-4 pt-lg-0 content">

                        <div class="author-sosmed" data-aos="fade-in" data-aos-delay="500">
                            {!! Markdown::convert($user->bio)->getContent() !!}

                            @if ($user->facebook != null)
                                <a target="_blank" href="{{ $user->facebook }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if ($user->twitter != null)
                                <a target="_blank" href="{{ $user->twitter }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if ($user->instagram != null)
                                <a target="_blank" href="{{ $user->instagram }}">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if ($user->github != null)
                                <a target="_blank" href="{{ $user->github }}">
                                    <i class="fab fa-github"></i>
                                </a>
                            @endif
                        </div>

                        <div class="skills">

                            <h4 data-aos="fade-in" data-aos-delay="600">My Skills</h4>
                            <p data-aos="fade-in" data-aos-delay="700">{{ $user->pf_skill_desc }}</p>

                            <ul class="skill-lists" data-aos="fade-in" data-aos-delay="800">
                                @foreach ($skills as $skill)
                                    <li>{{ $skill->title }}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </section>

        @if ($user->portofolios()->count() > 0)
            <section id="gallery" class="gallery">
                <div class="container">
                    <div class="section-title text-center" data-aos="fade-in" data-aos-delay="100">
                        <h2>Projects</h2>
                    </div>

                    {{-- filter image --}}
                    <div class="row">
                        <div class="col-lg-12 d-flex justify-content-center" data-aos="fade-top" data-aos-delay="200">
                            <ul id="gallery-filters">
                                @if ($titleProjects->count() > 1)
                                    <li data-filter="*" class="filter-active">All</li>
                                @endif

                                @if ($titleProjects->count() == 1)
                                    @foreach ($titleProjects as $data)
                                        <li data-filter=".{{ $data->title }}" class="filter-active">{{ $data->title }}
                                        </li>
                                    @endforeach
                                @else
                                    @foreach ($titleProjects as $data)
                                        <li data-filter=".{{ $data->title }}">{{ $data->title }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="row gallery-container">
                        @foreach ($user->portofolios()->get() as $portfolio)
                            <div
                                class="col-lg-4 col-md-6 gallery-item {{ $portfolio->projects()->pluck('title')->first() }}">
                                <div class="gallery-wrap" data-aos="fade-in" data-aos-delay="400">
                                    <div class="img_gallery loading">
                                        @php
                                            if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $portfolio->thumbnail)) {
                                                $thumbnail = asset('vendor/dashboard/image/thumbnail-posts/' . $portfolio->thumbnail);
                                            } else {
                                                $thumbnail = asset('vendor/blog/img/default.png');
                                            }
                                        @endphp

                                        <img src="{{ $thumbnail }}" class="img-fluid" alt="">
                                    </div>
                                    <div class="gallery-info">
                                        <h4>{{ $portfolio->title }}</h4>
                                        <p>
                                            {{ $portfolio->description }}
                                        </p>
                                    </div>

                                    <div class="gallery-links">
                                        <a href="{{ $thumbnail }}" title="{{ $portfolio->title }}"
                                            data-gall="galleryData" class="venobox">
                                            <i class="uil uil-external-link-alt"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <section class="blog section-bg">
            @if ($recommendationPosts->isNotEmpty())
                <div class="container">
                    <div class="section-title title-blog-author">
                        <h2 data-aos="fade-in" data-aos-delay="200">Rekomendasi Blog</h2>
                        <p data-aos="fade-in" data-aos-delay="300">Ada {{ $recommendationPosts->count() }} blog yang
                            direkomendasikan oleh <span class="titleFilter">{{ $user->name }}</span>.</p>
                    </div>

                    <div class="row">
                        @forelse ($recommendationPosts as $recommended)
                            <div class="col-lg-4 col-md-6" data-aos="fade-in" data-aos-delay="400">

                                <article class="entry-thumbnail">
                                    <div class="entry-img loading">
                                        @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail))
                                            <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                                <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail) }}"
                                                    alt="{{ $recommended->post->title }}" class="img-fluid" />
                                            </a>
                                        @else
                                            <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                                <img src="{{ asset('vendor/blog/img/default.png') }}"
                                                    alt="{{ $recommended->post->title }}" class="img-fluid" />
                                            </a>
                                        @endif
                                    </div>

                                    <div class="tag">
                                        @foreach ($recommended->post->tags as $tag)
                                            <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                                                class="badge badge-primary">
                                                {{ $tag->title }}
                                            </a>
                                        @endforeach
                                    </div>

                                    <h2 class="entry-title loading">
                                        <a class="underline"
                                            href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">{{ $recommended->post->title }}</a>
                                    </h2>

                                    <div class="entry-content">
                                        <div class="loading">
                                            <p>
                                                @if (strlen($recommended->post->description) > 150)
                                                    {{ substr($recommended->post->description, 0, 150) }}...
                                                @else
                                                    {{ substr($recommended->post->description, 0, 150) }}
                                                @endif
                                            </p>
                                        </div>
                                    </div>

                                    <div class="entry-meta">
                                        <ul>
                                            <li class="d-flex align-items-center">
                                                @php
                                                    if (file_exists('vendor/dashboard/image/picture-profiles/' . $recommended->post->user->user_image)) {
                                                        $avatar = asset('vendor/dashboard/image/picture-profiles/' . $recommended->post->user->user_image);
                                                    } elseif ($recommended->post->user->status == 'banned') {
                                                        $avatar = asset('vendor/dashboard/image/avatar.png');
                                                    } elseif ($recommended->post->user->provider == 'google' || $recommended->post->user->provider == 'github') {
                                                        $avatar = $recommended->post->user->user_image;
                                                    } else {
                                                        $avatar = asset('vendor/dashboard/image/avatar.png');
                                                    }
                                                @endphp
                                                <div class="author-thumbnail">
                                                    <img class="img-circle img-fluid" src="{{ $avatar }}">
                                                    @if ($recommended->post->user->status == 'banned')
                                                        <span>
                                                            Akun diblokir
                                                        </span>
                                                    @else
                                                        <span>{{ $recommended->post->user->name }}</span>
                                                    @endif
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </article>

                            </div>
                        @empty
                            <div class="container">

                                <div class="col-lg-12">

                                    <div id="empty-blog">

                                        <svg viewBox="0 0 117 117" fill="none" class="iconMeh"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <circle class="face" cx="58.5" cy="58.5" r="57.5"
                                                stroke-width="2" />
                                            <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                            <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                            <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453"
                                                y2="67.065" stroke="white" stroke-width="2" />
                                        </svg>


                                        <p class="text-emptyBlog">
                                            Oops.. sepertinya author <span class="titleFilter">{{ $user->name }}</span>
                                            belum
                                            membuat artikel.
                                        </p>

                                        <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
                                    </div>

                                </div>
                            </div>
                        @endforelse
                    </div>

                </div>
            @endif
        </section>
        <section class="blog">
            <div class="container" id="blog">
                @if ($posts->count() >= 1)
                    <div class="section-title title-blog-author">
                        <h2 data-aos="fade-in" data-aos-delay="100">by {{ $user->name }}.</h2>
                        <p data-aos="fade-in" data-aos-delay="300">Ada {{ $posts->count() }} blog yang ditulis oleh
                            <span class="titleFilter">{{ $user->name }}</span>.
                        </p>
                    </div>
                @endif

                <div class="row">
                    @forelse ($posts as $post)
                        <div class="col-sm-6 col-lg-4 col-md-6">

                            <article class="entry-thumbnail" data-aos="fade-in" data-aos-delay="500">
                                <div class="entry-img ">
                                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                        @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                            <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                                alt="{{ $post->title }}" class="img-fluid" />
                                        @else
                                            <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                                alt="{{ $post->title }}">
                                        @endif
                                    </a>
                                </div>

                                <div class="tag">
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                                            class="badge badge-primary">
                                            {{ $tag->title }}
                                        </a>
                                    @endforeach
                                </div>

                                <h2 class="entry-title ">
                                    <a class="underline"
                                        href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ $post->title }}
                                    </a>
                                </h2>

                                <div class="entry-content">
                                    <div class="">
                                        <p>
                                            @if (strlen($post->description) > 150)
                                                {{ substr($post->description, 0, 150) }}...
                                            @else
                                                {{ substr($post->description, 0, 150) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center">
                                            @php
                                                if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image)) {
                                                    $avatar = asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image);
                                                } elseif ($post->user->status == 'banned') {
                                                    $avatar = asset('vendor/dashboard/image/avatar.png');
                                                } elseif ($post->user->provider == 'google' || $post->user->provider == 'github') {
                                                    $avatar = $post->user->user_image;
                                                } else {
                                                    $avatar = asset('vendor/dashboard/image/avatar.png');
                                                }
                                            @endphp
                                            <div class="author-thumbnail">
                                                <img class="img-circle img-fluid" src="{{ $avatar }}">
                                                @if ($post->user->status == 'banned')
                                                    <span>
                                                        Akun diblokir
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $post->user->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </article>

                        </div>
                    @empty
                        <div class="container">
                            <div class="col-lg-12">

                                <div id="empty-blog">

                                    <svg viewBox="0 0 117 117" fill="none" class="iconMeh"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle class="face" cx="58.5" cy="58.5" r="57.5"
                                            stroke-width="2" />
                                        <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                        <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                        <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453"
                                            y2="67.065" stroke="white" stroke-width="2" />
                                    </svg>

                                    <p class="text-emptyBlog">
                                        Oops.. Belum ada blog yang ditulis.
                                    </p>

                                    <a onclick="buttonBack()" class="buttonBlogNotFound">Kembali</a>
                                </div>

                            </div>
                        </div>
                    @endforelse

                </div>
                @if ($posts->hasPages())
                    {{ $posts->links('vendor.pagination.blog') }}
                @endif
            </div>
        </section>

        <section id="contact" class="contact">

            <div class="container">
                <div class="section-title text-center" data-aos="fade-in" data-aos-delay="150">
                    <h2>Contact me</h2>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 d-flex infos align-items-stretch" data-aos="fade-in" data-aos-delay="350">
                        <div class="row">

                            <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                                <i class="uil uil-map-marker"></i>
                                <h4>{{ trans('home.contact.infos.info1.title') }}</h4>
                                <p>{{ trans('home.contact.infos.info1.subtitle') }}</p>
                            </div>
                            <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                                <i class="uil uil-envelope"></i>
                                <h4>{{ trans('home.contact.infos.info3.title') }}</h4>
                                <a href="mailto:fahriangga30@gmail.com">fahriangga30@gmail.com</a>
                            </div>
                            <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                                <i class="uil uil-facebook"></i>
                                <h4>Facebook</h4>
                                <a href="{{ $user->facebook }}" target="_blank">
                                    fahrianggara
                                </a>
                            </div>
                            <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                                <i class="uil uil-instagram"></i>
                                <h4>{{ trans('home.contact.infos.info4.title') }}</h4>
                                <a href="{{ $user->instagram }}"
                                    target="_blank">{{ trans('home.contact.infos.info4.subtitle') }}</a>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-6 d-flex align-items-stretch contact-form-wrap" data-aos="fade-in"
                        data-aos-delay="550">

                        <form id="formContact" action="{{ route('contact.sendEmail') }}" method="POST"
                            class="form_contact" autocomplete="off">
                            @method('POST')
                            @csrf

                            <div class="form-row">
                                <div class="col-md-6 form-group">
                                    <label for="name"
                                        class="name">{{ trans('home.contact.form.name.label') }}</label>

                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Enter your name here..">
                                    <span id="formContacMe" class="text-danger error-text name_error"></span>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="email" class="email">{{ trans('home.contact.form.email.label') }}
                                        <i class="uil uil-info-circle text-primary" data-toggle="tooltip"
                                            data-placement="top"
                                            title="Please use a valid email, so I can reply to your message.">
                                        </i>
                                    </label>
                                    <input type="text" name="email" id="email" class="form-control"
                                        placeholder="Enter your email here..">
                                    <span id="formContacMe" class="text-danger error-text email_error"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject message</label>

                                <input type="text" class="form-control fm-error-subject" name="subject"
                                    id="subject" placeholder="Enter your subject message here.." />
                                <span id="formContacMe" class="text-danger error-text subject_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="message">{{ trans('home.contact.form.message.label') }}</label>

                                <textarea onkeyup="countCharMessage(this)" class="form-control fm-error-message" name="message" id="message"
                                    rows="8" placeholder="Enter your message here.."></textarea>
                                <span class="float-right" id="countCharMessage"></span>
                                <span id="formContacMe" class="text-danger error-text message_error"></span>
                            </div>

                            <div class="text-center mt-5">
                                <button type="submit" class="btnSend">Send message</button>
                            </div>
                        </form>

                    </div>

                </div>
            </div>

        </section>

        @push('css-internal')
            <link rel="stylesheet" href="{{ asset('vendor/blog/assets/venobox/venobox.css') }}">
            <link rel="stylesheet" href="{{ asset('vendor/blog/assets/aos/aos.css') }}">
        @endpush
        @push('js-internal')
            <script src="{{ asset('vendor/blog/assets/aos/aos.js') }}"></script>
            <script src="{{ asset('vendor/blog/assets/venobox/venobox.min.js') }}"></script>
            <script src="{{ asset('vendor/blog/assets/isotope-layout/isotope.pkgd.min.js') }}"></script>

            <script>
                // Init AOS
                function aos_init() {
                    AOS.init({
                        duration: 500,
                        easing: "ease-in-out",
                        once: true,
                        mirror: false
                    });
                }
                $(window).on('load', function() {
                    aos_init();
                });

                function countCharMessage(val) {
                    let max = 500
                    let limit = val.value.length;
                    if (limit >= max) {
                        val.value = val.value.substring(0, max);
                        $('#countCharMessage').text('You have reached the limit');
                        $('#countCharMessage').addClass('text-danger');
                    } else {
                        var char = max - limit;
                        $('#countCharMessage').text(char + ' characters left');
                        $('#countCharMessage').removeClass('text-danger');
                    };
                }

                // hide charNum when input is empty
                $('#message').on('keyup', function() {
                    if ($(this).val().length == 0) {
                        $('#countCharMessage').text('');
                    } else {
                        countCharMessage(this);
                    }
                });

                $(function() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#formContact').on('submit', function(e) {
                        e.preventDefault();

                        $.ajax({
                            method: $(this).attr('method'),
                            url: $(this).attr('action'),
                            data: {
                                "name": $('#name').val(),
                                "email": $('#email').val(),
                                "subject": $('#subject').val(),
                                "message": $('#message').val()
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('.btnSend').attr('disabled', true);
                                $('.btnSend').html('<i class="fas fa-spin fa-spinner"></i>');

                                $(document).find('span.error-text').text('');
                            },
                            complete: function() {
                                $('.btnSend').attr('disabled', false);
                                $('.btnSend').html('Send message');
                            },
                            success: function(response) {
                                if (response.status == 400) {
                                    $.each(response.messages, function(key, value) {
                                        $('#formContacMe.' + key + '_error').text(value[0]);
                                    });
                                } else {
                                    $('#formContact')[0].reset();
                                    $('#charNum').text('');
                                    $('#formContact').find('span.error-text').text('');
                                    alertify.delay(4000).log(response.message);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });

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

                    // Porfolio isotope and filter
                    $(window).on('load', function() {
                        var galleryIsotope = $('.gallery-container').isotope({
                            itemSelector: '.gallery-item',
                            layoutMode: 'fitRows'
                        });

                        $('#gallery-filters li').on('click', function() {
                            $("#gallery-filters li").removeClass('filter-active');
                            $(this).addClass('filter-active');

                            galleryIsotope.isotope({
                                filter: $(this).data('filter')
                            });
                        });

                        // Initiate venobox (lightbox feature used in portofilo)
                        $(document).ready(function() {
                            $('.venobox').venobox({
                                framewidth: '1000px',
                                frameheight: 'auto',
                                numeratio: true,
                                infinigall: true,
                                share: ['download'],
                                spinner: 'cube-grid',
                                spinColor: '#00b2cc',
                                titlePosition: 'bottom',
                            });
                        });
                    });
                });
            </script>
        @endpush
    @else
        <div class="authorSec section-bg">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-12 text-center authorBlog">
                        <div class="entry-img loading">
                            @if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image))
                                <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                                    class="img-fluid img-round" />
                            @elseif ($user->provider == 'google' || $user->provider == 'github')
                                <img src="{{ $user->user_image }}" class="img-fluid img-round" />
                            @else
                                <img src="{{ asset('vendor/dashboard/image/avatar.png') }}"
                                    class="img-fluid img-round" />
                            @endif
                        </div>

                        <h3 class="author-title">
                            {{ $user->name }}
                        </h3>

                        <p class="author-bio">
                            @if ($user->bio != null)
                                {{ $user->bio }}
                            @else
                                KanzanKazu
                            @endif
                        </p>

                        <div class="author-sosmed">
                            @if ($user->facebook != null)
                                <a target="_blank" href="{{ $user->facebook }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if ($user->twitter != null)
                                <a target="_blank" href="{{ $user->twitter }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if ($user->instagram != null)
                                <a target="_blank" href="{{ $user->instagram }}">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if ($user->github != null)
                                <a target="_blank" href="{{ $user->github }}">
                                    <i class="fab fa-github"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if ($recommendationPosts->isNotEmpty())
            <div class="container">
                <div class="section-title">
                    <h2>Rekomendasi Blog</h2>
                    <p>Ada {{ $recommendationPosts->count() }} blog yang direkomendasikan oleh
                        <span class="titleFilter">{{ $user->name }}
                        </span>.
                    </p>
                </div>

                <div class="row">
                    @forelse ($recommendationPosts as $recommended)
                        <div class="col-lg-4 col-md-6">

                            <article class="entry-thumbnail">
                                <div class="entry-img loading">
                                    @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail))
                                        <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                            <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $recommended->post->thumbnail) }}"
                                                alt="{{ $recommended->post->title }}" class="img-fluid" />
                                        </a>
                                    @else
                                        <a href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">
                                            <img src="{{ asset('vendor/blog/img/default.png') }}"
                                                alt="{{ $recommended->post->title }}" class="img-fluid" />
                                        </a>
                                    @endif
                                </div>

                                <div class="tag">
                                    @foreach ($recommended->post->tags as $tag)
                                        <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                                            class="badge badge-primary">
                                            {{ $tag->title }}
                                        </a>
                                    @endforeach
                                </div>

                                <h2 class="entry-title loading">
                                    <a class="underline"
                                        href="{{ route('blog.detail', ['slug' => $recommended->post->slug]) }}">{{ $recommended->post->title }}</a>
                                </h2>

                                <div class="entry-content">
                                    <div class="loading">
                                        <p>
                                            @if (strlen($recommended->post->description) > 150)
                                                {{ substr($recommended->post->description, 0, 150) }}...
                                            @else
                                                {{ substr($recommended->post->description, 0, 150) }}
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="entry-meta">
                                    <ul>
                                        <li class="d-flex align-items-center">
                                            @php
                                                if (file_exists('vendor/dashboard/image/picture-profiles/' . $recommended->post->user->user_image)) {
                                                    $avatar = asset('vendor/dashboard/image/picture-profiles/' . $recommended->post->user->user_image);
                                                } elseif ($recommended->post->user->status == 'banned') {
                                                    $avatar = asset('vendor/dashboard/image/avatar.png');
                                                } elseif ($recommended->post->user->provider == 'google' || $recommended->post->user->provider == 'github') {
                                                    $avatar = $recommended->post->user->user_image;
                                                } else {
                                                    $avatar = asset('vendor/dashboard/image/avatar.png');
                                                }
                                            @endphp
                                            <div class="author-thumbnail">
                                                <img class="img-circle img-fluid" src="{{ $avatar }}">

                                                @if ($recommended->post->user->status == 'banned')
                                                    <span>
                                                        Akun diblokir
                                                    </span>
                                                @else
                                                    <span>
                                                        {{ $recommended->post->user->name }}
                                                    </span>
                                                @endif
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </article>

                        </div>
                    @empty
                        <div class="container">

                            <div class="col-lg-12">

                                <div id="empty-blog">

                                    <svg viewBox="0 0 117 117" fill="none" class="iconMeh"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle class="face" cx="58.5" cy="58.5" r="57.5"
                                            stroke-width="2" />
                                        <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                        <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                        <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453"
                                            y2="67.065" stroke="white" stroke-width="2" />
                                    </svg>


                                    <p class="text-emptyBlog">
                                        Oops.. sepertinya author <span class="titleFilter">{{ $user->name }}</span>
                                        belum
                                        membuat artikel.
                                    </p>

                                    <a id="buttonBack" class="buttonBlogNotFound">Kembali</a>
                                </div>

                            </div>
                        </div>
                    @endforelse
                </div>

            </div>
        @endif

        <div class="container">
            @if ($posts->count() >= 1)
                <div class="section-title">
                    <h2>by {{ $user->name }}.</h2>
                    <p>Ada {{ $posts->count() }} blog yang ditulis oleh <span
                            class="titleFilter">{{ $user->name }}</span>.
                    </p>
                </div>
            @endif

            <div class="row">
                @forelse ($posts as $post)
                    <div class="col-lg-4 col-md-6">

                        <article class="entry-thumbnail">
                            <div class="entry-img loading">
                                @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                        <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                            alt="{{ $post->title }}" class="img-fluid" />
                                    </a>
                                @else
                                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                        <img src="{{ asset('vendor/blog/img/default.png') }}"
                                            alt="{{ $post->title }}" class="img-fluid" />
                                    </a>
                                @endif
                            </div>

                            <div class="tag">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ route('blog.posts.tags', ['slug' => $tag->slug]) }}"
                                        class="badge badge-primary">
                                        {{ $tag->title }}
                                    </a>
                                @endforeach
                            </div>

                            <h2 class="entry-title loading">
                                <a class="underline"
                                    href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                            </h2>

                            <div class="entry-content">
                                <div class="loading">
                                    <p>
                                        @if (strlen($post->description) > 150)
                                            {{ substr($post->description, 0, 150) }}...
                                        @else
                                            {{ substr($post->description, 0, 150) }}
                                        @endif
                                    </p>
                                </div>
                            </div>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        @php
                                            if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image)) {
                                                $avatar = asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image);
                                            } elseif ($post->user->status == 'banned') {
                                                $avatar = asset('vendor/dashboard/image/avatar.png');
                                            } elseif ($post->user->provider == 'google' || $post->user->provider == 'github') {
                                                $avatar = $post->user->user_image;
                                            } else {
                                                $avatar = asset('vendor/dashboard/image/avatar.png');
                                            }
                                        @endphp
                                        <div class="author-thumbnail">
                                            <img class="img-circle img-fluid" src="{{ $avatar }}">
                                            @if ($post->user->status == 'banned')
                                                <span>
                                                    Akun diblokir
                                                </span>
                                            @else
                                                <span>
                                                    {{ $post->user->name }}
                                                </span>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </article>

                    </div>
                @empty
                    <div class="container">

                        <div class="col-lg-12">

                            <div id="empty-blog">

                                <svg viewBox="0 0 117 117" fill="none" class="iconMeh"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle class="face" cx="58.5" cy="58.5" r="57.5"
                                        stroke-width="2" />
                                    <circle class="eye" cx="40.5" cy="40.5" r="8.5" />
                                    <circle class="eye" cx="77.5" cy="40.5" r="8.5" />
                                    <line class="mouth" x1="32.6453" y1="89.065" x2="90.6453" y2="67.065"
                                        stroke="white" stroke-width="2" />
                                </svg>


                                <p class="text-emptyBlog">
                                    Oops.. sepertinya author <span class="titleFilter">{{ $user->name }}</span> belum
                                    membuat artikel.
                                </p>

                                <a onclick="buttonBack()" class="buttonBlogNotFound">Kembali</a>
                            </div>

                        </div>
                    </div>
                @endforelse
            </div>
            @if ($posts->hasPages())
                {{ $posts->links('vendor.pagination.blog') }}
            @endif
        </div>
    @endif
@endsection
