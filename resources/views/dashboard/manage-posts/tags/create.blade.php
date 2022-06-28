@extends('layouts.dashboard')

@section('title')
    Buat tag
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('add_tags') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card m-b-30">
                <div class="card-header">
                    <a href="javascript:void(0)" class="btn btn-primary addRow float-right" data-toggle="tooltip"
                        data-placement="right" title="Tambah form data">
                        <i class="uil uil-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    <form id="tagsCreate" action="{{ route('tags.store') }}#posts" method="POST">
                        @csrf

                        <div class="row rowTags justify-content-center">

                            <div class="col-lg-6 form-group">
                                <label for="tag_title">Nama Tag</label>

                                <input type="text" id="tag_title" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    placeholder="Masukkan Nama tag" value="{{ old('title') }}" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-lg-6 form-group">
                                <label for="tag_slug">Slug</label>

                                <input type="text" name="slug" id="tag_slug"
                                    class="form-control @error('slug') is-invalid @enderror" placeholder="Generate sendiri"
                                    value="{{ old('slug') }}" readonly>

                                @error('slug')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                </div>
                <div class="card-footer">
                    <div class="float-right">
                        <a class="btn btn-info px-4" href="{{ route('tags.index') }}#posts">Kembali</a>
                        <button type="submit" class="btn btn-success px-4">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            const generateSlug = (value) => {
                return value.trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, '-')
                    .replace(/-+/g, '-').replace(/^-|-$/g, "")
            }

            $('#tag_title').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                $('#tag_slug').val(generateSlug(title));
            });

            // $(document).on('click', '.addRow', function() {
            //     let row = "<div class='row rowTagsAdd justify-content-center'>" +
            //                 "<div class='col-lg-5 form-group'>" +
            //                     "<label for='tag_title'>Nama Tag</label>" +
            //                     "<input type='text' id='tag_title' name='title[]' class='form-control' placeholder='Masukkan Nama tag' autocomplete='off'>" +
            //                 "</div>" +
            //                 "<div class='col-lg-6 form-group d-none'>" +
            //                     "<label for='tag_slug'>Slug</label>" +
            //                     "<input type='text' name='slug[]' id='tag_slug' class='form-control' placeholder='Generate sendiri' readonly>" +
            //                 "</div>" +
            //                 "<div class='col-lg-1 form-group'>" +
            //                     "<label for=''>Hapus</label>" +
            //                     "<a href='javascript:void(0)' class='btn btn-danger removeRow' data-toggle='tooltip' data-placement='left' title='Hapus form data'> <i class='uil uil-trash'></i></a>" +
            //                 "</div>" +
            //             "</div>";
            //     $('#tagsCreate').append(row);

            //     if (row.length) {
            //         $('.rowTags').addClass('d-none');
            //         $('.rowTagsAdd').removeClass('d-none');
            //     }

            //     $(document).on('click', '.removeRow', function() {
            //         $(this).parent().parent().remove();

            //         if ($('.rowTagsAdd').length == 0) {

            //         }
            //     });
            // });
        });
    </script>
@endpush
