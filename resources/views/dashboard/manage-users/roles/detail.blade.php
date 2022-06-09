@extends('layouts.dashboard')

@section('title')
    Role Detail
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('detail_role', $role) }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="form-group">
                        <label for="input_role_name">Nama Role</label>
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="input_role_permission">
                            Daftar Role
                        </label>
                        <div class="row" style="margin-left: -2px">
                            @forelse ($authorities as $manageName => $permissions)
                                <ul class="list-group mx-1">
                                    <li class="list-group-item mt-1 bg-primary text-white">
                                        {{ strtoupper(trans("permission.{$manageName}")) }}
                                    </li>
                                    @foreach ($permissions as $permission)
                                        <!-- list permission:start -->
                                        <li class="list-group-item">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    onclick="return false;"
                                                    {{ in_array($permission, $rolePermissions) ? 'checked' : null }}>
                                                <label class="form-check-label">
                                                    {{ trans("permission.{$permission}") }}
                                                </label>
                                            </div>
                                        </li>
                                        <!-- list permission:end -->
                                    @endforeach
                                </ul>
                            @empty
                                <b>
                                    Oops.. sepertinya data role tidak ada.
                                </b>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('roles.index') }}" class="btn btn-info">Kembali</a>
                </div>
            </div>
        </div>
    </div>

@endsection
