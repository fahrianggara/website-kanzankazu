@if ($posts->count() >= 1)
    <h2 class="titleMoreBlogs">Blog Terkait</h2>

    <div class="row d-flex flex-row flex-nowrap overflow-auto">
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
                            <div class="img-moredate loading">
                                <a href="{{ route('blog.posts.categories', ['slug' => $tutorials->slug]) }}"
                                    class="img-infodate">{{ $tutorials->title }}</a>
                            </div>
                        @endforeach
                    </div>

                    <div class="link-moreblog loading">
                        <a class="link-textMoreBlog underline"
                            href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                            {{ $post->title . ' - ' . substr($post->description, 0, 45) }}...
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

            $(document).on('click', '.simple-pagination a', function(e) {
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
