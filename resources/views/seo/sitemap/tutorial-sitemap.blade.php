<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($tutorials as $tutorial)
        @php
            if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail)) {
                $thumbnail = asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutorial->thumbnail);
            } else {
                $thumbnail = asset('vendor/blog/img/default.png');
            }

        @endphp
        <url>
            <loc>{{ route('blog.posts.tutorials', ['slug' => $tutorial->slug]) }}</loc>
            <lastmod>{{ $tutorial->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            <image:image>
                <image:loc>{{ $thumbnail }}</image:loc>
                <image:caption>{{ $tutorial->title . ' - ' . $tutorial->description }}</image:caption>
            </image:image>
        </url>
    @endforeach
</urlset>
