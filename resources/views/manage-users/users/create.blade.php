@extends('layouts.dashboard')

@section('title')
    Create User
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_users') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">

                    <form action="{{ route('users.store') }}" method="post">
                        @csrf

                        <div class="row">
                            <div class="col-lg-6 form-group">
                                {{-- NAME --}}
                                <label for="user_name">Name</label>

                                <input type="text" id="user_name" name="name"
                                    class="form-control @error('name') is-invalid @enderror" placeholder="Enter name user"
                                    value="{{ old('name') }}" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6 form-group">
                                {{-- SLUG --}}
                                <label for="user_slug">Slug Name</label>

                                <input type="text" id="user_slug" name="slug"
                                    class="form-control @error('slug') is-invalid @enderror" placeholder="Auto generate"
                                    value="{{ old('slug') }}" readonly>

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
                                    value="{{ old('email') }}">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-lg-6">

                                <label for="user_image">Image Profile</label>

                                <div class="input-group">

                                    <div class="input-group-prepend">
                                        <button id="button_user_image" data-input="input_user_image" data-preview="holder"
                                            class="btn btn-primary" type="button">
                                            Browse
                                        </button>
                                    </div>

                                    <input type="text" name="user_image" value="{{ old('user_image') }}"
                                        id="input_user_image" placeholder="Choose image.."
                                        class="@error('user_image') is-invalid @enderror form-control" readonly>

                                    @error('user_image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- ROLE --}}
                            <div class="form-group col-lg-6">
                                <label for="select_user_role">
                                    Role permissions
                                </label>
                                <select id="select_user_role" name="role" data-placeholder="Choose role"
                                    class="custom-select w-100 @error('role') is-invalid @enderror">
                                    @if (old('role'))
                                        <option value="{{ old('role')->id }}">
                                            {{ old('role')->name }}
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
                        <div class="row">
                            {{-- PASSWORD --}}
                            <div class="form-group col-md-6">
                                <label for="input_user_password" class="font-weight-bold">
                                    Password
                                </label>
                                <input id="input_user_password" name="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter password" autocomplete="new-password" />
                                <!-- error message -->
                                <input type="hidden" class="@error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="input_user_password_confirmation" class="font-weight-bold">
                                    Confirm
                                </label>
                                <input id="input_user_password_confirmation" name="password_confirmation" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Confirm password" autocomplete="new-password" />
                            </div>
                        </div>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-info px-4" href="{{ route('users.index') }}">Back</a>
                        <button type="submit" class="btn btn-success px-4">Create user</button>
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
