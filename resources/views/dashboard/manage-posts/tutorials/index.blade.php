@extends('layouts.dashboard')

@section('title')
    Tutorial Postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('tutorials') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">

        @include('dashboard.menu-search.menu')

        <div class="col-12">
            <div class="card m-b-30">
                <div id="fetchTutorial" class="card-body table-responsive shadow-sm table-wrapper"></div>
            </div>
        </div>
    </div>

    {{-- Modal Create --}}
    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreate">Buat Tutorial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formCreate" action="{{ route('tutorials.store') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_title">Nama Tutorial</label>
                            <input type="text" class="form-control" id="add_title" name="title"
                                placeholder="Masukkan title Tutorial">
                            <span class="invalid-feedback d-block error-text add_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_slug">Slug</label>
                            <input type="text" class="form-control" id="add_slug" name="slug"
                                placeholder="Auto generate dari title" readonly>
                            <span class="invalid-feedback d-block error-text add_slug_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_colors">Warna</label>
                            <input type="text" name="bg_color" id="add_bg_color"
                                class="complex-colorpicker form-control asColorPicker-input" placeholder="#xxxxxx">
                            <span class="invalid-feedback d-block error-text add_bg_color_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input" id="add_thumbnail">
                                <label class="custom-file-label" for="thumbnail">Cari gambar Tutorial..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text add_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_description">Deskripsi</label>
                            <textarea class="form-control" id="add_description" name="description"
                                placeholder="Masukkan deskripsi Tutorial atau boleh kosong" cols="2" rows="4"></textarea>
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

    {{-- Modal show --}}
    <div class="modal fade" id="modalShow" tabindex="-1" role="dialog" aria-labelledby="modalShow"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalShow">
                        Tutorial: <span id="show_title"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img id="imgTuto" src="" class="img-fluid">
                    <h5 id="titleTuto" class="mt-3" style=""></h5>
                    <p id="descTuto"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formEdit" action="" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')

                    <input type="hidden" id="edit_id">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_title">Nama Tutorial</label>
                            <input type="text" class="form-control" id="edit_title" name="title"
                                placeholder="Masukkan title Tutorial">
                            <span class="invalid-feedback d-block error-text edit_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_slug">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug"
                                placeholder="Auto generate dari title" readonly>
                            <span class="invalid-feedback d-block error-text edit_slug_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_bg_color">Warna</label>
                            <div class="input-group">
                                <input type="text" name="bg_color" id="edit_bg_color"
                                    class="complex-colorpicker form-control asColorPicker-input">
                                <span class="invalid-feedback d-block error-text edit_bg_color_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="edit_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input">
                                <label class="custom-file-label" id="edit_thumbnail" for="thumbnail">Cari gambar
                                    Tutorial..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text edit_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description"
                                placeholder="Masukkan deskripsi Tutorial atau boleh kosong" cols="2" rows="4"></textarea>
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
                        <p id="del_text">Apakah anda yakin ingin menghapus tutorial:
                            <span id="del_title"></span>
                            ?
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnDelete btn btn-danger">Hapus <i
                                class="uil uil-trash"></i></button>
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

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input').removeClass(
                    'is-invalid');
                $(document).find('textarea').removeClass(
                    'is-invalid');
                $('#formCreate')[0].reset();
            });

            fetchTutorials();

            function fetchTutorials() {
                $.ajax({
                    url: "{{ route('tutorials.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        $('#fetchTutorial').html(response);

                        let dataTable = $('table').DataTable({
                            "pageLength": 10,
                            "order": [
                                [1, "desc"]
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
                        } else if (response.status == 500) {
                            $('#modalCreate').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        } else {
                            $('#modalCreate').modal('hide');
                            $('#formCreate')[0].reset();
                            $('#formCreate').find('.custom-file-label').html(
                                'Pilih gambar tutorial..');

                            fetchTutorials();

                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alertify.okBtn('Ok').alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });

            // show tutorial
            $(document).on('click', '.show_btn', function() {

                let id = $(this).val();
                $("#modalShow").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/tutorials/show') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {
                            $('#show_title').text(response.data.title).attr('style', 'color:' +
                                response.data.bg_color);
                            if (response.data.thumbnail == "default.png") {
                                $('img#imgTuto').attr('src',
                                    "{{ asset('vendor/blog/img/default.png') }}");
                            } else {
                                $('img#imgTuto').attr('src',
                                    "{{ asset('vendor/dashboard/image/thumbnail-tutorials') }}/" +
                                    response.data.thumbnail);
                            }
                            $('h5#titleTuto').text(response.data.title).attr('style', 'color:' +
                                response.data.bg_color);
                            $('p#descTuto').text(response.data.description);
                        } else {
                            alertify.okBtn('Ok').alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // edit tutorial
            $(document).on('click', '.edit_btn', function() {

                let id = $(this).val();
                $("#modalEdit").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/tutorials/edit') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {
                            $('h5#modalEdit').text("Edit Tutorial: " + response.data.title);
                            $('#edit_id').val(id);
                            $('#edit_title').val(response.data.title);
                            $('#edit_slug').val(response.data.slug);
                            $('#edit_bg_color').val(response.data.bg_color);
                            $('#edit_description').val(response.data.description);
                            $('#edit_thumbnail').text(response.data.thumbnail);
                            $('input[type="file"]').val(response.data.thumbnail);
                            $(document).find('.asColorPicker-trigger span').attr('style',
                                'background: ' + response.data.bg_color)
                        } else {
                            $("#modalEdit").modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        $("#modalEdit").modal('show');
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $('#formEdit').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit_id').val();
                var form = $(this)[0];
                var formData = new FormData(form);

                $.ajax({
                    url: "{{ url('dashboard/tutorials/update') }}/" + id,
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
                                'Pilih gambar tutorial..');

                            fetchTutorials();

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
                let color = $(this).data('color');
                $("#modalDelete").modal('show');

                $('#del_id').val(id);
                $('#del_title').text(title).attr('style', 'color: ' + color);
            });

            $('#formDelete').on('submit', function(e) {
                e.preventDefault();

                var id = $('#del_id').val();

                $.ajax({
                    url: "{{ url('dashboard/tutorials/destroy') }}/" + id,
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
                        if (response.status == 500) {
                            $('#modalDelete').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        } else {
                            $('#modalDelete').modal('hide');

                            fetchTutorials();

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
