<ul>
    @foreach ($categoryRoot as $item)
        <li>
            @if ($category->slug == $item->slug)
                {{ $item->title }}
            @else
                <div class="mt-2">
                    <a href="{{ route('blog.posts.categories', ['slug' => $item->slug]) }}">
                        {{ $item->title }}
                    </a>
                </div>
            @endif
            @if ($item->generation)
                @include('blog.sub-blog.sub-category', [
                    'categoryRoot' => $item->generation,
                    'category' => $category,
                ])
            @endif
        </li>
    @endforeach
</ul>
