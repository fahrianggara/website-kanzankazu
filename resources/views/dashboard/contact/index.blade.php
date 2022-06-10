@extends('layouts.dashboard')

@section('title')
    Kontak Inbox
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list-contact') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <form action="{{ route('contact.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Cari pesan.." autocomplete="off" value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit" data-toggle="tooltip" data-placement="bottom"
                                    title="Telusuri">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if (count($contact) >= 1)
                        <div class="table-responsive">

                            <table class="table">
                                <thead>
                                    <tr class="text-center">
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Subjek</th>
                                        <th>Pesan</th>
                                        <th>Waktu Terkirim</th>
                                        @can('inbox_delete')
                                            <th>Opsi</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contact as $c)
                                        <tr class="text-center">
                                            <th>{{ $c->name }}</th>
                                            <th>{{ $c->email }}</th>
                                            <th>{{ $c->subject }}</th>
                                            <th>{{ $c->message }}</th>
                                            <th>{{ $c->created_at->format('d-m-Y / H:i:s a') }}</th>
                                            @can('inbox_delete')
                                                <th>
                                                    <a href="mailto:{{ $c->email }}" class="btn btn-sm btn-primary"
                                                        data-toggle="tooltip" data-placement="bottom" title="Balas Pesan">
                                                        <i class="uil uil-envelope-upload"></i>
                                                    </a>

                                                    <form action="{{ route('contact.destroy', ['contact' => $c]) }}"
                                                        method="POST" class="d-inline" role="alert"
                                                        alert-text="Apakah kamu yakin? inbox dengan subjek ({{ $c->subject }}) akan dihapus permanen.">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                            title="Hapus Pesan" class="btn btn-sm btn-danger">
                                                            <i class="uil uil-trash"></i>
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
                        <b>
                            @if (request()->get('keyword'))
                                {{-- Oops.. {{ strtoupper(request()->get('keyword')) }} inbox not found :( --}}
                                Oops.. sepertinya pesan dengan subjek {{ strtoupper(request()->get('keyword')) }} tidak
                                ditemukan.
                            @else
                                Oops.. sepertinya Inbox masih kosong :(
                            @endif
                        </b>
                    @endif
                </div>

                @if ($contact->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $contact->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
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
