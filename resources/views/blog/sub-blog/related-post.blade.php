<h2 class="titleMoreBlogs">{{ trans('blog.title.relatedTitle') }}</h2>

<div class="row d-flex flex-row flex-nowrap overflow-auto">
    @forelse ($posts as $post)
        <div id="relatedPost" class="col-lg-4 col-md-6 col-7">
            <div class="post-related">
                <div class="img-moreBlog loading">
                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                        @if (file_exists(public_path($post->thumbnail)))
                            <div class="img-container">
                                <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}"
                                    class="img-fluid" />
                            </div>
                        @else
                            <div class="img-container">
                                <img src="{{ asset('vendor/my-blog/img/noimage.jpg') }}" alt="{{ $post->title }}"
                                    class="img-fluid">
                            </div>
                        @endif
                    </a>
                    {{-- @foreach ($post->category as $category)
                        <div class="img-moredate loading">
                            <a href="{{ route('blog.posts.categories', ['slug' => $category->slug]) }}"
                                class="img-infodate">{{ $category->title }}</a>
                        </div>
                    @endforeach --}}
                </div>

                <div class="link-moreblog loading">
                    <a class="link-textMoreBlog underline" href="{{ route('blog.detail', ['slug' => $post->slug]) }}">
                        {{ $post->title . ' - ' . substr($post->description, 0, 45) }}...
                    </a>
                </div>
            </div>
        </div>

    @empty
        <div class="col-lg-12">
            <p class="text-center">{{ trans('blog.no-data.norelated') }}</p>
        </div>
    @endforelse

</div>

@if ($posts->hasPages())
    {{ $posts->links('vendor.pagination.simpleBlog') }}
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

                const moreImages = document.querySelectorAll('.img-moreBlog');
                const moreLinks = document.querySelectorAll('.link-moreblog');
                const moreDates = document.querySelectorAll('.img-moredate');
                const moreImgs = document.querySelectorAll('.img-moreBlog img');
                const moreLnks = document.querySelectorAll('.link-moreblog .link-textMoreBlog');
                // REMOVE CLASS LOADING
                moreImages.forEach((moreImage) => {
                    moreImage.classList.add('loading');
                });
                moreLinks.forEach((moreLink) => {
                    moreLink.classList.add('loading');
                });
                moreDates.forEach((moreDate) => {
                    moreDate.classList.add('loading');
                });
                // SHOW CONTENT
                moreImgs.forEach((moreImg) => {
                    moreImg.style.visibility = 'hidden';
                })
                moreLnks.forEach((moreLnk) => {
                    moreLnk.style.visibility = "hidden";
                })

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

                    // Remove class loading
                    $('.img-moreBlog').removeClass('loading');
                    $('.link-moreblog').removeClass('loading');
                    $('.img-moredate').removeClass('loading');
                    // Display blog
                    $('.img-moreBlog img').css('visibility', 'visible');
                    $('.link-moreblog .link-textMoreBlog').css('visibility', 'visible');

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
