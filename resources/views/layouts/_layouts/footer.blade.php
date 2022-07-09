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
                                    @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}" class="img"
                                            style="background-image: url({{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }})"></a>
                                    @else
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}" class="img"
                                            style="background-image: url({{ asset('vendor/blog/img/default.png') }})"></a>
                                    @endif
                                </div>
                                <div class="post-info">
                                    <div class="post-title loading">
                                        <a href="{{ route('blog.detail', ['slug' => $post->slug]) }}"
                                            class="m-0 underline text-links {{ request()->is('blog/' . $post->slug) ? 'active' : '' }}">
                                            @if (strlen($post->description) > 50)
                                                {{ $post->title . ' - ' . substr($post->description, 0, 50) }}...
                                            @else
                                                {{ $post->title . ' - ' . substr($post->description, 0, 50) }}
                                            @endif
                                        </a>
                                    </div>
                                    <div class="post-time text-muted loading">
                                        <p class="text-time">{{ $post->created_at->format('j M, Y') }}</p>
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

                    <p class="contact-us">atau <a href="#" data-toggle="modal"
                            data-target="#modalContactUs">Kontak
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
                    {{-- alert warning --}}
                    <div class="alert alert-warning">
                        <div class="text-center">
                            Mohon menggunakan email yang valid.
                        </div>
                    </div>

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

@push('css-internal')
    <style>
        .drift-widget-power {
            display: none !important;
        }
    </style>
@endpush

@push('js-internal')
    {{-- <script>
        "use strict";

        ! function() {
            var t = window.driftt = window.drift = window.driftt || [];
            if (!t.init) {
                if (t.invoked) return void(window.console && console.error && console.error(
                    "Drift snippet included twice."));
                t.invoked = !0, t.methods = ["identify", "config", "track", "reset", "debug", "show", "ping", "page",
                        "hide", "off", "on"
                    ],
                    t.factory = function(e) {
                        return function() {
                            var n = Array.prototype.slice.call(arguments);
                            return n.unshift(e), t.push(n), t;
                        };
                    }, t.methods.forEach(function(e) {
                        t[e] = t.factory(e);
                    }), t.load = function(t) {
                        var e = 3e5,
                            n = Math.ceil(new Date() / e) * e,
                            o = document.createElement("script");
                        o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous", o.src =
                            "https://js.driftt.com/include/" + n + "/" + t + ".js";
                        var i = document.getElementsByTagName("script")[0];
                        i.parentNode.insertBefore(o, i);
                    };
            }
        }();
        drift.SNIPPET_VERSION = '0.3.1';
        drift.load('ir5fswbnteyr');
    </script> --}}

    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input.form-control').removeClass(
                    'is-invalid');
                $(document).find('textarea.form-control').removeClass(
                    'is-invalid');
                $('#formContactUs')[0].reset();
            });

            // Contact Us Modal
            $('#formContactUs').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                        // button
                        $('#btn_contactUs').attr('disabled', true);
                        $('#btn_contactUs').html('<i class="fas fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#btn_contactUs').attr('disabled', false);
                        $('#btn_contactUs').html('{{ trans('home.contact.buttonform') }}');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $('input#' + key).addClass('is-invalid');
                                $('textarea#' + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            $('#formContactUs')[0].reset();
                            $('#modalContactUs').modal('hide');
                            // Notif
                            alertify
                                .delay(3500)
                                .log(response.msg);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // newsletter
            $('#formNewsletter').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('#btn_newsletter').attr('disabled', true);
                        $('#btn_newsletter').html('<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function(response) {
                        $('#btn_newsletter').attr('disabled', false);
                        $('#btn_newsletter').html('Subscribe');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            alertify
                                .delay(4000)
                                .error(response.error.email[0]);
                        } else {
                            $('#formNewsletter')[0].reset();
                            alertify
                                .delay(4000)
                                .log(response.msg);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

        });
    </script>
@endpush
