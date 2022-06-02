<footer id="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 footer-info">
                    <div class="title-footer">
                        <h3>Tentang</h3>
                    </div>
                    <p>
                        {{ $setting->site_description }}
                    </p>
                    <div class="social-links">
                        <a href="{{ $setting->site_twitter }}" target="_blank" class="twitter">
                            <i class="uil uil-twitter"></i>
                        </a>
                        <a href="{{ $setting->site_github }}" target="_blank" class="github">
                            <i class="uil uil-github"></i>
                        </a>
                        <a href="mailto:{{ $setting->site_email }}">
                            <i class="uil uil-envelope"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 footer-post">
                    <div class="title-footer">
                        <h3>Blog Terpopuler</h3>
                    </div>

                    <div class="popular-post">
                        {{-- Foreach --}}
                        @forelse ($footerPost as $post)
                            <div class="post-item clearfix">
                                <div class="post-img loading">
                                    @if (file_exists(public_path('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail)))
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                            class="img"
                                            style="background-image: url({{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }})"></a>
                                    @else
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                            class="img"
                                            style="background-image: url({{ asset('vendor/blog/img/default.png') }})"></a>
                                    @endif
                                </div>
                                <div class="post-info">
                                    <div class="post-title loading">
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                            class="m-0 underline text-links {{ request()->is('blog/' . $post->slug) ? 'active' : '' }}">
                                            {{ $post->title . ' - ' . substr($post->description, 0, 50) }}...
                                        </a>
                                    </div>
                                    <div class="post-time text-muted loading">
                                        <p class="mt-1 text-time">{{ $post->created_at->format('j M, Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p>Oops.. Blog-nya belum dibuat..</p>
                        @endforelse

                    </div>
                </div>

                <div class="col-lg-4 col-md-12 footer-newsletter">
                    <div class="title-footer">
                        <h3>Newsletter</h3>
                    </div>

                    <p>Mau dapat info dan tutorial coding dari kami ke emailmu? silahkan isi form dibawah ini.</p>

                    <form action="{{ route('newsletter.store') }}" id="formNewsletter" method="post"
                        autocomplete="off">
                        @method('post')
                        @csrf

                        <input type="text" id="emailNewsletter" name="email" placeholder="Alamat email kamu">

                        <button type="submit" id="btn_newsletter">
                            Subscribe
                        </button>
                    </form>

                    <p class="contact-us">atau <a href="#" data-toggle="modal" data-target="#modalContactUs">Kontak
                            Kami</a>.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="footer-bottom">
            {{ $setting->site_footer }}
        </div>
    </div>

</footer>

{{-- Modal create contact us --}}
<div class="modal fade" id="modalContactUs" tabindex="-1" role="dialog" aria-labelledby="modalContactUs"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContactUs">Kontak Kami</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formContactUs" action="{{ route('contact.save') }}" method="POST" autocomplete="off">
                @method('POST')
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label for="name">Nama kamu</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Masukkan nama kamu">
                        <span class="invalid-feedback d-block error-text name_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email kamu</label>
                        <input type="text" class="form-control" id="email" name="email"
                            placeholder="Masukkan alamat email kamu">
                        <span class="invalid-feedback d-block error-text email_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="subject">Judul Pesan</label>
                        <input type="text" class="form-control" id="subject" name="subject"
                            placeholder="Masukkan judul pesan kamu">
                        <span class="invalid-feedback d-block error-text subject_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="message">Isi Pesan</label>
                        <textarea class="form-control" id="message" rows="3" name="messages" placeholder="Masukkan isi pesan kamu"></textarea>
                        <span class="invalid-feedback d-block error-text messages_error"></span>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" id="btn_contactUs" class="btn btn-success">Kirim Pesan</button>
                </div>
            </form>
        </div>
    </div>
</div>
