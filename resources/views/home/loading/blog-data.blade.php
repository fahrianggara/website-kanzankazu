@forelse ($posts as $post)
    <div class="col-lg-4 col-md-6 d-flex align-items-stretch" data-aos="fade-up">

        <article class="entry-thumbnail">
            <div class="entry-img">
                @if (file_exists(public_path($post->thumbnail)))
                    <img src="{{ asset($post->thumbnail) }}" alt="{{ $post->title }}" class="img-fluid" />
                @else
                    <img class="img-fluid rounded" src="http://placehold.it/750x300" alt="{{ $post->title }}">
                @endif
            </div>

            <h2 class="entry-title">
                <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
            </h2>

            <div class="entry-meta">
                <ul>
                    <li class="d-flex align-items-center">
                        <i class="icofont-user"></i>
                        <span>{{ $post->author }}</span>
                    </li>
                    <li class="d-flex align-items-center">
                        <i class="uil uil-calendar-alt"></i>
                        <span>
                            <time datetime="2020-01-01">{{ $post->created_at->format('j M, Y') }}
                            </time>
                        </span>
                    </li>
                </ul>
            </div>

            <div class="entry-content">
                <p>
                    {{ substr($post->description, 0, 200) }}...
                </p>
                <div class="read-more">
                    <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}">{{ trans('blog.button.btnDetail') }}
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
