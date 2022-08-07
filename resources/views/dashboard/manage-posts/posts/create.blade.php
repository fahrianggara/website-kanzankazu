@extends('layouts.dashboard')

@section('title')
    Buat Postingan
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

            <div class="col-lg-12 ">
                <div class="m-b-30">
                    <div class="">
                        <input type="hidden" name="slug">
                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="input_post_title">Judul Postingan @if (Auth::user()->editorRole())
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

                            {{-- SELECT TAG --}}
                            <div class="col-lg-6 form-group">
                                <label for="select_post_tag" class="">Tag Postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <select name="tag[]" id="select_post_tag"
                                    data-placeholder="Pilih tag sesuai postingan kamu.."
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
                                    Kategori Postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <select id="select_category" name="category" data-placeholder="Pilih kategori sesuai postingan kamu.."
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
                                    <label for="select_post_status" class="">Status Postingan<span
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
                                    <label for="select_post_status">Status Postingan</label>

                                    <select name="status" id="select_post_status"
                                        class="custom-select w-100 @error('status') is-invalid @enderror">
                                        <option value="publish" @if (old('status') == 'publish') selected @endif>
                                            Publik
                                        </option>
                                        <option value="draft" @if (old('status') == 'draft') selected @endif>
                                            Arsip
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

                        @if (!Auth::user()->editorRole())
                            <div class="row">
                                {{-- tutorial --}}
                                <div class="form-group col-lg-6">
                                    <label for="select_tutorial">
                                        Tutorial Postingan
                                        <i class="uil uil-info-circle text-primary" data-toggle="tooltip" data-placement="top" title="Tutorial postingan ini seperti urutan dari awal sampai akhir konten. pilih datanya sesuai dengan konten kamu, jika tidak maka abaikan saja"></i>
                                    </label>
                                    <select id="select_tutorial" name="tutorial" data-placeholder="Pilih tutorial sesuai postingan kamu.."
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
                            </div>
                        @endif

                        <div class="row">
                            {{-- THUMBNAIL --}}
                            <div class="col-lg-6 form-group">
                                <label for="input_post_thumbnail">Gambar Postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <div class="input-group">

                                    <input type="file" name="thumbnail" id="thumbnail" class="dropify" />

                                    @error('thumbnail')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="form-group col-lg-6">
                                <label for="input_post_desc">Deskripsi Postingan @if (Auth::user()->editorRole())
                                        <span class="star-required">*</span>
                                    @endif
                                </label>

                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="input_post_desc"
                                    onkeyup="countCharBlog(this)" cols="2" rows="8" placeholder="Masukkan deskripsi postingan kamu..">{{ old('description') }}</textarea>

                                <span class="float-right" id="charNumBlog"></span>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

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
                    <div class="card">
                        <div class="card-body float-right">
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
