@extends('layouts.dashboard')

@section('title')
    User Providers
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('userProviders') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 m-b-20">
            <div class="row justify-content-center">
                <div class="col-md-2 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <div class="input-group mx-1">
                                    <select class="form-control" id="selectData">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">

                            <div class="col-12">
                                <div class="input-group mx-1">
                                    <input autocomplete="off" id="keyword" type="search" class="form-control"
                                        placeholder="Cari pengguna..">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" disabled>
                                            <i class="uil uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive shadow-sm table-wrapper">
                    <table id="userProviders" class="table user-table table-hover align-items-center overflow-hidden">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>User Uid</th>
                                <th>Provider</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($users as $key => $user)
                                <tr>

                                    <td>
                                        <a href="javascript:void(0)" class="d-flex align-items-center"
                                            style="cursor: default">
                                            @if ($user->photoUrl != null)
                                                <img src="{{ $user->photoUrl }}" width="40"
                                                    class="avatar rounded-circle me-3">
                                            @else
                                                <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" width="40"
                                                    class="avatar rounded-circle me-3">
                                            @endif
                                            <div class="d-block ml-3">
                                                <span
                                                    class="fw-bold name-user">{{ $user->displayName ?? 'Anonymous' }}</span>
                                                <div class="small text-secondary">{{ $user->email ?? '(anonymous)' }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>

                                    <td id="{{ $user->uid }}" class="name-user">{{ $user->uid }}</td>
                                    <td>
                                        @foreach ($user->providerData as $provider)
                                            <span class="d-none">{{ $provider->providerId }}</span>

                                            @if ($provider->providerId == 'google.com')
                                                <img class="logo-provider" src="{{ asset('vendor/blog/img/google.png') }}"
                                                    width="27">
                                            @elseif ($provider->providerId == 'github.com')
                                                <img class="logo-provider" src="{{ asset('vendor/blog/img/github.png') }}"
                                                    width="27">
                                            @endif
                                        @endforeach
                                        @if (count($user->providerData) == 0)
                                            <img class="logo-provider" src="{{ asset('vendor/blog/img/anonymous.png') }}"
                                                width="27">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($user->disabled)
                                            <span class="text-danger">DISABLED</span>
                                        @else
                                            <span class="text-success">ENABLED</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button
                                                class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">
                                                @if (count($user->providerData) == 0)
                                                    <form
                                                        action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users"
                                                        class="d-inline" method="POST" role="alert"
                                                        alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                        alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="dropdown-item d-flex align-items-center ">
                                                            <i class="uil uil-trash text-danger"></i>
                                                            <span class="ml-2">Hapus user</span>
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

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-check text-success"></i>
                                                                    <span class="ml-2">Enable akun</span>
                                                                </button>
                                                            </form>

                                                            <form
                                                                action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users"
                                                                class="d-inline" method="POST" role="alert"
                                                                alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                                alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-trash text-danger"></i>
                                                                    <span class="ml-2">Hapus akun</span>
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

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-ban text-danger"></i>
                                                                    <span class="ml-2">Disable akun</span>
                                                                </button>
                                                            </form>
                                                            <form
                                                                action="{{ route('users.deleteProvider', ['uid' => $user->uid]) }}#users"
                                                                class="d-inline" method="POST" role="alert"
                                                                alert-text='Apakah kamu yakin?! akun dengan email "{{ $user->email }}" akan di hapus PERMANEN!'
                                                                alert-btn="HAPUS AKUN" alert-clr="#d33">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-trash text-danger"></i>
                                                                    <span class="ml-2">Hapus akun</span>
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @else
                                                        <button disabled class="dropdown-item d-flex align-items-center">
                                                            <i class="uil uil-ban text-secondary"></i>
                                                            <span class="ml-2">Disable akun</span>
                                                        </button>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
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
            let dataTable = $('#userProviders').DataTable({
                "order": [
                    [4, "desc"]
                ],
                "pageLength": 10,
                "bInfo": true,
            });

            $('#keyword').on('keyup', function() {
                dataTable.search(this.value).draw();
            });

            $('#selectData').on('change', function() {
                dataTable.page.len(this.value).draw();
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
