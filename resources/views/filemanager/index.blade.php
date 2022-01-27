@extends('layouts.dashboard')

@section('title')
    File Manager
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('filemanager') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">

                <div class="card-header d-flex justify-content-end">
                    <form action="" method="GET" style="width: 240px">
                        <div class="input-group">
                            <select name="type" class="custom-select">
                                @foreach ($types as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ $typesSelected == $value ? 'selected' : null }}>
                                        {{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    Apply
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body">
                    <iframe src="{{ route('unisharp.lfm.show') }}?type={{ $typesSelected }}"
                        style="width: 100%; height: 500px; overflow: hidden; border: none;">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection