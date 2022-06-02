@extends('layouts.dashboard')

@section('title')
    Role Permissions
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('roles') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">
                    {{-- search form --}}
                    <form action="{{ route('roles.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Search Roles.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('role_create')
                        {{-- button create --}}
                        <a href="{{ route('roles.create') }}" class="btn btn-primary float-right"><i
                                class="uil uil-plus"></i></a>
                    @endcan
                </div>

                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @forelse ($roles as $role)
                            <li
                                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">

                                <label class="mt-auto mb-auto">
                                    {{ $role->name }}
                                </label>

                                <div>
                                    @can('role_detail')
                                        {{-- DETAIL --}}
                                        <a href="{{ route('roles.show', ['role' => $role]) }}" class="btn btn-info btn-sm"><i
                                                class="uil uil-eye"></i></a>
                                    @endcan

                                    @can('role_update')
                                        {{-- EDIT --}}
                                        <a href="{{ route('roles.edit', ['role' => $role]) }}"
                                            class="btn btn-warning btn-sm"><i class="uil uil-pen"></i></a>
                                    @endcan

                                    @can('role_delete')
                                        {{-- DELETE --}}
                                        <form action="{{ route('roles.destroy', ['role' => $role]) }}" method="POST"
                                            class="d-inline" role="alert"
                                            alert-text="Are you sure you want to delete the {{ $role->name }} role?">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="uil uil-trash"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </li>
                        @empty
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. {{ strtoupper(request()->get('keyword')) }} role not found :(
                                @else
                                    No role data yet
                                @endif
                            </b>
                        @endforelse
                    </ul>
                </div>
                @if ($roles->hasPages())
                    <div class="card-footer">
                        {{ $roles->links('vendor.pagination.bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        // NOTIF SUCCESS
        const notif = $('.notif-success').data('notif');
        if (notif) {
            alertify
                .delay(3500)
                .log(notif);
        }

        $(document).ready(function() {
            $("form[role='alert']").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Warning",
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Cancel",
                    confirmButtonText: "Delete",
                    confirmButtonColor: '#d33',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.target.submit();
                    }
                });
            });
        });
    </script>
@endpush
