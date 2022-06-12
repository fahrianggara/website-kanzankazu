@extends('layouts.dashboard')

@section('title')
    Role
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
                            <input autocomplete="off" type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Cari role.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" data-toggle="tooltip" data-placement="bottom"
                                    title="Telusuri">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('role_create')
                        {{-- button create --}}
                        <a href="{{ route('roles.create') }}" class="btn btn-primary float-right" data-toggle="tooltip"
                            data-placement="bottom" title="Buat">
                            <i class="uil uil-plus"></i>
                        </a>
                    @endcan
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                @if ($roles->count() >= 1)
                                    <table class="table">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Role</th>
                                                <th>Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php $no = 1; @endphp
                                            @foreach ($roles as $role)
                                                <tr class="text-center">
                                                    <td>{{ $roles->perPage() * ($roles->currentPage() - 1) + $no }}
                                                    </td>
                                                    @php $no++; @endphp
                                                    <td>{{ $role->name }}</td>
                                                    <td>
                                                        @can('role_detail')
                                                            <a href="{{ route('roles.show', ['role' => $role]) }}"
                                                                class="btn btn-info btn-sm" data-toggle="tooltip"
                                                                data-placement="bottom" title="Lihat">
                                                                <i class="uil uil-eye"></i>
                                                            </a>
                                                        @endcan

                                                        @can('role_update')
                                                            <a href="{{ route('roles.edit', ['role' => $role]) }}"
                                                                class="btn btn-warning btn-sm" data-toggle="tooltip"
                                                                data-placement="bottom" title="Edit">
                                                                <i class="uil uil-pen"></i>
                                                            </a>
                                                        @endcan

                                                        @can('role_delete')
                                                            <form action="{{ route('roles.destroy', ['role' => $role]) }}"
                                                                method="POST" class="d-inline" role="alert"
                                                                alert-text="Apakah kamu yakin? role {{ $role->name }} akan dihapus permanen.">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    data-toggle="tooltip" data-placement="bottom" title="Hapus">
                                                                    <i class="uil uil-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <b>
                                        @if (request()->get('keyword'))
                                            Oops.. sepertinya role {{ strtoupper(request()->get('keyword')) }} tidak
                                            ditemukan.
                                        @else
                                            Hmm.. sepertinya role belum ada yang dibuat. <a
                                                href="{{ route('roles.create') }}">Buat?</a>
                                        @endif
                                    </b>
                                @endif
                            </div>
                        </div>
                    </div>
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
                    cancelButtonText: "Ga, batalkan!",
                    confirmButtonText: "Ya, hapus!",
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
