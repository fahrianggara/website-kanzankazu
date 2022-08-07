@extends('layouts.dashboard')

@section('title')
    Portfolio
@endsection

@section('content')
    <div class="row">
        @include('dashboard.menu-search.menu')

        <div class="col-12">
            <div class="card m-b-30">
                <div id="fetchPortfolio" class="card-body table-responsive shadow-sm table-wrapper"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreate">Buat Portfolio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formCreate" action="{{ route('portfolio.store') }}" method="POST" enctype="multipart/form-data"
                    autocomplete="off">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="add_project">Bahasa Pemrogramman</label>
                            <select id="add_project" name="project" class="form-control">
                                <option selected disabled>Silahkan Pilih Bahasa Pemrogramman</option>
                                @foreach ($projects as $data)
                                    <option value="{{ $data->id }}">{{ $data->title }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback d-block error-text add_project_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_title">Title</label>
                            <input type="text" class="form-control" id="add_title" name="title"
                                placeholder="Masukkan title portfolio">
                            <span class="invalid-feedback d-block error-text add_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input" id="add_thumbnail">
                                <label class="custom-file-label" for="thumbnail">Cari gambar
                                    project..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text add_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="add_description">Deskripsi</label>
                            <textarea class="form-control" id="add_description" name="description"
                                placeholder="Masukkan deskripsi project atau boleh kosong" cols="2" rows="4"></textarea>
                            <span class="invalid-feedback d-block error-text add_description_error"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnCreate btn btn-primary">Buat <i class="uil uil-plus"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
                    <img id="thumbnail" src="" class="img-fluid">
                    <h5 id="title" class="mt-3"></h5>
                    <p id="description"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit">Buat Project</h5>
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
                            <label for="edit_project">Bahasa Pemrogramman</label>
                            <select id="edit_project" name="project" class="form-control">
                                @foreach ($projects as $data)
                                    <option value="{{ $data->id }}">
                                        {{ $data->title }}
                                    </option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback d-block error-text edit_project_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_title">Project Title</label>
                            <input type="text" class="form-control" id="edit_title" name="title"
                                placeholder="Masukkan project title">
                            <span class="invalid-feedback d-block error-text edit_title_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_thumbnail">Thumbnail</label>
                            <div class="custom-file">
                                <input type="file" name="thumbnail" class="custom-file-input">
                                <label class="custom-file-label" for="thumbnail" id="edit_thumbnail">Cari
                                    gambar
                                    project..</label>
                            </div>
                            <span class="invalid-feedback d-block error-text edit_thumbnail_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="edit_description">Deskripsi</label>
                            <textarea class="form-control" id="edit_description" name="description"
                                placeholder="Masukkan deskripsi project atau boleh kosong" cols="2" rows="4"></textarea>
                            <span class="invalid-feedback d-block error-text edit_description_error"></span>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btnEdit btn btn-warning">Update
                            <i class="uil uil-pen"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="formDelete" action="" method="POST">

                    <div class="modal-body">
                        <input type="hidden" id="del_id">
                        <p id="del_text"></p>
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

    <a href="javascript:void(0)" class="to-the-top" data-toggle="modal" data-target="#modalCreate">
        <i class="uil uil-plus"></i>
    </a>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('input[type="file"]').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input').removeClass(
                    'is-invalid');
                $(document).find('textarea').removeClass(
                    'is-invalid');
                $('#formCreate')[0].reset();
            });

            window.addEventListener('load', function() {
                fetchPortfolios();
            });

            function fetchPortfolios() {
                $.ajax({
                    url: "{{ route('portfolio.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        $('#fetchPortfolio').html(response);

                        let dataTable = $('#tablePortfolio').DataTable({
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
                        $('.btnCreate').html('<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnCreate').prop('disabled', true);

                        $(document).find('span.invalid-feedback').text('');
                        $(document).find('input').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.btnCreate').html('Buat <i class="uil uil-plus"></i>');
                        $('.btnCreate').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.messages, function(key, value) {
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
                                'Pilih gambar project..');
                            fetchPortfolios();
                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alertify.okBtn('Ok').alert(xhr.status + "\n" + xhr.responseText + "\n" +
                            thrownError);
                    }
                });
            });

            $(document).on('click', '.show_btn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                $("#modalShow").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/portfolio/show') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {
                            $('h5#modalShow').text("Portfolio: " + response.data
                                .title);
                            if (response.data.thumbnail == "default.png") {
                                $('img#thumbnail').attr('src',
                                    "{{ asset('vendor/blog/img/default.png') }}");
                            } else {
                                $('img#thumbnail').attr('src',
                                    "{{ asset('vendor/dashboard/image/thumbnail-posts') }}/" +
                                    response.data.thumbnail);
                            }
                            $('h5#title').text(response.data.title);
                            $('p#description').text(response.data.description);
                        } else {
                            $('#modalShow').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $(document).on('click', '.edit_btn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                $("#modalEdit").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/portfolio/edit') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {
                            $('h5#modalEdit').text("Edit Portfolio: " + response.data
                                .title);
                            $('#edit_id').val(id);
                            $('#edit_project').val(response.data.projects[0].id).trigger(
                                'change');
                            $('#edit_title').val(response.data.title);
                            $('#edit_description').val(response.data
                                .description);
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

            $('#formEdit').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit_id').val();
                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: "{{ url('dashboard/portfolio/update') }}/" + id,
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
                            $.each(response.messages, function(key, value) {
                                $('span.edit_' + key + '_error').text(value[0]);
                                $('#edit_' + key).addClass('is-invalid');
                            });
                        } else {
                            $('#modalEdit').modal('hide');
                            fetchPortfolios();
                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $(document).on('click', '.del_btn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                let title = $(this).data('title');
                $("#modalDelete").modal('show');

                $('#del_id').val(id);
                $('#del_text').text("Apakah anda yakin ingin menghapus portfolio " + title + "?");
            });

            $('#formDelete').on('submit', function(e) {
                e.preventDefault();

                let id = $('#del_id').val();
                $.ajax({
                    type: "DELETE",
                    url: "{{ url('dashboard/portfolio/destroy') }}/" + id,
                    data: {
                        id: id
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
                        if (response.status == 200) {
                            $('#modalDelete').modal('hide');
                            fetchPortfolios();
                            alertify.delay(4500).log(response.message);
                        } else {
                            $('#modalDelete').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
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
