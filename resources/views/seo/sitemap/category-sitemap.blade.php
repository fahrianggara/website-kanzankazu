<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($categories as $category)
        @php
            if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail)) {
                $thumbnail = asset('vendor/dashboard/image/thumbnail-categories/' . $category->thumbnail);
            } else {
                $thumbnail = asset('vendor/blog/img/default.png');
            }
        @endphp
        <url>
            <loc>{{ route('blog.posts.categories', ['slug' => $category->slug]) }}</loc>
            <lastmod>{{ $category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            <image:image>
                <image:loc>{{ $thumbnail }}</image:loc>
                <image:caption>{{ $category->title . ' - ' . $category->description }}</image:caption>
            </image:image>
        </url>
    @endforeach
</urlset>
