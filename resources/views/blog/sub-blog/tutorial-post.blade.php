@if ($tutoPosts->count() >= 2)
    @foreach ($post->tutorials as $item)
        <h2 class="titleMoreBlogs">Tutorial lainnya dari <span style="color: {{$item->bg_color}}">{{ $item->title }}</span></h2>
    @endforeach

    <div id="tutorialRelated" class="row d-flex flex-row flex-nowrap overflow-auto">
        @forelse ($tutoPosts as $post)
            <div id="relatedTuto" class="col-lg-4 col-md-6 col-7">
                <div class="post-related">
                    <div class="img-moreBlog img-container">
                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                            @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                <div class="img-container">
                                    <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                        alt="{{ $post->title }}" class="img-fluid" />
                                </div>
                            @else
                                <div class="img-container">
                                    <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                        class="img-fluid">
                                </div>
                            @endif
                        </a>
                        @if (request()->is('blog/' . $post->slug))
                            <div class="img-moredate loading">
                                <span class="img-read">Sedang Dibaca</span>
                            </div>
                        @endif
                    </div>

                    <div class="link-moreblog loading">
                        <a class="link-textMoreBlog underline {{ request()->is('blog/' . $post->slug) ? 'active' : '' }}"
                            href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                            {{ '#' . $loop->iteration . ' - ' . $post->title }}
                        </a>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-lg-12">
                <p class="text-center">Belum ada tutorial.</p>
            </div>
        @endforelse

    </div>
@endif

@push('js-internal')
    <script>
        $(function() {
            $('#tutorialRelated').mousewheel(function (e, delta) {
                this.scrollLeft -= (delta * 80);
                e.preventDefault();
            });
        })
    </script>
@endpush
