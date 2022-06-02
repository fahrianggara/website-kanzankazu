@extends('layouts.dashboard')

@section('title')
    Posts Create
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_posts') }}
@endsection

@section('content')

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <div class="row">
            <div class="col-lg-4" style="margin: 0">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="form-group">

                            <label for="check_category" class="font-weight-bold">Choose Categories</label>

                            <div class="form-control overflow-auto @error('category') is-invalid @enderror"
                                style="height: auto;">
                                @include('dashboard.manage-posts.posts.categories-check', [
                                    'categories' => $categories,
                                    'cateChecked' => old('category'),
                                ])
                            </div>

                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">

                        {{-- TITLE --}}
                        <div class="form-group">
                            <label for="input_post_title">Title</label>

                            <input type="text" id="input_post_title" name="title"
                                class="form-control @error('title') is-invalid @enderror" placeholder="Enter your Title"
                                value="{{ old('title') }}" autofocus>

                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- SLUG --}}
                        <div class="form-group">
                            <label for="input_post_slug">Slug</label>

                            <input type="text" id="input_post_slug" name="slug"
                                class="form-control @error('slug') is-invalid @enderror" placeholder="Auto Generate"
                                value="{{ old('slug') }}" readonly>

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- KEYWORDS --}}
                        <div class="form-group">
                            <label for="input_post_keywords">Keywords</label>

                            <input type="text" id="input_post_keywords" name="keywords"
                                class="form-control @error('keywords') is-invalid @enderror"
                                placeholder="Enter your post keywords: yourtitlepost, yourcategorypost, blablabla"
                                value="{{ old('keywords') }}">

                            @error('keywords')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- AUTHOR --}}
                        <div class="form-group">
                            <label for="input_post_author">Author</label>

                            <input type="text" id="input_post_author" name="author"
                                class="form-control @error('author') is-invalid @enderror" placeholder="Name"
                                value="{{ Auth::user()->name }}" readonly>

                            @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- THUMBNAIL --}}
                        <div class="form-group">
                            <label for="input_post_thumbnail">Thumbnail</label>

                            <div class="input-group">

                                <div class="custom-file">
                                    <input type="file" name="thumbnail"
                                        class="custom-file-input @error('thumbnail') is-invalid @enderror" id="thumbnail"
                                        value="{{ old('thumbnail') }}">
                                    <label class="custom-file-label" for="thumbnail">Choose post thumbnail..</label>
                                </div>

                                @error('thumbnail')
                                    <span class="invalid-feedback d-block" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- SELECT TAG --}}
                        <div class="form-group">
                            <label for="select_post_tag" class="">Select Tag
                            </label>

                            <select name="tag[]" id="select_post_tag" data-placeholder="Choose Tags"
                                class="custom-select w-100 @error('tag') is-invalid @enderror" multiple>
                                @if (old('tag'))
                                    @foreach (old('tag') as $tag)
                                        <option value="{{ $tag->id }}" selected> {{ $tag->title }}</option>
                                    @endforeach
                                @endif
                            </select>

                            @error('tag')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- STATUS --}}
                        <div class="
                                form-group">
                            <label for="select_post_status">Status</label>

                            <select name="status" id="select_post_status"
                                class="custom-select w-100 @error('status') is-invalid @enderror">
                                @foreach ($statuses as $key => $value)
                                    <option value="{{ $key }}" {{ old('status') == $key ? 'selected' : null }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>

                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="form-group">
                            <label for="input_post_desc">Description</label>

                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                onkeyup="countCharBlog(this)" cols="2" rows="6"
                                placeholder="Enter your description..">{{ old('description') }}</textarea>

                            <span class="float-right" id="charNumBlog"></span>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="input_post_content">
                                Content
                            </label>

                            <textarea name="content" id="input_post_content" cols="30" rows="30"
                                class="form-control @error('content') is-invalid @enderror"
                                placeholder="Enter your content article">{{ old('content') }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a class="btn btn-info px-4" href="{{ route('posts.index') }}">Back</a>
                            <button type="submit" class="btn btn-success px-4">Posting</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form>

@endsection

@push('css-external')
    {{-- select2 --}}
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/select2/css/select2-bootstrap4.min.css') }}">
@endpush

@push('js-external')
    {{-- file manager --}}
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    {{-- ttiny mce --}}
    <script src="{{ asset('vendor/dashboard/plugins/tinymce5/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/tinymce5/tinymce.min.js') }}"></script>
    {{-- select2 --}}
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}"></script>
@endpush

@push('js-internal')
    <script>
        $(document).ready(function() {

            // FUNCTION TITLE GENERATE KE SLUG
            $("#input_post_title").change(function(event) {
                $("#input_post_slug").val(
                    event.target.value
                    .trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, "-")
                    .replace(/-+/g, "-")
                    .replace(/^-|-$/g, "")
                );
            });

            // MEMANGGIL FILE MANAGER
            $("#button_post_thumbnail").filemanager('image');

            // CONTENT
            $("#input_post_content").tinymce({
                relative_urls: false,
                language: "en",
                selector: 'textarea',
                content_css: 'dark',
                skin: "oxide-dark",
                height: 300,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textpattern",
                    "tabfocus"
                ],
                toolbar1: "fullscreen preview",
                toolbar2: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",

                // MENGKONEKKAN CONTENT GAMBAR KE FILE MANAGER
                file_picker_callback: function(callback, value, meta) {
                    let x = window.innerWidth || document.documentElement.clientWidth || document
                        .getElementsByTagName('body')[0].clientWidth;
                    let y = window.innerHeight || document.documentElement.clientHeight || document
                        .getElementsByTagName('body')[0].clientHeight;

                    let cmsURL = "{{ route('unisharp.lfm.show') }}" + '?editor=' + meta.fieldname;
                    if (meta.filetype == 'image') {
                        cmsURL = cmsURL + "&type=Images";
                    } else {
                        cmsURL = cmsURL + "&type=Files";
                    }

                    tinyMCE.activeEditor.windowManager.openUrl({
                        url: cmsURL,
                        title: 'Filemanager',
                        width: x * 0.8,
                        height: y * 0.8,
                        resizable: "yes",
                        close_previous: "no",
                        onMessage: (api, message) => {
                            callback(message.content);
                        }
                    });
                }

            });

            // POST SELECT
            $('#select_post_tag').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "{{ route('tags.select') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.title,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            // Show name file
            $(document).on('change', 'input[type="file"]', function(event) {
                let fileName = $(this).val();

                if (fileName == undefined || fileName == "") {
                    $(this).next('.custom-file-label').html('No image selected..')
                } else {
                    $(this).next('.custom-file-label').html(event.target.files[0].name);
                }
            });


        });

        function countCharBlog(val) {
            let max = 500
            let limit = val.value.length;
            if (limit >= max) {
                val.value = val.value.substring(0, max);
                $('#charNumBlog').text('You have reached the limit');
            } else {
                var char = max - limit;
                $('#charNumBlog').text(char + ' Characters Left');
            };
        }
    </script>
@endpush
