<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach ($users as $user)
        @php
            if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image)) {
                $avatar = asset('vendor/dashboard/image/picture-profiles/' . $user->user_image);
            } elseif ($user->provider == 'google' || $user->provider == 'github') {
                $avatar = $user->user_image;
            } else {
                $avatar = asset('vendor/dashboard/image/avatar.png');
            }
        @endphp

        <url>
            <loc>{{ route('blog.author', ['author' => $user->slug]) }}</loc>
            <lastmod>{{ $user->updated_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
            <image:image>
                <image:loc>{{ $avatar }}</image:loc>
                <image:caption>{{ $user->name . ' - ' . 'Avatar' }}</image:caption>
            </image:image>
        </url>
    @endforeach
</urlset>
