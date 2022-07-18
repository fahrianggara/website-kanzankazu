@extends('layouts.dashboard')

@section('title')
    Edit postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_post', $post) }}
@endsection

@section('content')

    <form action="{{ route('posts.update', ['post' => $post]) }}#posts" method="POST" enctype="multipart/form-data"
        autocomplete="off">
        @method('PUT')
        @csrf

        <input type="hidden" name="old_slug" value="{{ $post->slug }}">

        <div class="row">

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <input type="hidden" name="old_title" value="{{ $post->title }}">
                        <input type="hidden" name="tutorial_user_id" value="{{ Auth::id() }}">

                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="input_post_title">Judul</label>

                                <input type="text" id="input_post_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan judul postingan kamu" value="{{ old('title', $post->title) }}"
                                    autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- SLUG --}}
                            <div class="col-lg-6 form-group">
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
                        </div>

                        <div class="row">
                            {{-- KEYWORDS --}}
                            <div class="col-lg-6 form-group">
                                <label for="input_post_keywords">Kata Kunci</label>

                                <input type="text" id="input_post_keywords" name="keywords"
                                    class="form-control @error('keywords') is-invalid @enderror"
                                    placeholder="Masukkan kata kunci postingan kamu. cth: tutorial, php"
                                    value="{{ old('keywords', $post->keywords) }}">

                                @error('keywords')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- AUTHOR --}}
                            <div class="col-lg-6 form-group">
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
                        </div>

                        <div class="row">
                            {{-- THUMBNAIL --}}
                            <div class="col-lg-6 form-group">
                                <label for="thumbnail">Gambar Postingan</label>

                                <div class="input-group">

                                    <div class="custom-file">
                                        <input type="file" name="thumbnail"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail">
                                        <label class="custom-file-label"
                                            for="thumbnail">{{ old('thumbnail', $post->thumbnail) }}</label>
                                    </div>

                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- SELECT TAG --}}
                            <div class="col-lg-6 form-group">
                                <label for="select_post_tag" class="">Pilih tag postingan
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
                        </div>

                        @if (Auth::user()->editorRole())
                            <div class="row">
                                {{-- Category --}}
                                <div class="form-group col-lg-6">
                                    <label for="select_category">
                                        Kategori <span class="star-required">*</span>
                                    </label>
                                    <select id="select_category" name="category" data-placeholder="Pilih kategori post"
                                        class="custom-select w-100 @error('category') is-invalid @enderror">
                                        @if (old('category', $post->categories))
                                            <option value="{{ old('category', $cateOld)->id }}">
                                                {{ old('category', $cateOld)->title }}
                                            </option>
                                        @endif
                                    </select>

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- DESCRIPTION --}}
                                <div class="col-lg-6 form-group">
                                    <label for="input_post_desc">Deskripsi</label>

                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                        cols="30" rows="5" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description', $post->description) }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @else
                            <div class="row">
                                {{-- Category --}}
                                <div class="form-group col-lg-6">
                                    <label for="select_category">
                                        Kategori
                                    </label>

                                    @if ($cateOld != null)
                                        <select id="select_category" name="category"
                                            data-placeholder="Pilih kategori post"
                                            class="custom-select w-100 @error('category') is-invalid @enderror">
                                            @if (old('category', $post->categories))
                                                <option value="{{ old('category', $cateOld)->id }}">
                                                    {{ old('category', $cateOld)->title }}
                                                </option>
                                            @endif
                                        </select>
                                    @else
                                        <select id="select_category" name="category"
                                            data-placeholder="Pilih kategori post"
                                            class="custom-select w-100 @error('category') is-invalid @enderror">
                                            @if (old('category'))
                                                <option value="{{ old('category')->id }}">
                                                    {{ old('category')->title }}
                                                </option>
                                            @endif
                                        </select>
                                    @endif

                                    @error('category')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- tutorial --}}
                                @if ($tutoOld != null)
                                    <div class="form-group col-lg-6">
                                        <label for="select_tutorial">
                                            Tutorial
                                        </label>
                                        <select id="select_tutorial" name="tutorial"
                                            data-placeholder="Pilih tutorial post"
                                            class="custom-select w-100 @error('tutorial') is-invalid @enderror">
                                            @if (old('tutorial', $post->tutorials))
                                                <option value="{{ old('tutorial', $tutoOld)->id }}">
                                                    {{ old('tutorial', $tutoOld)->title }}
                                                </option>
                                            @endif
                                        </select>

                                        @error('tutorial')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @elseif ($tutoOld == null)
                                    <div class="form-group col-lg-6">
                                        <label for="select_tutorial">
                                            Tutorial
                                        </label>
                                        <select id="select_tutorial" name="tutorial"
                                            data-placeholder="Pilih tutorial post"
                                            class="custom-select w-100 @error('tutorial') is-invalid @enderror">
                                            @if (old('tutorial'))
                                                <option value="{{ old('tutorial')->id }}">
                                                    {{ old('tutorial')->title }}
                                                </option>
                                            @endif
                                        </select>

                                        @error('tutorial')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                @endif
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="form-group">
                                <label for="input_post_desc">Deskripsi</label>

                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                    onkeyup="countCharBlog(this)" cols="30" rows="5" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description', $post->description) }}</textarea>
                                <span class="float-right" id="charNumBlog"></span>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endif
                        {{-- Content --}}
                        <div class="form-group" id="content">
                            <label for="input_post_content">
                                Konten Postingan
                            </label>

                            <textarea name="content" id="input_post_content" cols="30" rows="30"
                                class="form-control @error('content') is-invalid @enderror" placeholder="Masukkan isi konten kamu disini..">{{ old('content', $post->content) }}</textarea>

                            @error('content')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="float-right">
                            @if ($post->status == 'draft')
                                <a class="btn btn-info px-4"
                                    href="{{ route('posts.index', 'status=draft') }}#posts">Kembali</a>
                            @else
                                <a class="btn btn-info px-4" href="{{ route('posts.index') }}#posts">Kembali</a>
                            @endif
                            <button type="submit" class="btn btn-warning px-4">Update</button>
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
    {{-- select2 --}}
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/dashboard/plugins/select2/js/i18n/' . app()->getLocale() . '.js') }}"></script>
@endpush

@push('js-internal')
    <script>
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

        $(document).ready(function() {
            // SELECT CATEGORY
            $('#select_category').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 10,
                ajax: {
                    url: "{{ route('categories.select') }}",
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

            // SELECT TUTORIAL
            $('#select_tutorial').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 10,
                ajax: {
                    url: "{{ route('tutorials.select') }}",
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

            // FUNCTION TITLE GENERATE KE SLUG
            $('input[name="title"]').on('keyup', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().trim().replace(/ +/g, '-').replace(/[^\w-]+/g, '');
                $('input[name="slug"]').val(slug);
            });

            // MEMANGGIL FILE MANAGER
            $("#button_post_thumbnail").filemanager('image');

            // POST SELECT
            $('#select_post_tag').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                allowClear: true,
                width: '100%',
                minimumResultsForSearch: 10,
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
