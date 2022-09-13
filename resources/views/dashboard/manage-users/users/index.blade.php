@extends('layouts.dashboard')

@section('title')
    Daftar Pengguna
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('users') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">

        <div class="col-12 m-b-20">
            <form action="#users" method="GET" class="">
                <div class="row">
                    <div class="col-md-4 sideMenuSearch">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-2 col-3">
                                        @can('user_create')
                                            <a href="{{ route('users.create') }}#users" class="btn btn-primary float-right"
                                                data-toggle="tooltip" data-placement="bottom" title="Buat">
                                                <i class="uil uil-plus"></i>
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="col-lg-10 col-9">
                                        <div class="input-group mx-1">
                                            <select id="statusUser" name="status" class="custom-select"
                                                style="border-radius: 4px" data-toggle="tooltip" data-placement="bottom"
                                                title="Status">
                                                <option value="allowable"
                                                    {{ $statusSelected == 'allowable' ? 'selected' : null }}>
                                                    Ter-verifikasi ({{ $userAllowableCount }})
                                                </option>
                                                <option value="banned"
                                                    {{ $statusSelected == 'banned' ? 'selected' : null }}>
                                                    Ter-blokir ({{ $userBannedCount }})
                                                </option>
                                                <option value="notverification"
                                                    {{ $statusSelected == 'notverification' ? 'selected' : null }}>
                                                    Belum Ter-verifikasi ({{ $userNotverifyCount }})
                                                </option>
                                            </select>

                                            <button id="submitStatus" class="btn btn-primary d-none" type="submit">Apply
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">

                                <div class="col-12">
                                    <div class="input-group mx-1">
                                        <input autocomplete="off" name="keyword" type="search"
                                            value="{{ request()->get('keyword') }}" class="form-control"
                                            placeholder="Cari pengguna..">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" data-toggle="tooltip"
                                                data-placement="bottom" title="Telusuri">
                                                <i class="uil uil-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive shadow-sm table-wrapper">
                    @if (count($users) >= 1)
                        <table id="tableUsers" class="table table-hover align-items-center overflow-hidden">
                            <thead>
                                <tr>
                                    <th>
                                        <input type="checkbox" id="checkAllUser">
                                    </th>
                                    <th>Nama</th>
                                    <th>Role</th>
                                    @if (request()->get('status') == 'banned')
                                        <th>Provider</th>
                                        <th>Status</th>
                                        <th>Terblokir sampai</th>
                                    @elseif (request()->get('status') == 'allowable' || route('users.index'))
                                        <th>Provider</th>
                                        <th>Bergabung tanggal</th>
                                        <th>Status</th>
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr id="dataUser{{ $user->id }}">
                                        <td>
                                            <input type="checkbox" class="checkboxUser" name="ids"
                                                value="{{ $user->id }}" />
                                        </td>
                                        <td>
                                            <a href="javascript:void(0)" class="d-flex align-items-center"
                                                style="cursor: default">
                                                @if (file_exists('vendor/dashboard/image/picture-profiles/' . $user->user_image))
                                                    <img src="{{ asset('vendor/dashboard/image/picture-profiles/' . $user->user_image) }}"
                                                        width="40" class="avatar rounded-circle me-3">
                                                @elseif($user->provider == 'google' || $user->provider == 'github')
                                                    <img src="{{ $user->user_image }}" width="40"
                                                        class="avatar rounded-circle me-3">
                                                @else
                                                    <img src="{{ asset('vendor/dashboard/image/avatar.png') }}"
                                                        width="40" class="avatar rounded-circle me-3">
                                                @endif
                                                <div class="d-block ml-3">
                                                    <span class="fw-bold name-user">{{ $user->name }}</span>
                                                    <div class="small text-secondary">{{ $user->email ?? '(anonymous)' }}
                                                    </div>
                                                </div>
                                            </a>
                                        </td>

                                        <td>
                                            <span class="name-user">
                                                {{ $user->roles->first()->name }}
                                            </span>
                                        </td>

                                        @if ($user->status == 'allowable' || $user->status == 'notverification')
                                            <td>
                                                @if ($user->provider == 'google')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/google.png') }}" width="27">
                                                @elseif ($user->provider == 'github')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/github.png') }}" width="27">
                                                @elseif ($user->provider == 'anonymous')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/anonymous.png') }}" width="27">
                                                @else
                                                    <img class="logo-provider"
                                                        src="{{ asset('logo-web/android-chrome-512x512.png') }}"
                                                        width="27">
                                                @endif
                                                <span class="d-none">{{ $user->provider }}</span>
                                            </td>
                                            <td>
                                                <span class="name-user">
                                                    {{ $user->created_at->format('j M Y') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (Cache::has('user-is-online-' . $user->id))
                                                    <span class="text-success">Online</span>
                                                @else
                                                    <span class="text-secondary">Offline</span>
                                                @endif
                                            </td>
                                        @elseif ($user->status == 'banned')
                                            <td>
                                                @if ($user->provider == 'google')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/google.png') }}" width="27">
                                                @elseif ($user->provider == 'github')
                                                    <img class="logo-provider"
                                                        src="{{ asset('vendor/blog/img/github.png') }}" width="27">
                                                @else
                                                    <img class="logo-provider"
                                                        src="{{ asset('logo-web/android-chrome-512x512.png') }}"
                                                        width="27">
                                                @endif
                                                <span class="d-none">{{ $user->provider }}</span>
                                            </td>
                                            <td class="text-danger">{{ strtoupper($user->status) }}</td>
                                            <td class="text-secondary">
                                                {{ $user->banned_at->diffForHumans() }}
                                            </td>
                                        @endif

                                        <td>
                                            <div class="btn-group dropleft">
                                                <button
                                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-v"></i>
                                                </button>
                                                <div
                                                    class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-2 py-1">

                                                    @if ($user->status == 'allowable')
                                                        @if ($user->provider == 'anonymous')
                                                            @can('user_delete')
                                                                <form
                                                                    action="{{ route('users.destroy', ['user' => $user]) }}#users"
                                                                    method="POST" role="alert"
                                                                    alert-text="Apakah kamu yakin? akun dengan nama {{ $user->name }} akan dihapus permanen."
                                                                    alert-btn="Hapus" alert-clr="#d33">
                                                                    @csrf
                                                                    @method('DELETE')

                                                                    <button type="submit"
                                                                        class="dropdown-item d-flex align-items-center ">
                                                                        <i class="uil uil-trash text-danger"></i>
                                                                        <span class="ml-2">Hapus user</span>
                                                                    </button>
                                                                </form>
                                                            @endcan
                                                        @else
                                                            @if ($user->roles->first()->name == 'Admin' || $user->roles->first()->name == 'Editor')
                                                                @can('user_update')
                                                                    <a class="dropdown-item d-flex align-items-center "
                                                                        href="{{ route('users.edit', ['user' => $user]) }}#users">
                                                                        <i class="uil uil-pen text-warning"></i>
                                                                        <span class="ml-2">Edit user</span>
                                                                    </a>
                                                                @endcan
                                                                @can('user_delete')
                                                                    <a id="blokirUser" data-id="{{ $user->id }}"
                                                                        class="dropdown-item d-flex align-items-center "
                                                                        href="javascript:void(0)">
                                                                        <i class="uil uil-ban text-danger"></i>
                                                                        <span class="ml-2">Blokir user</span>
                                                                    </a>
                                                                @endcan
                                                                @can('user_delete')
                                                                    <form
                                                                        action="{{ route('users.destroy', ['user' => $user]) }}#users"
                                                                        method="POST" role="alert"
                                                                        alert-text="Apakah kamu yakin? akun dengan nama {{ $user->name }} akan dihapus permanen."
                                                                        alert-btn="Hapus" alert-clr="#d33">
                                                                        @csrf
                                                                        @method('DELETE')

                                                                        <button type="submit"
                                                                            class="dropdown-item d-flex align-items-center ">
                                                                            <i class="uil uil-trash text-danger"></i>
                                                                            <span class="ml-2">Hapus user</span>
                                                                        </button>
                                                                    </form>
                                                                @endcan
                                                            @elseif ($user->id != '1' && $user->id != '2')
                                                                @can('user_update')
                                                                    <a class="dropdown-item d-flex align-items-center "
                                                                        href="{{ route('users.edit', ['user' => $user]) }}#users">
                                                                        <i class="uil uil-pen text-warning"></i>
                                                                        <span class="ml-2">Edit user</span>
                                                                    </a>
                                                                @endcan
                                                            @else
                                                                <a class="dropdown-item d-flex align-items-center text-secondary"
                                                                    href="javascript:void(0)">
                                                                    <i class="uil uil-user-exclamation"></i>
                                                                    <span class="ml-2">Tidak bisa disetting</span>
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @elseif ($user->status == 'banned')
                                                        @can('user_update')
                                                            <form
                                                                action="{{ route('users.unblokir', ['user' => $user]) }}#users"
                                                                method="POST" class="d-inline" role="alert"
                                                                alert-text="Apakah kamu yakin? akun dengan nama {{ $user->name }} tidak jadi diblokir?"
                                                                alert-btn="Buka Blokir" alert-clr="#00b2cc">
                                                                @csrf
                                                                @method('PUT')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-check text-success"></i>
                                                                    <span class="ml-2">Buka blokir</span>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                        @can('user_delete')
                                                            <form
                                                                action="{{ route('users.destroy', ['user' => $user]) }}#users"
                                                                method="POST" class="d-inline" role="alert"
                                                                alert-text="Apakah kamu yakin? akun dengan nama {{ $user->name }} akan dihapus permanen."
                                                                alert-btn="Hapus" alert-clr="#d33">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-trash text-danger"></i>
                                                                    <span class="ml-2">Hapus user</span>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @elseif ($user->status == 'notverification')
                                                        @can('user_delete')
                                                            <form
                                                                action="{{ route('users.destroy', ['user' => $user]) }}#users"
                                                                method="POST" class="d-inline" role="alert"
                                                                alert-text="Apakah kamu yakin? akun dengan nama {{ $user->name }} akan dihapus permanen."
                                                                alert-btn="Hapus" alert-clr="#d33">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-trash text-danger"></i>
                                                                    <span class="ml-2">Hapus user</span>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif

                                                </div>
                                            </div>

                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="card-body">
                            <div class="text-center">
                                <p class="card-text">
                                    <b>
                                        @if (request()->get('keyword'))
                                            Oops.. sepertinya pengguna dengan nama
                                            {{ strtoupper(request()->get('keyword')) }} tidak ditemukan.
                                        @elseif (request()->get('status') == 'allowable')
                                            Hmm.. belum ada pengguna diwebsite {{ $setting->site_name }}.
                                        @elseif (request()->get('status') == 'banned')
                                            Oops.. sepertinya belum ada pengguna yang terblokir.
                                        @else
                                            Hmm.. belum ada pengguna diwebsite {{ $setting->site_name }}.
                                        @endif
                                    </b>
                                </p>
                            </div>
                        </div>
                    @endif
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

    {{-- Modal blokir --}}
    <div class="modal fade" id="blokirUserModal" tabindex="-1" role="dialog" aria-labelledby="blokirTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="blokirTitle">Blokir <span id="userName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formBlokirUser" action="#" autocomplete="off" method="POST">
                    <div class="modal-body">
                        @csrf
                        @method('POST')

                        <input type="hidden" id="userId" name="id" value="">

                        <div class="form-group mb-3">
                            <label for="banned">Pilih hari-nya</label>
                            <select class="form-control" name="banned" id="bannedDay">
                                <option value="{{ \Carbon\Carbon::now()->addDays(1) }}">1 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addDays(3) }}">3 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addDays(7) }}">7 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addDays(14) }}">14 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addDays(20) }}">20 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addDays(30) }}">30 hari</option>
                                <option value="{{ \Carbon\Carbon::now()->addYears(10) }}">Permanen</option>
                            </select>
                            <span class="invalid-feedback d-block error-text banned_error"></span>
                        </div>

                        <br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="submitBlokir btn btn-danger">
                                Blokir
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="javascript:void(0)" class="btn btn-danger deleteAllButton d-none" data-toggle="tooltip"
        data-placement="right" title="Delete user">
        <i class="uil uil-trash"></i>
    </a>

@endsection

@push('css-internal')
    <style>
        input[type="checkbox"] {
            cursor: pointer;
            width: 15px;
            height: 15px;
            display: flex;
            align-items: center;
            justify-content: end;
        }

        .deleteAllButton {
            position: fixed;
            bottom: 12%;
            z-index: 1;
            border-radius: 50%;
            width: 60px;
            height: 60px;
        }

        .deleteAllButton i {
            font-size: 25px;
            position: relative;
            top: 4px;
        }
    </style>
@endpush

@push('js-internal')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#statusUser').on('change', function() {
                $('#submitStatus').click();
            });

            // checkbox all
            $('#checkAllUser').click(function(e) {
                let checkedCount = $('.checkboxUser').length;
                $('.deleteAllButton').attr('data-original-title', 'Hapus ' + checkedCount + ' User');

                if ($(this).is(':checked')) {
                    $('.checkboxUser').prop('checked', true);
                    $('.deleteAllButton').removeClass('d-none');
                } else {
                    $('.checkboxUser').prop('checked', false);
                    $('.deleteAllButton').addClass('d-none');
                }
            });

            // checked user
            $('.checkboxUser').click(function(e) {

                let checkedLength = $('.checkboxUser').filter(':checked').length;
                let checkedCount = $('input:checkbox[name="ids"]:checked').length;

                if ($(this).is(':checked')) {
                    $('.deleteAllButton').removeClass('d-none');
                    $('.deleteAllButton').attr('data-original-title', 'Hapus ' + checkedCount + ' User');
                } else {
                    $('.deleteAllButton').attr('data-original-title', 'Hapus ' + checkedCount + ' User');
                }

                if (checkedLength == 0) {
                    $('.deleteAllButton').addClass('d-none');

                    if ($('#checkAllUser').is(':checked')) {
                        $('#checkAllUser').prop('checked', false);
                    }
                } else if (checkedLength == $('.checkboxUser').length) {
                    if (!$('#checkAllUser').is(':checked')) {
                        $('#checkAllUser').prop('checked', true);
                    }
                }
            });

            $('.deleteAllButton').click('click', function(e) {
                e.preventDefault();
                let checkedCount = $('input:checkbox[name="ids"]:checked').length;

                Swal.fire({
                    title: "Warning",
                    text: `Apakah kamu yakin? akan menghapus user sebanyak ${checkedCount} data ?`,
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: true,
                    cancelButtonText: "Ga, batalkan!",
                    confirmButtonText: 'Iya, Hapus!',
                    confirmButtonColor: '#d33',
                    reverseButtons: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        let userAll = [];

                        $('input:checkbox[name="ids"]:checked').each(function() {
                            userAll.push($(this).val());
                        });

                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('users.deleteAllUser') }}",
                            data: {
                                ids: userAll,
                            },
                            success: function(response) {
                                $.each(userAll, function(key, val) {
                                    $('tr#dataUser' + val).remove();
                                });

                                alertify.delay(2000).log(
                                    'User sebanyak ' + checkedCount + ' data, berhasil dihapus!'
                                );

                                $('.deleteAllButton').addClass('d-none');

                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" +
                                    thrownError);
                            }
                        });
                    }
                });
            });

            // show data user
            $(document).on('click', '#blokirUser', function(e) {
                e.preventDefault();

                let user_id = $(this).data('id');
                $('#blokirUserModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/users-show') }}/" + user_id,
                    success: function(response) {
                        if (response.status == 400) {
                            alertify.delay(4500).error(response.msg);
                        } else {
                            $('#userId').val(user_id);
                            $('#userName').html(response.data.name);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // blokir data
            $('#formBlokirUser').on('submit', function(e) {
                e.preventDefault();

                let id = $('#userId').val();

                $.ajax({
                    method: "POST",
                    url: "{{ url('dashboard/user-blokir') }}/" + id,
                    data: {
                        "banned": $('#bannedDay').val()
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status == 200) {
                            alertify.delay(4500).log(response.msg);

                            setTimeout((function() {
                                window.location.href = response.redirect +
                                    '#profile';
                                window.location.reload();
                            }), 980);

                            $('#blokirUserModal').modal('hide');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

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
