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
                            <select id="selectType" name="type" class="custom-select" style="border-radius: 4px">
                                <option value="image" {{ $typesSelected == 'image' ? 'selected' : null }}>Gambar</option>
                                <option value="file" {{ $typesSelected == 'file' ? 'selected' : null }}>File</option>
                            </select>
                            <div class="input-group-append">
                                <button id="selectButton" class="btn btn-primary d-none" type="submit">
                                    Terapkan
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

@push('js-internal')
    <script>
        $('#selectType').on('change', function() {
            $('#selectButton').click();
        });
    </script>
@endpush
