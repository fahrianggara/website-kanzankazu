@extends('layouts.dashboard')

@section('title')
    Buat Tutorial
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_tutorial') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <form action="{{ route('tutorials.store') }}#tutorials" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="card-body">

                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="tutorial_title">Nama tutorial</label>

                                <input type="text" id="tutorial_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan nama tutorial" value="{{ old('title') }}" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- SLUG --}}
                            <div class="col-lg-6 form-group">
                                <label for="tutorial_slug">Slug</label>

                                <input type="text" name="slug" id="tutorial_slug"
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
                                <label for="tutorial_thumbnail">Gambar tutorial</label>

                                <div class="input-group">

                                    <div class="custom-file">
                                        <input type="file" name="thumbnail"
                                            class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                            id="thumbnail" value="{{ old('thumbnail') }}">
                                        <label class="custom-file-label" for="thumbnail">Cari gambar tutorial..</label>
                                    </div>

                                    @error('thumbnail')
                                        <span class="invalid-feedback d-block">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                </div>
                            </div>
                            {{-- Color picker --}}
                            <div class="form-group col-lg-6">
                                <label for="bg-color">Background Warna</label>

                                <div class="input-group">
                                    <input type="text" name="bg_color"
                                        class="complex-colorpicker @error('bg_color') is-invalid @enderror form-control asColorPicker-input"
                                        placeholder="#xxxxxx" value="{{ old('bg_color') }}">

                                    @error('bg_color')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Description --}}
                        <div class="form-group">
                            <label for="cate_desc">Deskripsi</label>

                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="cate_desc"
                                onkeyup="countChar(this)" cols="2" rows="6" placeholder="Masukkan deskripsi tutorial..">{{ old('description') }}</textarea>

                            <span class="float-right" id="charNum"></span>

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
                        <a class="btn btn-info px-4" href="{{ route('tutorials.index') }}">Kembali</a>
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

            // event: input dari title
            $('#tutorial_title').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                $('#tutorial_slug').val(generateSlug(title));
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

        function countChar(val) {
            let max = 400
            let limit = val.value.length;
            if (limit >= max) {
                val.value = val.value.substring(0, max);
                $('#charNum').text('Kamu sudah mencapai batas maksimal.');
            } else {
                var char = max - limit;
                $('#charNum').text(char + ' Karakter tersisa');
            };
        }
    </script>
@endpush
