@extends('layouts.dashboard')

@section('title')
    Buat postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_posts') }}
@endsection

@section('content')

    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf

        <div class="row">
            <div class="col-lg-3">
                <div class="sticky">
                    <div class="card m-b-15">
                        <div class="card-body">
                            <div class="form-group">

                                <label for="check_category" class="font-weight-bold">Pilih kategori<span
                                        class="star-required">*</span></label>

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

                    @if (!Auth::user()->editorRole())
                        <div class="card m-b-30">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="check_tutorial" class="font-weight-bold">Pilih Tutorial
                                        <span class="star-required">*</span>
                                    </label>

                                    <div class="form-control overflow-auto @error('tutorial') is-invalid @enderror"
                                        style="height: auto;">

                                        @foreach ($tutorials as $tutorial)
                                            <div class="checkbox my-2">
                                                <div class="custom-control custom-checkbox">
                                                    @if (old('tutorial') == $tutorial->id)
                                                        <input type="radio" name="tutorial"
                                                            value="{{ $tutorial->id }}" class="custom-control-input"
                                                            id="tutorial-{{ $tutorial->id }}" checked>
                                                    @else
                                                        <input type="radio" name="tutorial"
                                                            value="{{ $tutorial->id }}" class="custom-control-input"
                                                            id="tutorial-{{ $tutorial->id }}">
                                                    @endif

                                                    <label class="custom-control-label"
                                                        for="tutorial-{{ $tutorial->id }}">
                                                        {{ $tutorial->title }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>

                                    @error('tutorial')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            <div class="col-lg-9">
                <div class="card m-b-30">
                    <div class="card-body">

                        {{-- TITLE --}}
                        <div class="form-group">
                            <label for="input_post_title">Judul <span class="star-required">*</span></label>

                            <input type="text" id="input_post_title" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="Masukkan judul postingan kamu" value="{{ old('title') }}" autofocus>

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
                            <label for="input_post_keywords">Kata Kunci <span class="star-required">*</span></label>

                            <input type="text" id="input_post_keywords" name="keywords"
                                class="form-control @error('keywords') is-invalid @enderror"
                                placeholder="Masukkan kata kunci postingan kamu. cth: tutorial, php"
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
                                class="form-control @error('author') is-invalid @enderror" placeholder="Author"
                                value="{{ Auth::user()->name }}" readonly>

                            @error('author')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        {{-- THUMBNAIL --}}
                        <div class="form-group">
                            <label for="input_post_thumbnail">Gambar Postingan <span class="star-required">*</span></label>

                            <div class="input-group">

                                <div class="custom-file">
                                    <input type="file" name="thumbnail"
                                        class="custom-file-input @error('thumbnail') is-invalid @enderror" id="thumbnail"
                                        value="{{ old('thumbnail') }}">
                                    <label class="custom-file-label" for="thumbnail">Pilih gambar postingan kamu..</label>
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
                            <label for="select_post_tag" class="">Tag postingan<span class="star-required">*</span>
                            </label>

                            <select name="tag[]" id="select_post_tag"
                                data-placeholder="Cari tag sesuai postingan kamu.."
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
                        @if (Auth::user()->editorRole())
                            <div class="form-group">
                                <label for="select_post_status" class="">Status
                                </label>

                                <select name="status" id="select_post_status"
                                    class="custom-select w-100 @error('status') is-invalid @enderror">
                                    <option value="approve" @if (old('status') == 'approve') selected @endif>Persetujuan
                                    </option>
                                </select>

                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @else
                            <div class="form-group">
                                <label for="select_post_status">Status</label>

                                <select name="status" id="select_post_status"
                                    class="custom-select w-100 @error('status') is-invalid @enderror">
                                    <option value="publish" @if (old('status') == 'publish') selected @endif>Publik
                                    </option>
                                    <option value="draft" @if (old('status') == 'draft') selected @endif>Arsip
                                    </option>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </select>
                            </div>
                        @endif

                        {{-- DESCRIPTION --}}
                        <div class="form-group">
                            <label for="input_post_desc">Deskripsi <span class="star-required">*</span></label>

                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                onkeyup="countCharBlog(this)" cols="2" rows="6" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description') }}</textarea>

                            <span class="float-right" id="charNumBlog"></span>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="input_post_content">
                                Konten <span class="star-required">*</span>
                            </label>

                            <textarea name="content" id="input_post_content" cols="30" rows="30"
                                class="form-control @error('content') is-invalid @enderror" placeholder="Masukkan isi konten kamu disini">{{ old('content') }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            <a class="btn btn-info px-4" href="{{ route('posts.index') }}">Kembali</a>
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
                content_css: 'vendor/dashboard/css/sty.css',
                // content_css: 'dark',
                // skin: "oxide-dark",
                height: 300,
                plugins: [
                    "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media nonbreaking save table directionality",
                    "emoticons template paste textpattern",
                    "tabfocus",
                    "codesample"
                ],
                font_formats: "Andale Mono=andale mono,times; Arial=arial,helvetica,sans-serif; Arial Black=arial black,avant garde; Book Antiqua=book antiqua,palatino; Comic Sans MS=comic sans ms,sans-serif; Courier New=courier new,courier; Georgia=georgia,palatino; Helvetica=helvetica; Impact=impact,chicago; Oswald=oswald; Symbol=symbol; Tahoma=tahoma,arial,helvetica,sans-serif; Terminal=terminal,monaco; Times New Roman=times new roman,times; Trebuchet MS=trebuchet ms,geneva; Verdana=verdana,geneva; Webdings=webdings; Wingdings=wingdings,zapf dingbats",
                codesample_languages: [{
                        text: 'HTML/XML',
                        value: 'markup'
                    },
                    {
                        text: 'Javascript',
                        value: 'javascript'
                    },
                    {
                        text: 'CSS',
                        value: 'css'
                    },
                    {
                        text: 'PHP',
                        value: 'php'
                    },
                    {
                        text: 'Python',
                        value: 'python'
                    },
                    {
                        text: 'C++',
                        value: 'cpp'
                    },
                    {
                        text: "JSON",
                        value: "json"
                    },
                    {
                        text: "bash",
                        value: "bash"
                    },
                    {
                        text: "Mel",
                        value: "mel"
                    },
                ],
                toolbar1: "fullscreen preview | codesample",
                toolbar2: "insertfile undo redo | styleselect | fontselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ",
                codesample_content_css: "{{ asset('vendor/blog/css/main.css') }}",

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
                    $(this).next('.custom-file-label').html('Tidak ada gambar yang dipilih..')
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
                $('#charNumBlog').text('Kamu sudah mencapai batas maksimal');
            } else {
                var char = max - limit;
                $('#charNumBlog').text(char + ' Karakter tersisa');
            };
        }
    </script>
@endpush
