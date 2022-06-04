<section id="blog" class="blog section-bg">
    <div class="container">
        <div class="section-title">
            <h2>Apa yang baru di {{ $setting->site_name }}?</h2>
            <p>Baca blog terbaru yang masih hangat.</p>
        </div>

        <div class="row d-flex flex-row flex-nowrap overflow-auto">
            @forelse ($posts as $post)
                <div class="col-lg-4 col-md-7 col-10 col-sm-8">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
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
                                    Baca Selengkapnya
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            @empty
                <div class="col-12">
                    <h4 class="text-center">
                        Oops.. sepertinya blog-nya belum dibuat.
                    </h4>
                </div>
            @endforelse

        </div>
        @if ($posts->count() >= 3)
            <div class="">
                <a href="{{ route('blog.home') }}" class="btn-blog">
                    Lihat Blog Lainnya
                </a>
            </div>
        @endif
    </div>
</section>
