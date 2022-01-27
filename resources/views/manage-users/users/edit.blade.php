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
                    <form action="{{ route('users.update', ['user' => $user]) }}" method="post">
                        @method('PUT')
                        @csrf

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
                            {{-- EMAIL --}}
                            <div class="col-lg-6 form-group">
                                <label for="user_email">Email</label>

                                <input type="text" id="user_email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" placeholder="Enter email user"
                                    value="{{ old('email', $user->email) }}" readonly>

                                @error('email')
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

                                    <div class="input-group-prepend">
                                        <button id="button_user_image" data-input="input_user_image" data-preview="holder"
                                            class="btn btn-primary" type="button">
                                            Browse
                                        </button>
                                    </div>

                                    <input type="text" name="user_image"
                                        value="{{ old('user_image', asset($user->user_image)) }}" id="input_user_image"
                                        placeholder="Choose image.."
                                        class="@error('user_image') is-invalid @enderror form-control" readonly>

                                    @error('user_image')
                                        <span class="invalid-feedback" role="alert">
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

            // BUTTON IMAGE USER
            $("#button_user_image").filemanager('image');

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
    </script>
@endpush
