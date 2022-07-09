@extends('layouts.dashboard')

@section('title')
    User Providers
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('userProviders') }}
@endsection

@section('content')
    <div class="row">

        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userProviders" class="table table-bordered">
                            <thead>
                                <tr class="text-center">
                                    <th>Email</th>
                                    <th>User UID</th>
                                    <th>Provider</th>
                                    <th>Status</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $user)
                                    <tr class="text-center">

                                        <td>{{ $user->email ?? '( anonymous )' }}</td>
                                        <td id="{{ $user->uid }}">{{ $user->uid }}</td>
                                        <td>
                                            @foreach ($user->providerData as $provider)
                                                <span class="d-none">{{ $provider->providerId }}</span>

                                                @if ($provider->providerId == 'google.com')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/google.png') }}" width="27">
                                                @elseif ($provider->providerId == 'github.com')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/github.png') }}" width="27">
                                                @endif
                                            @endforeach
                                            @if (count($user->providerData) == 0)
                                                <img class="logo-provider"
                                                    src="{{ asset('vendor/blog/img/anonymous.png') }}" width="27">
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->disabled)
                                                <span class="badge badge-danger">Disabled</span>
                                            @else
                                                <span class="badge badge-success">Enabled</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (count($user->providerData) == 0)
                                                <form
                                                    action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users"
                                                    class="d-inline" method="POST" role="alert"
                                                    alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                    alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        data-toggle="tooltip" data-placement="bottom" title="Hapus akun">
                                                        <i class="uil uil-trash"></i>
                                                    </button>
                                                </form>
                                            @else
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
                "pageLength": 10,
                "responsive": true,
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
