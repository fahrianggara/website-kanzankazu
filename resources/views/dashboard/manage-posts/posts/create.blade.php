@extends('layouts.dashboard')

@section('title')
    Buat postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_posts') }}
@endsection

@section('content')

    <form action="{{ route('posts.store') }}#posts" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf

        @if (!Auth::user()->editorRole())
            @error('content')
                <div class="notif-error" data-error="{{ $message }}"></div>
            @enderror
        @endif

        <div class="row">

            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-body">

                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="input_post_title">Judul @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>
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
                            <div class="col-lg-6 form-group">
                                <label for="input_post_slug">Slug <span class="star-required"></span></label>

                                <input type="text" id="input_post_slug" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror" placeholder="Auto Generate"
                                    value="{{ old('slug') }}" readonly>

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
                                <label for="input_post_keywords">Kata Kunci @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>
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
                            <div class="col-lg-6 form-group">
                                <label for="input_post_author">Author <span class="star-required"></span></label>

                                <input type="text" id="input_post_author" name="author"
                                    class="form-control @error('author') is-invalid @enderror" placeholder="Author"
                                    value="{{ Auth::user()->name }}" readonly>

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
                                <label for="input_post_thumbnail">Gambar Postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <div class="input-group">

                                    <div class="custom-file">
                                        <input type="file" name="thumbnail"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" value="{{ old('thumbnail') }}">
                                        <label class="custom-file-label" for="thumbnail">Pilih gambar postingan
                                            kamu..</label>
                                    </div>

                                    @error('thumbnail')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- SELECT TAG --}}
                            <div class="col-lg-6 form-group">
                                <label for="select_post_tag" class="">Tag postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
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
                        </div>

                        <div class="row">
                            {{-- Category --}}
                            <div class="form-group col-lg-6">
                                <label for="select_category">
                                    Kategori @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <select id="select_category" name="category" data-placeholder="Pilih kategori post"
                                    class="custom-select w-100 @error('category') is-invalid @enderror">
                                    @if (old('category'))
                                        <option value="{{ old('category')->id }}">
                                            {{ old('category')->title }}
                                        </option>
                                    @endif
                                </select>

                                @error('category')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- STATUS --}}
                            @if (Auth::user()->editorRole())
                                <div class="col-lg-6 form-group">
                                    <label for="select_post_status" class="">Status <span
                                            class="star-required"></span>
                                    </label>

                                    <select name="status" id="select_post_status"
                                        class="custom-select w-100 @error('status') is-invalid @enderror">
                                        <option value="approve" @if (old('status') == 'approve') selected @endif>
                                            Persetujuan
                                        </option>
                                    </select>

                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            @else
                                <div class="col-lg-6 form-group">
                                    <label for="select_post_status">Status <span class="star-required"></span></label>

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
                        </div>

                        @if (Auth::user()->editorRole())
                            {{-- DESCRIPTION --}}
                            <div class="form-group">
                                <label for="input_post_desc">Deskripsi @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                    onkeyup="countCharBlog(this)" cols="2" rows="6" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description') }}</textarea>

                                <span class="float-right" id="charNumBlog"></span>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @else
                            <div class="row">
                                {{-- tutorial --}}
                                <div class="form-group col-lg-6">
                                    <label for="select_tutorial">
                                        Tutorial <span class="star-required"></span>
                                    </label>
                                    <select id="select_tutorial" name="tutorial" data-placeholder="Pilih tutorial post"
                                        class="custom-select w-100 @error('tutorial') is-invalid @enderror">
                                        @if (old('tutorial'))
                                            <option id="tutorial_id" value="{{ old('tutorial')->id }}">
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
                                {{-- DESCRIPTION --}}
                                <div class="form-group col-lg-6">
                                    <label for="input_post_desc">Deskripsi @if (Auth::user()->editorRole())
                                            <span class="star-required">*</span>
                                        @endif
                                    </label>

                                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                        onkeyup="countCharBlog(this)" cols="2" rows="6" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description') }}</textarea>

                                    <span class="float-right" id="charNumBlog"></span>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        {{-- Content --}}
                        <div class="form-group">
                            <label for="input_post_content">
                                Konten Postingan @if (Auth::user()->editorRole())
                                    <span class="star-required">*</span>
                                @endif
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
                            <a class="btn btn-info px-4" href="{{ route('posts.index') }}#posts">Kembali</a>
                            <button type="submit" name="submitbtn" class="btn btn-success px-4">Posting</button>
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
        const alertError = $('.notif-error').data('error');
        if (alertError) {
            Swal.fire({
                title: 'Gagal!',
                text: 'Pesan : ' + alertError,
                icon: 'error',
                confirmButtonText: 'Ok'
            });
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function() {
            // SELECT CATEGORY
            $('#select_category').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                minimumResultsForSearch: 10,
                allowClear: true,
                width: '100%',
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
                minimumResultsForSearch: 10,
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
