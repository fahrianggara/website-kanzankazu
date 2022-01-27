@extends('layouts.dashboard')

@section('title')
    Inbox Contacts
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
                                placeholder="Search inbox.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    @if (count($contact))
                        <div class="table-responsive">

                            <table class="table table-bordered">
                                <thead>
                                    <tr class="text-center">
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Time</th>
                                        @can('inbox_delete')
                                            <th>Option</th>
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
                                                    <form action="{{ route('contact.destroy', ['contact' => $c]) }}"
                                                        method="POST" class="d-inline" role="alert"
                                                        alert-text="Are you sure you want to delete the {{ $c->subject }} inbox?">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-danger">
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
                                Oops.. {{ strtoupper(request()->get('keyword')) }} inbox not found :(
                            @else
                                No inbox yet
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
