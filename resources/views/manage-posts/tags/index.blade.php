@extends('layouts.dashboard')

@section('title')
    Tags
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('tags') }}
@endsection

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">

                    <form action="{{ route('tags.index') }}" method="GET" class="float-left">
                        <div class="input-group">
                            <input type="search" id="keyword" name="keyword" class="form-control"
                                placeholder="Search Tag.." value="{{ request()->get('keyword') }}">
                            {{-- buton submit --}}
                            <div class="input-group-append">
                                <button class="btn btn-info" type="submit">
                                    <i class="uil uil-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    @can('tag_create')
                        {{-- button create --}}
                        <a href="{{ route('tags.create') }}" class="btn btn-primary float-right"><i
                                class="uil uil-plus mr-1"></i>Create</a>
                    @endcan

                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">

                        @if (count($tags))
                            @foreach ($tags as $tag)
                                <li
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center pr-0">

                                    <label class="mt-auto mb-auto">
                                        {{ $tag->title }}
                                    </label>

                                    <div>
                                        @can('tag_update')
                                            {{-- EDIT --}}
                                            <a href="{{ route('tags.edit', ['tag' => $tag]) }}"
                                                class="btn btn-warning btn-sm"><i class="uil uil-pen"></i></a>
                                        @endcan
                                        @can('tag_delete')
                                            {{-- DELETE --}}
                                            <form action="{{ route('tags.destroy', ['tag' => $tag]) }}" method="POST"
                                                class="d-inline" role="alert"
                                                alert-text="Are you sure you want to delete the {{ $tag->title }} tag?">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="uil uil-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <b>
                                @if (request()->get('keyword'))
                                    Oops.. {{ strtoupper(request()->get('keyword')) }} tag not found :(
                                @else
                                    No tag data yet
                                @endif
                            </b>
                        @endif

                    </ul>
                </div>
                @if ($tags->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $tags->links('vendor.pagination.bootstrap-4') }}
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
