@extends('layouts.dashboard')

@section('title')
    Edit category
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_category', $category) }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <form action="{{ route('categories.update', ['category' => $category]) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            {{-- TITLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="category_title">Title</label>

                                <input type="text" id="category_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter your Title"
                                    value="{{ old('title', $category->title) }}" autofocus>

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
                                    value="{{ old('slug', $category->slug) }}" readonly>

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
                                <label for="category_thumbnail">Thumbnail</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <button id="button_category_thumbnail" data-input="input_category_thumbnail"
                                            data-preview="holder" class="btn btn-primary" type="button">
                                            Browse
                                        </button>
                                    </div>

                                    <input type="text" name="thumbnail"
                                        value="{{ old('thumbnail', asset($category->thumbnail)) }}"
                                        id="input_category_thumbnail" placeholder="Enter your Thumbnail"
                                        class="@error('thumbnail') is-invalid @enderror form-control" readonly>

                                    @error('thumbnail')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                {{-- img preview --}}
                                {{-- <div id="holder"></div> --}}
                            </div>

                            <div class="form-group col-lg-6">
                                {{-- PARENT CATEGORY --}}
                                <label for="select_category_parent">Parent Category</label>
                                <select id="select_category_parent" name="parent_category"
                                    data-placeholder="Select a Parent Category" class="form-control">

                                    @if (old('parent_category', $category->parent))
                                        <option value="{{ old('parent_category', $category->parent)->id }}" selected>
                                            {{ old('parent_category', $category->parent)->title }}
                                        </option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            {{-- DESCRIPTION --}}
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                id="category_description" placeholder="Enter your Description" cols="30"
                                rows="4">{{ old('description', $category->description) }}</textarea>

                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="float-right">
                            <a class="btn btn-info px-4" href="{{ route('categories.index') }}">Back</a>
                            <button type="submit" class="btn btn-warning px-4">Update</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-external')
    {{-- file manager --}}
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
@endpush

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
                widht: "100%",
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

            // file manager
            $("#button_category_thumbnail").filemanager('image');
        });
    </script>
@endpush
