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
                            <div class="card-header">

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

                @if (count($newsletter) >= 1)
                    <div class="table-responsive">

                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>#</th>
                                    <th>Email</th>
                                    @can('inbox_delete')
                                        <th>Opsi</th>
                                    @endcan
                                </tr>

                            </thead>
                            <tbody>
                                @php $no = 1; @endphp
                                @foreach ($newsletter as $nl)
                                    <tr class="text-center">
                                        <th>{{ $newsletter->perPage() * ($newsletter->currentPage() - 1) + $no }}</th>
                                        @php $no++; @endphp
                                        <th>{{ $nl->email }}</th>

                                        @can('inbox_delete')
                                            <th>

                                                <form action="{{ route('newsletter.destroy', ['newsletter' => $nl]) }}#contact"
                                                    method="POST" role="alert"
                                                    alert-text="Apakah kamu yakin? langganan web dengan email {{ $nl->email }} akan diberhentikan langganannya.">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                        title="Hapus langganan" class="btn btn-sm btn-danger mt-1">
                                                        <i class="uil uil-envelope-block"></i>
                                                    </button>
                                                </form>

                                            </th>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

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
