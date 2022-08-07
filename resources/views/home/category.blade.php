<section id="category" class="blog">
    <div class="container">
        <div class="section-title">
            <h2>Mau lihat kategori apa hari ini?</h2>
            <p>Temukan kategori berdasarkan minatmu.</p>
        </div>

        <div class="row d-flex flex-row flex-nowrap overflow-auto">
            @forelse ($categories as $category)
                <div class="col-lg-4 col-md-7 col-10 col-sm-8 align-items-stretch">

                    <article class="entry-thumbnail">
                        <div class="entry-img loading">
                            <a href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">
                                @if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail))
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail) }}"
                                        alt="{{ $category->title }}" class="img-fluid" />
                                @else
                                    <img class="img-fluid" src="{{ asset('vendor/blog/img/default.png') }}"
                                        alt="{{ $category->title }}">
                                @endif
                            </a>
                        </div>

                        <h2 class="entry-title loading">
                            <a class="underline"
                                href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}">{{ $category->title }}
                            </a>
                        </h2>

                        {{-- <div class="entry-meta">
                            <ul>
                                <li class="d-flex align-items-center">
                                    <div class="loading">
                                        <i class="uil uil-calendar-alt"></i>
                                        <span>{{ $category->created_at->format('j M, Y') }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div> --}}

                        <div class="entry-content">
                            <div class="loading">
                                <p>
                                    @if ($category->description == null)
                                        Kategori blog postingan tentang {{ $category->title }}
                                    @else
                                        @if (strlen($category->description) > 150)
                                            {{ substr($category->description, 0, 150) }}...
                                        @else
                                            {{ substr($category->description, 0, 150) }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                            {{-- <div class="read-more loading">
                                <a href=" {{ route('blog.posts.categories', ['slug' => $category->slug]) }}">
                                    Lihat Blog
                                </a>
                            </div> --}}
                        </div>
                    </article>

                </div>
            @empty
                <div class="col-12">
                    <h4 class="text-center">
                        Oops.. Sepertinya kategori-nya belum dibuat.
                    </h4>
                </div>
            @endforelse
        </div>
        @if ($categories->count() >= 3)
            <div>
                <a href="{{ route('blog.categories') }}" class="btn-blog">
                    Lihat Kategori Lainnya
                </a>
            </div>
        @endif
    </div>
</section>
