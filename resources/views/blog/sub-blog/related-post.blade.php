@if ($posts->count() >= 1)
    <h2 class="titleMoreBlogs">Blog Terkait</h2>

    <div id="postsRelated" class="row d-flex flex-row flex-nowrap overflow-auto">
        @forelse ($posts as $post)
            <div id="relatedPost" class="col-lg-4 col-md-6 col-7">
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
                        @foreach ($post->tutorials as $tutorials)
                            <div class="img-moredate">
                                <a href="{{ route('blog.posts.tutorials.author', ['slug' => $tutorials->slug, 'user' => $post->user->slug]) }}"
                                    class="img-infodate"
                                    style="background: {{ $tutorials->bg_color }}; box-shadow: 0 0 5px rgba(0, 0, 0, 1);">{{ $tutorials->title }}
                                </a>
                            </div>
                        @endforeach
                    </div>

                    <div class="link-moreblog loading">
                        <a class="link-textMoreBlog underline"
                            href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                            @if (strlen($post->title) > 20)
                                {{ substr($post->title, 0, 20) }}..
                            @else
                                {{ substr($post->title, 0, 20) }}
                            @endif
                        </a>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-lg-12">
                <p class="text-center">Belum ada blog yang terkait.</p>
            </div>
        @endforelse

    </div>

    @if ($posts->hasPages())
        {{ $posts->links('vendor.pagination.simpleBlog') }}
    @endif
@endif


@push('js-internal')
    <script>
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');

                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getRelated(page);
                }
            }
        });

        $(document).ready(function() {
            // $('#postsRelated').mousewheel(function (e, delta) {
            //     this.scrollLeft -= (delta * 80);
            //     e.preventDefault();
            // });

            $(document).on('click', '#related.simple-pagination a', function(e) {
                e.preventDefault();

                $('li').removeClass('active');
                $(this).parent('li').addClass('active');

                var url = $(this).attr('href');
                var page = $(this).attr('href').split('page=')[1];

                getRelated(page);
            });

        });


        function getRelated(page) {
            $.ajax({
                type: "get",
                url: "?page=" + page,
                dataType: "html",
                success: function(posts) {
                    $('#relatedPost').empty().html(posts);

                    // add class active nav menu "blog"
                    $('.nav-menu li.blogDetailActive').addClass('active');
                    // Tooltip
                    $(".btn-tooltip-hide").tooltip().on("click", function() {
                        $(this).tooltip("hide")
                    });
                }
            });

            return false;
        }
    </script>
@endpush
