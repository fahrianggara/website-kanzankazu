<?=
'<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL ?>
<rss version="2.0">
    <channel>
        <title>
            <![CDATA[ {{ $setting->site_description }} ]]>
        </title>
        <link>
        <![CDATA[ {{ route('feed') }} ]]>
        </link>
        <description>
            <![CDATA[ Your website description ]]>
        </description>
        <language>id</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach ($posts as $post)
            <item>
                <title>
                    <![CDATA[{{ $post->title }}]]>
                </title>
                <link>{{ route('blog.detail', ['slug' => $post->slug]) }}</link>
                <description>
                    <![CDATA[{!! $post->content !!}]]>
                </description>
                <category>{{ $post->categories->pluck('title')->first() }}</category>
                <author>
                    <![CDATA[{{ $post->user->name }}]]>
                </author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>
