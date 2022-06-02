@extends('layouts.dashboard')

@section('title')
    Your Profile
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dash-profile') }}
@endsection

@section('content')
    <div class="row">


        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#information-1" role="tab">Site
                                Informations</a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#setting-1" role="tab">Site Settings</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="information-1" role="tabpanel">
                            {{-- SITE NAME --}}
                            <p>
                                <strong class="font-18 mr-1">SITE NAME :</strong>
                                <span class="font-18 site_name">
                                    {{ $settings->site_name }}
                                </span>
                            </p>
                            {{-- SITE EMAIL --}}
                            <p>
                                <strong class="font-18 mr-1">SITE EMAIL :</strong>
                                <span class="font-18 site_">
                                    {{ $settings->site_email }}
                                </span>
                            </p>
                            {{-- SITE DESCRIPTION --}}
                            <p>
                                <strong class="font-18 mr-1">SITE DESCRIPTION :</strong>
                                <span class="font-18 site_description">
                                    {{ $settings->site_description }}
                                </span>
                            </p>
                            {{-- SITE FOOTER --}}
                            <p>
                                <strong class="font-18 mr-1">SITE FOOTER :</strong>
                                <span class="font-18 site_footer">
                                    {{ $settings->site_footer }}
                                </span>
                            </p>
                            {{-- META KEYWORDS --}}
                            <p>
                                <strong class="font-18 mr-1">META KEYWORDS :</strong>
                                <span class="font-18 meta_keywords">
                                    {{ $settings->meta_keywords }}
                                </span>
                            </p>
                            {{-- IMAGE BANNER --}}
                            <p>
                                <strong class="font-18 mr-1">IMAGE BANNER :</strong>
                                <span class="font-18">
                                    @if (file_exists(public_path('vendor/blog/img/home-img/' . $settings->image_banner)))
                                        <img width="200" height="200"
                                            src="{{ asset('vendor/blog/img/home-img/' . $settings->image_banner) }}"
                                            alt="banner" class="img-fluid image_banner">
                                    @else
                                        <img width="200" height="200"
                                            src="{{ asset('vendor/blog/img/home-img/banner.png') }}" alt="banner"
                                            class="img-fluid image_banner">
                                    @endif
                                </span>
                            </p>

                            {{-- Social media --}}
                            <div class="social-links">
                                <a class="" href="{{ $settings->site_twitter }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a class="link_github" href="{{ $settings->site_github }}">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a class="" href="mailto:{{ $settings->site_email }}">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Setting Profile --}}
                        <div class="tab-pane p-3" id="setting-1" role="tabpanel">
                            <form action="{{ route('dashboard.setting.update') }}" method="POST" class="form-horizontal"
                                id="formWebSetting" autocomplete="off">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <label for="site_name" class="col-sm-2 col-form-label">Site Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control site_name" id="site_name"
                                            placeholder="Enter your site name" value="{{ $settings->site_name }}"
                                            name="site_name">
                                        <span class="invalid-feedback d-block error-text site_name_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="site_footer" class="col-sm-2 col-form-label">Site Footer</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control site_footer" id="site_footer"
                                            placeholder="Enter your site footer" value="{{ $settings->site_footer }}"
                                            name="site_footer">
                                        <span class="invalid-feedback d-block error-text site_footer_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="site_email" class="col-sm-2 col-form-label">Site Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control site_email" id="site_email"
                                            placeholder="Enter your site email" value="{{ $settings->site_email }}"
                                            name="site_email">
                                        <span class="invalid-feedback d-block error-text site_email_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="site_description" class="col-sm-2 col-form-label">Site Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control site_description" id="site_description" name="site_description"
                                            placeholder="enter your site description" onkeyup="countChar(this)" cols="2"
                                            rows="6">{{ $settings->site_description }}</textarea>
                                        <span class="float-right" id="charNum"></span>
                                        <span class="invalid-feedback d-block error-text site_description_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="meta_keywords" class="col-sm-2 col-form-label">Meta Keywords</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control meta_keywords" id="meta_keywords"
                                            placeholder="Enter meta keywords for your website"
                                            value="{{ $settings->meta_keywords }}" name="meta_keywords">
                                        <span class="invalid-feedback d-block error-text meta_keywords_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="image_banner" class="col-sm-2 col-form-label">Image Banner</label>
                                    <div class="col-sm-10">
                                        <div class="custom-file">
                                            <input type="file" name="image_banner" class="custom-file-input image_banner"
                                                id="image_banner">
                                            <label class="custom-file-label"
                                                for="image_banner">{{ $settings->image_banner }}</label>
                                        </div>
                                        <span class="invalid-feedback d-block error-text image_banner_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="link_github" class="col-sm-2 col-form-label">Link Github</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control link_github" id="link_github"
                                            placeholder="Link Github" value="{{ $settings->site_github }}"
                                            name="link_github">
                                        <span class="invalid-feedback d-block error-text link_github_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="link_twitter" class="col-sm-2 col-form-label">Link Twitter</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control link_twitter" id="link_twitter"
                                            placeholder="Link Twitter" value="{{ $settings->site_twitter }}"
                                            name="link_twitter">
                                        <span class="invalid-feedback d-block error-text link_twitter_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" id="buttonWebsetting" class="btn btn-primary">
                                            Update Site
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Count limit character
        function countChar(val) {
            let max = 200
            let limit = val.value.length;
            if (limit >= max) {
                val.value = val.value.substring(0, max);
                $('#charNum').text('You have reached the limit');
            } else {
                var char = max - limit;
                $('#charNum').text(char + ' Characters Left');
            };
        }

        $(function() {
            // Show name file
            $(document).on('change', 'input[type="file"]', function(event) {
                let fileName = $(this).val();

                if (fileName == undefined || fileName == "") {
                    $(this).next('.custom-file-label').html('No image selected..')
                } else {
                    $(this).next('.custom-file-label').html(event.target.files[0].name);
                }
            });

            // Update form
            $('#formWebSetting').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('#buttonWebsetting').attr('disabled', true);
                        $('#buttonWebsetting').html(
                            '<i class="fas fa-spinner fa-spin"></i> Updating...');
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                        $(document).find('input.custom-file-input').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('#buttonWebsetting').attr('disabled', false);
                        $('#buttonWebsetting').html(
                            'Update Site');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $('#' + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            alertify
                                .delay(3500)
                                .log(response.message);

                            setTimeout((function() {
                                window.location.reload();
                            }), 980);
                        }
                    },
                });
            });
        });
    </script>
@endpush
