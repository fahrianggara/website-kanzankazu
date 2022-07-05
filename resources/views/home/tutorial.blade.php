<section id="tutorial" class="blog">
    <div class="container">
        <div class="section-title">
            <h2>Mau belajar ngoding apa?</h2>
            <p>Temukan tutorial berdasarkan minatmu.</p>
        </div>

        <div class="row d-flex flex-row flex-nowrap overflow-auto">
            @forelse ($tutorials as $tutorial)
                <div class="col-lg-4 col-md-7 col-10 col-sm-8 align-items-stretch">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                @if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail))
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail) }}"
                                        alt="{{ $tutorial->title }}" class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                        alt="{{ $tutorial->title }}">
                                @endif
                            </a>
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">{{ $tutorial->title }}
                            </a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-calendar-alt"></i>
                                        <span>{{ $tutorial->created_at->format('j M, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    @if ($tutorial->description == null)
                                        Seputar tutorial tentang {{ $tutorial->title }}
                                    @else
                                        @if (strlen($tutorial->description) > 150)
                                            {{ substr($tutorial->description, 0, 150) }}...
                                        @else
                                            {{ substr($tutorial->description, 0, 150) }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                            <div class="read-more loading">
                                <a href=" {{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}">
                                    Lihat Tutorial
                                </a>
                            </div>
                        </div>
                    </article>

                </div>
            @empty
                <div class="col-12">
                    <h4 class="text-center">
                        Oops.. Sepertinya tutorial-nya belum dibuat.
                    </h4>
                </div>
            @endforelse
        </div>
        @if ($tutorials->count() >= 3)
            <div>
                <a href="{{ route('blog.tutorials') }}" class="btn-blog">
                    Lihat Tutorial Lainnya
                </a>
            </div>
        @endif
    </div>
</section>
