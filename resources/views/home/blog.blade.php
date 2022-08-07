@if ($posts->count() >= 1)
    <section id="blog" class="blog">
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
                                <p>
                                    @if (strlen($post->description) > 150)
                                        {{ substr($post->description, 0, 150) }}...
                                    @else
                                        {{ substr($post->description, 0, 150) }}
                                    @endif
                                </p>
                            </div>

                            <div class="entry-meta">
                                <ul>
                                    <li class="d-flex align-items-center">
                                        @php
                                            if (file_exists('vendor/dashboard/image/picture-profiles/' . $post->user->user_image)) {
                                                $avatar = asset('vendor/dashboard/image/picture-profiles/' . $post->user->user_image);
                                            } elseif ($post->user->status == 'banned') {
                                                $avatar = asset('vendor/blog/img/avatar.png');
                                            } elseif ($post->user->provider == 'google' || $post->user->provider == 'github') {
                                                $avatar = $post->user->user_image;
                                            } else {
                                                $avatar = asset('vendor/blog/img/avatar.png');
                                            }
                                        @endphp
                                        <div class="author-thumbnail">
                                            <img class="img-circle img-fluid" src="{{ $avatar }}">
                                            @if ($post->user->status == 'banned')
                                                <a class="underline iconAuthor" href="javascript:void(0)"
                                                    style="cursor: default">Akun
                                                    diblokir
                                                </a>
                                            @else
                                                <a class="underline iconAuthor"
                                                    href="{{ route('blog.author', ['author' => $post->user->slug]) }}">{{ $post->user->name }}</a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
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
@endif
