<div class="sidebar-item archive">
    <ul>

        @foreach ($archives as $item)
            <li>
                <div class="linkArchives loading">
                    <i
                        class="uil uil-folder-open {{ request()->is('blog/' . $item['year'] . '/' . $item['month']) ? 'uil uil-folder-open' : 'uil uil-folder' }}"></i>

                    <a href="{{ route('blog.monthYear', ['month' => $item['month'], 'year' => $item['year']]) }}"
                        class="underline iconAuthor {{ request()->is('blog/' . $item['year'] . '/' . $item['month']) ? 'active' : '' }}">
                        {{ $item['month'] . ' ' . $item['year'] }}
                        (<span class="countArc">{{ $item['publish'] }}</span>)
                    </a>
                </div>
            </li>
        @endforeach

        @foreach ($archives as $item)
            @if (request()->is('blog/' . $item['year'] . '/' . $item['month']))
                <hr class="hr">
            @endif
        @endforeach

        @foreach ($archives as $item)
            @if (request()->is('blog/' . $item['year'] . '/' . $item['month']))
                <div class="linkArchives loading">
                    <li>
                        <i class="uil uil-folder"></i>
                        <a class="underline iconAuthor" href="{{ route('blog.home') }}">
                            {{ trans('blog.sidebar.blogAll') }}
                        </a>
                    </li>
                </div>
            @endif
        @endforeach

    </ul>
</div>
