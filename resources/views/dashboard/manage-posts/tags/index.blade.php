@extends('layouts.dashboard')

@section('title')
    Tag Postingan
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('tags') }}
@endsection

@section('content')
    {{-- Alert success --}}
    <div class="notif-success" data-notif="{{ Session::get('success') }}"></div>

    <div class="row">
        <div class="col-md-12 m-b-20">
            <div class="row justify-content-center">
                <div class="col-md-2 mb-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="col-12">
                                <div class="input-group mx-1">
                                    <select class="form-control" id="selectData">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="card">
                        <div class="card-header">

                            <div class="col-12">
                                <div class="input-group mx-1">
                                    <input autocomplete="off" id="keyword" type="search" class="form-control"
                                        placeholder="Cari tag..">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" disabled>
                                            <i class="uil uil-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card m-b-30">
                <div id="show_tag" class="card-body table-responsive shadow-sm table-wrapper"></div>
            </div>
        </div>
    </div>

    {{-- Modal create --}}
    <div class="modal fade" id="createTag" tabindex="-1" role="dialog" aria-labelledby="replayTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="replayTitle">Buat tag postingan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formAddTag" action="{{ route('tags.store') }}" autocomplete="off" method="POST">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="title">Title Tag</label>
                            <input type="text" class="form-control" id="add_title" name="title"
                                placeholder="Masukkan title tag yang kamu buat" autofocus>
                            <span class="invalid-feedback d-block error-text title_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slug">Slug Tag</label>
                            <input type="text" class="form-control" id="add_slug" name="slug"
                                placeholder="Auto generate" readonly>
                            <span class="invalid-feedback d-block error-text slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="submitAdd btn btn-primary">
                            Tambah <i class="uil uil-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal update --}}
    <div class="modal fade" id="updateTag" tabindex="-1" role="dialog" aria-labelledby="titleTag" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="titleTagUpdate"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formUpdateTag" action="#" autocomplete="off" method="PUT">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="update_id">

                        <div class="form-group mb-3">
                            <label for="title">Title Tag</label>
                            <input type="text" class="form-control" id="update_title" name="title" placeholder=""
                                autofocus>
                            <span class="invalid-feedback d-block error-text update_title_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slug">Slug Tag</label>
                            <input type="text" class="form-control" id="update_slug" name="slug" placeholder=""
                                readonly>
                            <span class="invalid-feedback d-block error-text update_slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="submitUpdate btn btn-warning">
                            Update <i class="uil uil-upload-alt"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="deleteTag" tabindex="-1" role="dialog" aria-labelledby="deleteTitle"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <form action="" method="DELETE" id="formDeleteTag">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <input id="del_id" type="hidden" name="id">
                        <p id="text_del">Apakah kamu yakin ingin menghapus tag ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger deleteTag">
                            Hapus <i class="uil uil-trash"></i>
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @can('tag_create')
        <a href="javascript:void(0)" class="to-the-top" data-toggle="modal" data-target="#createTag">
            <i class="uil uil-plus"></i>
        </a>
    @endcan
@endsection

@push('js-internal')
    <script>
        const generateSlug = (value) => {
            return value.trim()
                .toLowerCase()
                .replace(/[^a-z\d-]/gi, '-')
                .replace(/-+/g, '-').replace(/^-|-$/g, "")
        }
        $('#add_title').change(function(e) {
            e.preventDefault();

            let title = $(this).val();
            $('#add_slug').val(generateSlug(title));
        });

        $('#update_title').change(function(e) {
            e.preventDefault();

            let title = $(this).val();
            $('#update_slug').val(generateSlug(title));
        });

        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            fetchTags();

            function fetchTags() {
                $.ajax({
                    url: "{{ route('tags.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        $("#show_tag").html(response);

                        let dataTable = $('table').DataTable({
                            "ordering": false,
                            "pageLength": 10,
                            "order": [
                                [1, "desc"]
                            ],
                        });

                        $('#keyword').on('keyup', function() {
                            dataTable.search(this.value).draw();
                        });

                        $('#selectData').on('change', function() {
                            dataTable.page.len(this.value).draw();
                        });
                    }
                });
            }

            $('#formAddTag').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    beforeSend: function() {
                        $('.submitAdd').attr('disabled', true);
                        $('.submitAdd').html('<i class="fas fa-spin fa-spinner"></i>');
                        // Ketika benar sudah melewati validasi maka hilangkan error validasinya
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.submitAdd').removeAttr('disabled');
                        $('.submitAdd').html('Tambah <i class="uil uil-plus"></i>');

                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $('span.' + key + '_error').text(val[0]);
                                $("input#add_" + key).addClass('is-invalid');
                            });
                        } else {
                            $('#formAddTag')[0].reset();
                            $('#createTag').modal('hide');

                            fetchTags();

                            alertify
                                .delay(3500)
                                .log(response.message);
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
                $("#updateTag").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/tags/edit') }}/" + id,
                    success: function(response) {
                        if (response.status == 200) {

                            $('#update_id').val(id);

                            $('#titleTagUpdate').text("Edit tag " + response.data.title);
                            $('#update_title').val(response.data.title);
                            $('#update_slug').val(response.data.slug);

                        } else {
                            $("#updateTag").modal('hide');
                            $(document).find('span.error-text').text('');
                            $(document).find('input.form-control').removeClass(
                                'is-invalid');

                            alertify
                                .delay(3500)
                                .log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // process updating
            $('#formUpdateTag').on('submit', function(e) {
                e.preventDefault();

                let id = $('#update_id').val();

                $.ajax({
                    url: "{{ url('dashboard/tags/update') }}/" + id,
                    method: $(this).attr('method'),
                    data: {
                        "title": $('#update_title').val(),
                        "slug": $('#update_slug').val(),
                    },
                    dataType: 'json',
                    beforeSend: function() {
                        $('.submitUpdate').attr('disabled', true);
                        $('.submitUpdate').html('<i class="fas fa-spin fa-spinner"></i>');
                        // Ketika benar sudah melewati validasi maka hilangkan error validasinya
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.submitUpdate').removeAttr('disabled');
                        $('.submitUpdate').html('Update <i class="uil uil-upload-alt"></i>');

                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#formUpdateTag')[0].reset();
                            $('#updateTag').modal('hide');

                            fetchTags();

                            alertify
                                .delay(3500)
                                .log(response.message);
                        } else if (response.status == 405) {
                            $('#updateTag').modal('hide');
                            alertify.okBtn("OK").alert(response.message);
                        } else if (response.status == 401) {
                            $('#updateTag').modal('hide');
                            alertify
                                .delay(3500)
                                .log(response.message);
                        } else {
                            $.each(response.errors, function(key, val) {
                                $('span.update_' + key + '_error').text(val[0]);
                                $("input#update_" + key).addClass('is-invalid');
                            });
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            // Show Delete
            $(document).on('click', '.del_btn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                let name = $(this).data('name');
                $('#deleteTag').modal('show');
                $('#del_id').val(id);
                $('#text_del').text('Apakah kamu yakin? ingin menghapus tag ' + name + '?');

            });
            // process deleting
            $("#formDeleteTag").on('submit', function(e) {
                e.preventDefault();

                let idTag = $('#del_id').val();

                $.ajax({
                    url: "{{ url('dashboard/tags/destroy') }}/" + idTag,
                    method: $(this).attr('method'),
                    dataType: "json",
                    data: {
                        "id": idTag
                    },
                    beforeSend: function() {
                        $('.deleteTag').attr('disabled', true);
                        $('.deleteTag').html('<i class="fas fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('.deleteTag').removeAttr('disabled');
                        $('.deleteTag').html('Hapus <i class="uil uil-trash"></i>');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#deleteTag').modal('hide');

                            fetchTags();

                            alertify
                                .delay(3500)
                                .log(response.message);
                        } else if (response.message == 404) {
                            $('#deleteTag').modal('hide');

                            alertify
                                .delay(3500)
                                .log(response.message);
                        } else {
                            $('#deleteTag').modal('hide');

                            alertify.okBtn("OK").alert(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
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

            $('body').on('shown.bs.modal', '.modal', function() {
                $(this).find(":input:not(:button):visible:enabled:not([readonly]):first").focus();
            });
        });
    </script>
@endpush
