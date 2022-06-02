@extends('layouts.dashboard')

@section('title')
    Edit user
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_user', $user) }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('users.update', ['user' => $user]) }}" method="post"
                        enctype="multipart/form-data" autocomplete="off">
                        @method('PUT')
                        @csrf

                        <input type="hidden" name="oldPicture" value="{{ $user->user_image }}">

                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {{-- NAME --}}
                                <label for="user_name">Name</label>

                                <input type="text" id="user_name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter name user"
                                    value="{{ old('name', $user->name) }}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6 form-group">
                                {{-- Slug --}}
                                <label for="user_slug">Slug Name</label>

                                <input type="text" id="user_slug" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror" placeholder="Auto Genrate"
                                    value="{{ old('slug', $user->slug) }}" readonly>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            {{-- USER IMAGE --}}
                            <div class="col-lg-6 form-group">
                                <label for="user_image">Image Profile</label>

                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="user_image" value="{{ old('user_image') }}"
                                            id="user_image" placeholder="Choose image.."
                                            class="@error('user_image') is-invalid @enderror custom-file-input">
                                        <label class="custom-file-label" for="thumbnail">{{ $user->user_image }}</label>
                                    </div>
                                    @error('user_image')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- ROLE --}}
                            <div class="col-lg-6 form-group">
                                <label for="select_user_role">
                                    Role permissions
                                </label>
                                <select id="select_user_role" name="role" data-placeholder="Choose role"
                                    class="custom-select w-100 @error('role') is-invalid @enderror">
                                    @if (old('role', $roleOld))
                                        <option value="{{ old('role', $roleOld)->id }}">
                                            {{ old('role', $roleOld)->name }}
                                        </option>
                                    @endif
                                </select>
                                <!-- error message -->
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-info px-4" href="{{ route('users.index') }}">Back</a>
                        <button type="submit" class="btn btn-warning px-4">Edit user</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-external')
    <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
@endpush

@push('js-internal')
    <script>
        $(document).ready(function() {
            // SELECT ROLE
            $('#select_user_role').select2({
                theme: 'bootstrap4',
                language: "app()->getLocale()",
                allowClear: true,
                width: "100%",
                ajax: {
                    url: "{{ route('roles.select') }}",
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                }
                            })
                        };
                    }
                }
            });

            // Generate auto slug
            const generateSlug = (value) => {
                return value.trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, '')
                    .replace(/-+/g, '-').replace(/^-|-$/g, "")
            }

            $('#user_name').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                $('#user_slug').val(generateSlug(title));
            });
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
    </script>
@endpush
