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
                            <input type="search" id="keyword" name="keyword" class="form-control"
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
                        <a href="{{ route('users.create') }}" class="btn btn-primary float-right"><i
                                class="uil uil-plus"></i>
                        </a>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        @forelse ($users as $user)
                            <div class="col-md-4">
                                <div class="card my-1">
                                    <div class="card-body">
                                        <div class="row">
                                            @if (file_exists(public_path('vendor/dashboard/image/picture-profiles/' . $user->user_image)))
                                                <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                                                    alt="{{ $user->name }}" height="64"
                                                    class="d-flex ml-2 mr-2 rounded-circle userImage">
                                            @else
                                                <img src="{{ asset('vendor/dashboard/image/picture-profiles/default.png') }}"
                                                    height="64" alt="{{ $user->name }}"
                                                    class="d-flex ml-2 mr-2 rounded-circle userImage">
                                            @endif

                                            <div class="media-body">
                                                <div class="col-md-12">
                                                    <h5 class="mt-0 font-14">Name: {{ $user->name }}</h5>
                                                    <h5 class="mt-0 font-14">Email: {{ $user->email }}</h5>
                                                    <h5 class="mt-0 font-14">Role: {{ $user->roles->first()->name }}
                                                    </h5>
                                                    <div class="float-right">
                                                        {{-- EDIT --}}
                                                        @can('user_update')
                                                            <a href="{{ route('users.edit', ['user' => $user]) }}"
                                                                class="btn btn-sm btn-warning">
                                                                <i class="uil uil-pen"></i>
                                                            </a>
                                                        @endcan

                                                        @can('user_delete')
                                                            {{-- DELETE --}}
                                                            <form action="{{ route('users.destroy', ['user' => $user]) }}"
                                                                method="POST" class="d-inline" role="alert"
                                                                alert-text="Are you sure? user with the {{ $user->name }} name will be deleted">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-sm btn-danger">
                                                                    <i class="uil uil-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. {{ strtoupper(request()->get('keyword')) }} user not found :(
                                @else
                                    No user data yet
                                @endif
                            </b>
                        @endforelse
                    </div>
                </div>

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
