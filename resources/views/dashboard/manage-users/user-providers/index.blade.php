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
        </div> --}}

        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive">
                    <div class="">
                        <table id="userProviders" class="table table-bordered">
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
                                            @if ($user->email != Auth::user()->email)
                                                @if ($user->disabled == true)
                                                    <form
                                                        action="{{ route('users.enableProvider', ['uid' => $user->uid]) }}#users"
                                                        class="d-inline" method="POST" role="alert"
                                                        alert-text='Apakah kamu yakin? akun dengan email "{{ $user->email }}" akan bisa mengakses website {{ $setting->site_name }} lagi.'
                                                        alert-btn="ENABLE" alert-clr="#00C851">
                                                        @csrf
                                                        @method('POST')

                                                        <button type="submit" class="btn btn-success btn-sm"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Enable akun">
                                                            <i class="uil uil-check"></i>
                                                        </button>
                                                    </form>

                                                    <form
                                                        action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users"
                                                        class="d-inline" method="POST" role="alert"
                                                        alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                        alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Hapus akun">
                                                            <i class="uil uil-trash"></i>
                                                        </button>
                                                    </form>
                                                @elseif ($user->disabled == false)
                                                    <form
                                                        action="{{ route('users.disableProvider', ['uid' => $user->uid]) }}#users"
                                                        class="d-inline" method="POST" role="alert"
                                                        alert-text='Apakah kamu yakin? akun dengan email "{{ $user->email }}" tidak akan bisa mengakses website {{ $setting->site_name }} lagi.'
                                                        alert-btn="DISABLE" alert-clr="#d33">
                                                        @csrf
                                                        @method('POST')

                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            data-toggle="tooltip" data-placement="bottom"
                                                            title="Disable akun">
                                                            <i class="uil uil-ban"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <button disabled class="btn btn-secondary btn-sm">
                                                    <i class="uil uil-ban" data-toggle="tooltip" data-placement="top"
                                                        title="Kamu tidak bisa meng-disable akun kamu sendiri.">
                                                    </i>
                                                </button>
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
    </div>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $('#userProviders').DataTable({
                "order": [
                    [4, "desc"]
                ],
                "pageLength": 10
            });

            $('#userProviders tbody').on('click', "form[role='alert']", function() {
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


        });
    </script>
@endpush
