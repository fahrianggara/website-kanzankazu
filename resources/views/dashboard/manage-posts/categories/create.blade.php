@extends('layouts.dashboard')

@section('title')
    Buat kategori
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_category') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <form action="{{ route('categories.store') }}#categories" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    <div class="card-body">


                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="category_title">Nama kategori</label>

                                <input type="text" id="category_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan nama kategori" value="{{ old('title') }}" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- SLUG --}}
                            <div class="col-lg-6 form-group">
                                <label for="category_slug">Slug</label>

                                <input type="text" name="slug" id="category_slug"
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
                            <div class="form-group col-lg-6">
                                {{-- THUMBNAIL --}}
                                <label for="category_thumbnail">Gambar kategori</label>

                                <div class="input-group">

                                    <div class="custom-file">
                                        <input type="file" name="thumbnail"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" value="{{ old('thumbnail') }}">
                                        <label class="custom-file-label" for="thumbnail">Cari gambar kategori..</label>
                                    </div>

                                    @error('thumbnail')
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>

                            {{-- <div class="form-group col-lg-6 col-md-2">
                                <label for="select_category_parent">Induk kategori</label>
                                <select id="select_category_parent" name="parent_category"
                                    data-placeholder="Pilih induk kategori, jika tidak mau.. abaikan"
                                    class="form-control">

                                    @if (old('parent_category'))
                                        <option value="{{ old('parent_category')->id }}" selected>
                                            {{ old('parent_category')->title }}
                                        </option>
                                    @endif
                                </select>
                            </div> --}}
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="cate_desc">Deskripsi</label>

                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="cate_desc"
                                onkeyup="countCharBlog(this)" cols="2" rows="6" placeholder="Masukkan deskripsi kategori..">{{ old('description') }}</textarea>

                            <span class="float-right" id="charNumBlog"></span>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    {{-- Card footer --}}
                    <div class="card-footer">
                        {{-- Button Save --}}
                        <a class="btn btn-info px-4" href="{{ route('categories.index') }}#categories">Kembali</a>
                        <button type="submit" class="btn btn-success px-4">Simpan</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            // membuat slug
            function generateSlug(value) {
                return value.trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, '-')
                    .replace(/-+/g, '-').replace(/^-|-$/g, "");
            }

            //parent category
            $('#select_category_parent').select2({
                theme: 'bootstrap4',
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "{{ url('dashboard/categories/select') }}",
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

            // event: input dari title
            $('#category_title').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                let parent_category = $('#select_category_parent').val() ?? "";
                $('#category_slug').val(generateSlug(title + " " + parent_category));
            });

            // event: select parent category
            $('#select_category_parent').change(function(e) {
                e.preventDefault();

                let title = $('#category_title').val();
                let parent_category = $(this).val() ?? "";
                $('#category_slug').val(generateSlug(title + " " + parent_category));
            });

            // Show name file
            $(document).on('change', 'input[type="file"]', function(event) {
                let fileName = $(this).val();

                if (fileName == undefined || fileName == "") {
                    $(this).next('.custom-file-label').html('Tidak ada gambar yang dipilih');
                } else {
                    $(this).next('.custom-file-label').html(event.target.files[0].name);
                }
            });
        });

        function countCharBlog(val) {
            let max = 400
            let limit = val.value.length;
            if (limit >= max) {
                val.value = val.value.substring(0, max);
                $('#charNumBlog').text('Kamu sudah mencapai batas maksimal.');
            } else {
                var char = max - limit;
                $('#charNumBlog').text(char + ' Karakter tersisa');
            };
        }
    </script>
@endpush
