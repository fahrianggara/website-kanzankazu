@extends('layouts.dashboard')

@section('title')
    User Providers
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('userProviders') }}
@endsection

@section('content')
    <div class="row">
        {{-- <div class="col-12">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card m-b-30">
                        <div class="card-header">
                            <div class="row">

                                <div class="col-lg-12 col-9">
                                    <form action="#" method="GET">
                                        <div class="input-group">
                                            <input autocomplete="off" type="search" id="keyword" name="keyword"
                                                class="form-control" placeholder="Cari pengguna provider.."
                                                value="{{ request()->get('keyword') }}">

                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit" data-toggle="tooltip"
                                                    data-placement="bottom" title="Telusuri">
                                                    <i class="uil uil-search"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="col-12">
            <div class="card m-b-30">
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th>User UID</th>
                                <th>Email</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th>Options</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr class="text-center">

                                    <td id="{{ $user->uid }}">{{ $user->uid }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->providerData as $provider)
                                            {{ $provider->providerId }}
                                        @endforeach
                                    </td>
                                    <td>
                                        @if ($user->disabled)
                                            <span class="badge badge-danger">Disabled</span>
                                        @else
                                            <span class="badge badge-success">Enabled</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->disabled == true)
                                            <form action="{{ route('users.enableProvider', ['uid' => $user->uid]) }}#users" class="d-inline"
                                                method="POST" role="alert"
                                                alert-text='Apakah kamu yakin? akun dengan email "{{ $user->email }}" akan bisa mengakses website {{ $setting->site_name }} lagi.'
                                                alert-btn="ENABLE" alert-clr="#00C851">
                                                @csrf
                                                @method('POST')

                                                <button type="submit" class="btn btn-success btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Enable akun">
                                                    <i class="uil uil-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users" class="d-inline"
                                                method="POST" role="alert"
                                                alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Hapus akun">
                                                    <i class="uil uil-trash"></i>
                                                </button>
                                            </form>
                                        @elseif ($user->disabled == false)
                                            <form action="{{ route('users.disableProvider', ['uid' => $user->uid]) }}#users" class="d-inline"
                                                method="POST" role="alert"
                                                alert-text='Apakah kamu yakin? akun dengan email "{{ $user->email }}" tidak akan bisa mengakses website {{ $setting->site_name }} lagi.'
                                                alert-btn="DISABLE" alert-clr="#d33">
                                                @csrf
                                                @method('POST')

                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip"
                                                    data-placement="bottom" title="Disable akun">
                                                    <i class="uil uil-ban"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <h5 class="text-center">Tidak ada data user</h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $("form[role='alert']").submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "Warning",
                    text: $(this).attr('alert-text'),
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Ga, batalkan!",
                    confirmButtonText: $(this).attr('alert-btn'),
                    confirmButtonColor: $(this).attr('alert-clr'),
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
