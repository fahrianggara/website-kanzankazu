@extends('layouts.dashboard')

@section('title')
    Kategori Postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('categories') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">

        @include('dashboard.menu-search.menu')

        <div class="col-md-12">
            <div class="card m-b-30">
                <div id="fetchCategory" class="card-body table-responsive shadow-sm table-wrapper"></div>
            </div>
        </div>
    </div>

    {{-- Modal create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="create" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="create">Buat Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formCreate" action="{{ route('categories.store') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_title">Nama Kategori</label>
                            <input type="text" class="form-control" id="add_title" name="title"
                                placeholder="Masukkan title kategori">
                            <span class="invalid-feedback d-block error-text add_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_slug">Slug</label>
                            <input type="text" class="form-control" id="add_slug" name="slug"
                                placeholder="Auto generate dari title" readonly>
                            <span class="invalid-feedback d-block error-text add_slug_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail"
                                    class="custom-file-input @error('thumbnail') is-invalid @enderror" id="add_thumbnail"
                                    value="{{ old('thumbnail') }}">
                                <label class="custom-file-label" for="thumbnail">Cari gambar kategori..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text add_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_description">Deskripsi</label>
                            <textarea class="form-control" id="add_description" name="description"
                                placeholder="Masukkan deskripsi kategori atau boleh kosong" cols="2" rows="4"></textarea>
                            <span class="invalid-feedback d-block error-text add_description_error"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnBuat btn btn-primary">Buat <i class="uil uil-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Show --}}
    <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="modalShow" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShow"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="imgCate" src="" class="img-fluid">
                    <h5 id="titleCate" class="mt-3"></h5>
                    <p id="descCate"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formEdit" action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Nama Kategori</label>
                            <input type="text" class="form-control" id="edit_title" name="title"
                                placeholder="Masukkan title kategori">
                            <span class="invalid-feedback d-block error-text edit_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug"
                                placeholder="Auto generate dari title" readonly>
                            <span class="invalid-feedback d-block error-text edit_slug_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail"
                                    class="custom-file-input @error('thumbnail') is-invalid @enderror"
                                    value="{{ old('thumbnail') }}">
                                <label class="custom-file-label" id="edit_thumbnail" for="thumbnail">Cari gambar
                                    kategori..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text edit_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description"
                                placeholder="Masukkan deskripsi kategori atau boleh kosong" cols="2" rows="4"></textarea>
                            <span class="invalid-feedback d-block error-text edit_description_error"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnEdit btn btn-warning">Edit <i class="uil uil-pen"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formDelete" action="" method="POST">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <input type="hidden" id="del_id">
                        <p id="del_text">Apakah anda yakin ingin menghapus kategori ini?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnDelete btn btn-danger">
                            Hapus <i class="uil uil-trash"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @can('category_create')
        <a href="javascript:void(0)" class="to-the-top" data-toggle="modal" data-target="#modalCreate">
            <i class="uil uil-plus"></i>
        </a>
    @endcan
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // change title to slug
            $('input[name="title"]').on('keyup', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().trim().replace(/ +/g, '-').replace(/[^\w-]+/g, '');
                $('input[name="slug"]').val(slug);
            });

            // change file name
            $('input[type="file"]').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });

            // autofocus input modal create
            $('.modal').on('shown.bs.modal', function() {
                $('input[name="title"]').focus();
            });

            fetchCategories();

            function fetchCategories() {
                $.ajax({
                    url: "{{ route('categories.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        $('#fetchCategory').html(response);

                        let dataTable = $('#tableCategory').DataTable({
                            "pageLength": 10,
                            "order": [
                                [1, "asc"]
                            ],
                            "bInfo": false,
                        });

                        $('#keyword').on('keyup', function() {
                            dataTable.search(this.value).draw();
                        });

                        $('#selectData').on('change', function() {
                            dataTable.page.len(this.value).draw();
                        });

                        $('.dataTables_wrapper').find('.col-sm-12.col-md-5').remove();
                    }
                });
            }

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input').removeClass(
                    'is-invalid');
                $(document).find('textarea').removeClass(
                    'is-invalid');
                $('#formCreate')[0].reset();
            });

            // process insert data categories with ajax
            $('#formCreate').on('submit', function(e) {
                e.preventDefault();

                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    beforeSend: function() {
                        $('.btnBuat').html('<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnBuat').prop('disabled', true);

                        $(document).find('span.invalid-feedback').text('');
                        $(document).find('input').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.btnBuat').html('Buat <i class="uil uil-plus"></i>');
                        $('.btnBuat').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, value) {
                                $('span.add_' + key + '_error').text(value[0]);
                                $('#add_' + key).addClass('is-invalid');
                            });
                        } else {
                            $('#modalCreate').modal('hide');
                            $('#formCreate')[0].reset();
                            $('#formCreate').find('.custom-file-label').html(
                                'Pilih gambar kategori..');

                            fetchCategories();

                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // show modal categories
            $(document).on('click', '.show_btn', function() {

                let id = $(this).val();
                $("#modalShow").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/categories/show') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {
                            $('h5#modalShow').text("Kategori: " + response.data.title);
                            if (response.data.thumbnail == "default.png") {
                                $('img#imgCate').attr('src',
                                    "{{ asset('vendor/blog/img/default.png') }}");
                            } else {
                                $('img#imgCate').attr('src',
                                    "{{ asset('vendor/dashboard/image/thumbnail-categories') }}/" +
                                    response.data.thumbnail);
                            }
                            $('h5#titleCate').text(response.data.title);
                            $('p#descCate').text(response.data.description);
                        } else {
                            alertify.okBtn('Ok').alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // show edit modal categories
            $(document).on('click', '.edit_btn', function() {

                let id = $(this).val(); // dari attribute value
                $("#modalEdit").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/categories/edit') }}/" + id, // var id, dipanggil kesini
                    success: function(response) {
                        if (response.status == 200) {
                            $('h5#modalEdit').text("Edit Kategori: " + response.data.title);
                            $('#edit_id').val(id);
                            $('#edit_title').val(response.data.title);
                            $('#edit_slug').val(response.data.slug);
                            $('#edit_description').val(response.data.description);
                            $('#edit_thumbnail').text(response.data.thumbnail);
                            $('input[type="file"]').val(response.data.thumbnail);
                        } else {
                            $("#modalEdit").modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // process update data categories with ajax
            $('#formEdit').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit_id').val();
                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    url: "{{ url('dashboard/categories/update') }}/" + id,
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnEdit').html('<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnEdit').prop('disabled', true);

                        $(document).find('span.invalid-feedback').text('');
                        $(document).find('input').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.btnEdit').html('Edit <i class="uil uil-pen"></i>');
                        $('.btnEdit').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, value) {
                                $('span.edit_' + key + '_error').text(value[0]);
                                $('#edit_' + key).addClass('is-invalid');
                            });
                        } else {
                            $('#modalEdit').modal('hide');
                            $('#formEdit')[0].reset();
                            $('#formEdit').find('.custom-file-label').html(
                                'Pilih gambar kategori..');

                            fetchCategories();

                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // show delete modal
            $(document).on('click', '.del_btn', function() {

                let id = $(this).val();
                let title = $(this).data('title');
                $("#modalDelete").modal('show');

                $('#del_id').val(id);
                $('#del_text').text("Apakah anda yakin ingin menghapus kategori: " + title + "?");
            });

            // process delete data categories with ajax
            $('#formDelete').on('submit', function(e) {
                e.preventDefault();

                var id = $('#del_id').val();

                $.ajax({
                    url: "{{ url('dashboard/categories/destroy') }}/" + id,
                    method: "DELETE",
                    data: {
                        "id": id
                    },
                    beforeSend: function() {
                        $('.btnDelete').html('<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnDelete').prop('disabled', true);
                    },
                    complete: function() {
                        $('.btnDelete').html('Hapus <i class="uil uil-trash"></i>');
                        $('.btnDelete').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $('#modalDelete').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        } else {
                            $('#modalDelete').modal('hide');

                            fetchCategories();

                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });
        });
    </script>
@endpush
