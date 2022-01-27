@extends('layouts.dashboard')

@section('title')
    Posts Edit
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_post', $post) }}
@endsection

@section('content')

    <form action="{{ route('posts.update', ['post' => $post]) }}" method="POST">
        @method('PUT')
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="card m-b-30">
                    <div class="card-body">

                        {{-- TITLE --}}
                        <div class="form-group">
                            <label for="input_post_title">Title</label>

                            <input type="text" id="input_post_title" name="title"
                                class="form-control @error('title') is-invalid @enderror" placeholder="Enter your Title"
                                value="{{ old('title', $post->title) }}" autofocus>

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
                                value="{{ old('slug', $post->slug) }}" readonly>

                            @error('slug')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- AUTHOR --}}
                        <div class="form-group">
                            <label for="input_post_author">Author</label>

                            <input type="text" id="input_post_author" name="author"
                                class="form-control @error('author') is-invalid @enderror" placeholder="Your name"
                                value="{{ old('author', $post->author) }}" readonly>

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

                                <div class="input-group-prepend">
                                    <button id="button_post_thumbnail" data-input="input_post_thumbnail"
                                        data-preview="holder" class="btn btn-primary" type="button">
                                        Browse
                                    </button>
                                </div>

                                <input type="text" name="thumbnail" value="{{ old('thumbnail', $post->thumbnail) }}"
                                    id="input_post_thumbnail" placeholder="Browse your Thumbnail"
                                    class="@error('thumbnail') is-invalid @enderror form-control" readonly>

                                @error('thumbnail')
                                    <span class="invalid-feedback" role="alert">
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
                                @if (old('tag', $post->tags))
                                    @foreach (old('tag', $post->tags) as $tag)
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
                                    <option value="{{ $key }}"
                                        {{ old('status', $post->status) == $key ? 'selected' : null }}>
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

                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                id="input_post_desc" cols="30" rows="5"
                                placeholder="Enter your description">{{ old('description', $post->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" style="margin: 0">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="form-group">

                            <label for="check_category" class="font-weight-bold">Choose Categories</label>

                            <div class="form-control overflow-auto @error('category') is-invalid @enderror"
                                style="height: auto;">
                                @include('manage-posts.posts.categories-check', [
                                'categories' => $categories,
                                'cateChecked' => old('category', $post->categories->pluck('id')->toArray())
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
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="input_post_content">
                                Content
                            </label>

                            <textarea name="content" id="input_post_content" cols="30" rows="30"
                                class="form-control @error('content') is-invalid @enderror"
                                placeholder="Enter your content article">{{ old('content', $post->content) }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        <div class="float-right">
                            <a class="btn btn-info px-4" href="{{ route('posts.index') }}">Back</a>
                            <button type="submit" class="btn btn-warning px-4">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@push('css-external')
    {{-- select2 --}}
    <link rel="stylesheet" href="{{ asset('vendor/my-dashboard/assets/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('vendor/my-dashboard/assets/plugins/select2/css/select2-bootstrap4.min.css') }}">
@endpush

@push('js-external')
    {{-- file manager --}}
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
    {{-- ttiny mce --}}
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/tinymce5/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/tinymce5/tinymce.min.js') }}"></script>
    {{-- select2 --}}
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/my-dashboard/assets/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}">
    </script>
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
                height: 300,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textpattern",
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

        });
    </script>
@endpush
