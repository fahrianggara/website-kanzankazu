@extends('layouts.dashboard')

@section('title')
    Manage Users
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <form action="{{ route('users.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input autocomplete="off" type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Search user.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('user_create')
                        {{-- button create --}}
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right" data-toggle="tooltip"
                            data-placement="bottom" title="User Create">
                            <i class="uil uil-plus"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr class="text-center">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 1 @endphp
                                        @forelse ($users as $user)
                                            <tr class="text-center">
                                                <td>{{ $no++ }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->roles->first()->name }}</td>
                                                <td>
                                                    {{-- Edit user --}}
                                                    @can('user_update')
                                                        <a href="{{ route('users.edit', ['user' => $user]) }}"
                                                            class="btn btn-sm btn-warning" data-toggle="tooltip"
                                                            data-placement="bottom" title="User Edit">
                                                            <i class="uil uil-pen"></i>
                                                        </a>
                                                    @endcan
                                                    {{-- Delete user --}}
                                                    @can('user_delete')
                                                        <form action="{{ route('users.destroy', ['user' => $user]) }}"
                                                            method="POST" class="d-inline" role="alert"
                                                            alert-text="Are you sure? user with the {{ $user->name }} name will be deleted">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                data-toggle="tooltip" data-placement="bottom"
                                                                title="User Delete">
                                                                <i class="uil uil-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <b>
                                                @if (request()->get('keyword'))
                                                    Oops.. {{ strtoupper(request()->get('keyword')) }} user not found :(
                                                @else
                                                    No user data yet
                                                @endif
                                            </b>
                                        @endforelse
                                    </tbody>
                                </table>
                                {{-- paginate --}}
                                @if ($users->hasPages())
                                    <div class="card-footer">
                                        <div class="page-footer">
                                            {{ $users->links('vendor.pagination.bootstrap-4') }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
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
