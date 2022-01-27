<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 footer-info">
                    <div class="title-footer">
                        <h3>{{ trans('blog.footer.title.about') }}</h3>
                    </div>
                    <p>
                        {{ trans('blog.footer.footerAbout') }}
                    </p>
                    <div class="social-links">
                        <a href="https://twitter.com/Anggaaeee" target="_blank" class="twitter">
                            <i class="uil uil-twitter"></i>
                        </a>
                        <a href="https://web.facebook.com/fahri.anggara.12" target="_blank" class="facebook">
                            <i class="uil uil-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/f.anggae/" target="_blank" class="instagram">
                            <i class="uil uil-instagram"></i>
                        </a>
                        <a href="mailto:fahrianggara@protonmail.com">
                            <i class="uil uil-envelope"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 footer-post">
                    <div class="title-footer">
                        <h3>{{ trans('blog.footer.title.postPopular') }}</h3>
                    </div>

                    <div class="popular-post">
                        {{-- Foreach --}}

                        @foreach ($footerPost as $post)
                            <div class="post-item clearfix">
                                <div class="post-img loading">
                                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                        class="img"
                                        style="background-image: url({{ asset($post->thumbnail) }})"></a>
                                </div>
                                <div class="post-info">
                                    <div class="post-title loading">
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                            class="m-0 underline text-links {{ request()->is('blog/' . $post->slug) ? 'active' : '' }}">
                                            {{ $post->title . ' - ' . substr($post->description, 0, 50) }}...
                                        </a>
                                    </div>
                                    <div class="post-time text-muted loading">
                                        <p class="mt-1 text-time">{{ $post->created_at->format('j M, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="col-lg-4 col-md-12">
                    <div class="title-footer">
                        <h3>{{ trans('blog.footer.title.quickLinks') }}</h3>
                    </div>
                    <div class="row footer-links">
                        <ul class="col-lg-6 col-md-6">
                            <p class="title-links">{{ trans('blog.navbar.homepage') }}</p>

                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline" href="{{ route('homepage') }}#about">{{ trans('home.navbar.about') }}</a>
                            </li>
                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline" href="{{ route('homepage') }}#gallery">{{ trans('home.navbar.gallery') }}</a>
                            </li>
                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline" href="{{ route('homepage') }}#contact">{{ trans('home.navbar.contact') }}</a>
                            </li>
                        </ul>

                        <ul class="col-lg-6 col-md-6">
                            <p class="title-links">{{ trans('home.navbar.blog') }}</p>

                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline {{ set_active(['blog.home', 'blog.detail', 'blog.search', 'blog.author', 'blog.monthYear']) }}"
                                    href="{{ route('blog.home') }}">
                                    {{ trans('blog.navbar.posts') }}
                                </a>
                            </li>
                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline {{ set_active(['blog.categories', 'blog.posts.categories']) }}"
                                    href="{{ route('blog.categories') }}">{{ trans('blog.navbar.categories') }}
                                </a>
                            </li>
                            <li><i class="uil uil-angle-right"></i>
                                <a class="underline {{ set_active(['blog.tags', 'blog.posts.tags']) }}"
                                    href="{{ route('blog.tags') }}">{{ trans('blog.navbar.tags') }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-bottom">
            {{ config('app.name') }} - {{ trans('blog.footer.footerBottom') }} <span>❤</span>
        </div>
    </div>

</footer>
