<section id="blog" class="blog">
    <div class="container">
        <div class="section-title">
            <h2>{{ trans('home.navbar.blog') }}</h2>
            <div class="">
                <p>
                    {{ trans('home.blog.blogDesc') }}
                    <a href="{{ route('blog.home') }}"
                        class="underline">{{ trans('home.blog.blogLinkDesc') }}</a>
                    <i class="uil uil-external-link-alt"></i>
                </p>
            </div>
        </div>

        <div class="row">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                                @if (file_exists(public_path($post->thumbnail)))
                                    <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                        class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/my-blog/img/noimage.jpg') }}"
                                        alt="{{ $post->title }}">
                                @endif
                            </a>
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="icofont-user"></i>
                                        <a class="underline iconAuthor"
                                            href="{{ route('blog.author', ['author' => $post->user->slug]) }}">{{ $post->user->name }}</a>
                                    </div>
                                </li>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-calendar-alt"></i>
                                        <span>{{ $post->created_at->format('j M, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    {{ substr($post->description, 0, 200) }}...
                                </p>
                            </div>
                            <div class="read-more loading">
                                <a href=" {{ route('blog.detail', ['slug' => $post->slug]) }}">
                                    {{ trans('blog.button.btnDetail') }}
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            @empty
                <div class="col-12">
                    <h4 class="text-center">
                        {{ trans('blog.no-data.blogs') }}
                    </h4>
                </div>
            @endforelse

        </div>
        <div class="text-center">
            <a href="{{ route('blog.home') }}" class="btn-blog">
                {{ trans('home.blog.buttonToBlog') }}
            </a>
        </div>
    </div>
</section>
