@extends('layouts.dashboard')

@section('title')
    Categories
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">

                <div class="card-header">

                    <form action="{{ route('categories.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Search Category.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('category_create')
                        {{-- button create --}}
                        <a href="{{ route('categories.create') }}" class="btn btn-primary float-right"><i
                                class="uil uil-plus mr-1"></i>Create</a>
                    @endcan
                </div>

                <div class="card-body">

                    <ul class="list-group list-group-flush">
                        @if (count($categories))
                            @include('manage-posts.categories.categories-list',[
                            'categories' => $categories,
                            'count' => 0
                            ])
                        @else
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. {{ strtoupper(request()->get('keyword')) }} category not found :(
                                @else
                                    No category data yet
                                @endif
                            </b>
                        @endif
                    </ul>

                </div>

                @if ($categories->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $categories->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                @endif

            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->

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
