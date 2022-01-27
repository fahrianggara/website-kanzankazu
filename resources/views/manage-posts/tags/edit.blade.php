@extends('layouts.dashboard')

@section('title')
    Edit Tag
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_tag', $tag) }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <form action="{{ route('tags.update', ['tag' => $tag]) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            {{-- title --}}
                            <div class="col-lg-6 form-group">
                                <label for="tag_title">Title</label>

                                <input type="text" id="tag_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror" placeholder="Enter your Title"
                                    value="{{ old('title', $tag->title) }}" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            {{-- SLUG --}}
                            <div class="col-lg-6 form-group">
                                <label for="tag_slug">Slug</label>

                                <input type="text" name="slug" id="tag_slug"
                                    class="form-control @error('slug') is-invalid @enderror" placeholder="Auto Generate"
                                    value="{{ old('slug', $tag->slug) }}" readonly>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-info px-4" href="{{ route('tags.index') }}">Back</a>
                        <button type="submit" class="btn btn-warning px-4">Update</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $(function() {
            const generateSlug = (value) => {
                return value.trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, '-')
                    .replace(/-+/g, '-').replace(/^-|-$/g, "")
            }

            $('#tag_title').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                $('#tag_slug').val(generateSlug(title));
            });
        });
    </script>
@endpush
