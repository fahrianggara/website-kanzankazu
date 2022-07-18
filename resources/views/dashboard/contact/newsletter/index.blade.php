@extends('layouts.dashboard')

@section('title')
    NewsLetter
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('newsletter') }}
@endsection

@section('content')
    <div class="row">

        <div class="col-12">
            <form action="#contact" method="GET" class="">
                <div class="row justify-content-center">

                    <div class="col-md-8 mb-3">
                        <div class="card m-b-10">
                            <div class="card-body">

                                <div class="col-12">
                                    <div class="input-group mx-1">
                                        <input autocomplete="off" name="keyword" type="search"
                                            value="{{ request()->get('keyword') }}" class="form-control"
                                            placeholder="Cari email..">
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

                    @if (count($newsletter) >= 1)
                        <table class="table table-hover align-items-center overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Email</th>
                                    <th>Berlanggan tanggal</th>
                                    @can('inbox_delete')
                                        <th></th>
                                    @endcan
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($newsletter as $nl)
                                    <tr>
                                        <td class="name-user">{{ $nl->email }}</td>
                                        <td class="name-user">{{ $nl->created_at->format('d M, Y') }}</td>

                                        @can('inbox_delete')
                                            <td>
                                                <div class="btn-group dropleft">
                                                    <button
                                                        class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="uil uil-ellipsis-v"></i>
                                                    </button>
                                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">

                                                        @can('inbox_delete')
                                                            <form
                                                                action="{{ route('newsletter.destroy', ['newsletter' => $nl]) }}#contact"
                                                                method="POST" role="alert"
                                                                alert-text="Apakah kamu yakin? langganan web dengan email {{ $nl->email }} akan diberhentikan langganannya.">
                                                                @csrf
                                                                @method('DELETE')

                                                                <button type="submit"
                                                                    class="dropdown-item d-flex align-items-center ">
                                                                    <i class="uil uil-trash text-danger"></i>
                                                                    <span class="ml-2">Hapus langganan</span>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                </div>

                                            </td>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                </div>
            </div>
        @else
            <div class="card-body">
                <div class="text-center">
                    <p class="card-text">
                        @if (request()->get('keyword'))
                            Oops.. sepertinya inbox dengan subjek "{{ request()->get('keyword') }}" tidak
                            ditemukan.
                        @else
                            Oops.. sepertinya inbox masih kosong.
                        @endif
                    </p>
                </div>
            </div>
            @endif

            @if ($newsletter->hasPages())
                <div class="card-footer">
                    <div class="page-footer">
                        {{ $newsletter->links('vendor.pagination.bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
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
    </script>
@endpush
