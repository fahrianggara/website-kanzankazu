<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">

    @foreach ($posts as $post)
        @php
            if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail)) {
                $thumbnail = asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail);
            } else {
                $thumbnail = asset('vendor/blog/img/default.png');
            }
        @endphp

        <url>
            <loc>{{ route('blog.detail', ['slug' => $post->slug]) }}</loc>
            <lastmod>{{ $post->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            <image:image>
                <image:loc>{{ $thumbnail }}</image:loc>
                <image:caption>{{ $post->title . ' - ' . $post->description }}</image:caption>
            </image:image>
        </url>
    @endforeach
</urlset>
