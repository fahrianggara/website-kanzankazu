@extends('layouts.dashboard')

@section('title')
    Edit Role
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('edit_role', $role) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <form action="{{ route('roles.update', ['role' => $role]) }}" method="post">
                        @method('PUT')
                        @csrf

                        <div class="form-group">
                            <label for="input_role_name">Nama Role</label>

                            <input id="input_role_name" name="name" type="text" name="name"
                                value="{{ old('role', $role->name) }}"
                                class="form-control @error('name') is-invalid @enderror" placeholder="masukkan nama role"
                                autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">

                            <label for="input_role_permission">Daftar Role
                                <input type="checkbox" value="" class=" ml-1" id="centangAll">
                            </label>

                            <div class="form-control h-100 @error('permissions') is-invalid @enderror"
                                id="input_role_permission">
                                <div class="row" style="margin-left: -9px;margin-bottom: 4px">
                                    @foreach ($authorities as $manageName => $permissions)
                                        <ul class="list-group mx-1">
                                            <li class="list-group-item mt-1 bg-primary text-white">
                                                {{ strtoupper(trans("permission.{$manageName}")) }}
                                            </li>

                                            @foreach ($permissions as $permission)
                                                <li class="list-group-item">
                                                    <div class="form-check">

                                                        @if (old('permissions', $permissionChecked))
                                                            <input id="{{ $permission }}" name="permissions[]"
                                                                class="form-check-input centangRole" type="checkbox"
                                                                value="{{ $permission }}"
                                                                {{ in_array($permission, old('permissions', $permissionChecked)) ? 'checked' : null }}>
                                                        @else
                                                            <input id="{{ $permission }}" name="permissions[]"
                                                                class="form-check-input centangRole" type="checkbox"
                                                                value="{{ $permission }}">
                                                        @endif

                                                        <label for="{{ $permission }}" class="form-check-label">
                                                            {{ trans("permission.{$permission}") }}
                                                        </label>

                                                    </div>
                                                </li>
                                            @endforeach

                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                            @error('permissions')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a href="{{ route('roles.index') }}" class="btn btn-info">Kembali</a>
                        <button type="submit" class="btn btn-warning">Perbarui</button>
                    </div>
                </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $("#centangAll").click(function(e) {
                if ($(this).is(':checked')) {
                    $(".centangRole").prop('checked', true);
                } else {
                    $(".centangRole").prop('checked', false);
                }
            });
        });
    </script>
@endpush
