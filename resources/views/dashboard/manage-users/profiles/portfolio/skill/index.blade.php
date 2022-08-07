@extends('layouts.dashboard')

@section('title', 'My Skills')

@section('content')
    <div class="row">
        @include('dashboard.menu-search.menu')

        <div class="col-12">
            <div class="card m-b-30">
                <div id="fetchTableSkill" class="card-body table-responsive shadow-sm table-wrapper"></div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreate">Buat Keahlian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formCreate" action="{{ route('skill.store') }}" autocomplete="off" method="POST">
                    @csrf
                    @method('POST')

                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="title">Nama Skill</label>
                            <input type="text" class="form-control" id="add_title" name="title"
                                placeholder="Masukkan nama skill yang kamu buat">
                            <span class="invalid-feedback d-block error-text add_title_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="add_slug" name="slug"
                                placeholder="Auto generate dari nama skill" readonly>
                            <span class="invalid-feedback d-block error-text add_slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btnCreate btn btn-primary">
                            Tambah <i class="uil uil-plus"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEdit"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="formEdit" action autocomplete="off" method>
                    <div class="modal-body">

                        <input type="hidden" id="edit_id">

                        <div class="form-group mb-3">
                            <label for="title">Skill</label>
                            <input type="text" class="form-control" id="edit_title" name="title"
                                placeholder="Masukkan nama skill yang kamu buat">
                            <span class="invalid-feedback d-block error-text edit_title_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="slug">Slug</label>
                            <input type="text" class="form-control" id="edit_slug" name="slug"
                                placeholder="Auto generate dari title" readonly>
                            <span class="invalid-feedback d-block error-text edit_slug_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btnEdit btn btn-warning">
                            Update <i class="uil uil-pen"></i>
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

                <form id="formDelete">

                    <div class="modal-body">
                        <input id="del_id" type="hidden" name="id">
                        <p id="text_del">Apakah kamu yakin ingin menghapus tag ini?</p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-danger btnDelete">
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

            $('input[name="title"]').on('keyup', function() {
                var title = $(this).val();
                var slug = title.toLowerCase().trim().replace(/ +/g, '-').replace(/[^\w-]+/g, '');
                $('input[name="slug"]').val(slug);
            });

            function resetForm() {
                $(document).find('span.error-text').text('');
                $(document).find('input').removeClass(
                    'is-invalid');
                $(document).find('textarea').removeClass(
                    'is-invalid');
            }

            $('[data-dismiss="modal"]').on('click', function() {
                $('#formCreate')[0].reset();
                resetForm();
            });

            window.addEventListener('load', function() {
                fetchSkills();
            });

            function fetchSkills() {
                $.ajax({
                    url: "{{ route('skill.fetch') }}",
                    method: "GET",
                    success: function(response) {
                        $("#fetchTableSkill").html(response);

                        let dataTable = $('#tableSkill').DataTable({
                            "ordering": false,
                            "bInfo": false,
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

                        $('.dataTables_wrapper').find('.col-sm-12.col-md-5').remove();
                    }
                });
            }

            $('#formCreate').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnCreate').html(
                            '<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnCreate').prop('disabled', true);

                        $(document).find('span.invalid-feedback').text('');
                        $(document).find('input').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.btnCreate').html(
                            'Tambah <i class="uil uil-plus-circle"></i>');
                        $('.btnCreate').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.messages, function(key, value) {
                                $('span.add_' + key + '_error').text(value[0]);
                                $('#add_' + key).addClass('is-invalid');
                            });
                        } else {
                            $('#modalCreate').modal('hide');
                            $('#formCreate')[0].reset();
                            fetchSkills();
                            resetForm();
                            alertify.delay(4500).log(response.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $(document).on('click', '.edit_btn', function(e) {
                e.preventDefault();

                var id = $(this).val();
                $('#modalEdit').modal('show');

                $.ajax({
                    url: "{{ url('dashboard/skill/edit') }}/" + id,
                    method: "GET",
                    success: function(response) {
                        $('#edit_id').val(id);

                        $('h5#modalEdit').text('Edit Title: ' + response.data.title);
                        $('#edit_title').val(response.data.title);
                        $('#edit_slug').val(response.data.slug);
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $('#formEdit').on('submit', function(e) {
                e.preventDefault();

                var id = $('#edit_id').val();

                $.ajax({
                    method: "PUT",
                    url: "{{ url('dashboard/skill/update') }}/" + id,
                    data: {
                        "title": $('#edit_title').val(),
                        "slug": $('#edit_slug').val(),
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('.btnEdit').html(
                            '<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnEdit').prop('disabled', true);

                        $(document).find('span.invalid-feedback').text('');
                        $(document).find('input').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('.btnEdit').html(
                            'Edit <i class="uil uil-pen"></i>');
                        $('.btnEdit').prop('disabled', false);
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.messages, function(key, val) {
                                $('span.edit_' + key + '_error').text(val[0]);
                                $('#edit_' + key).addClass('is-invalid');
                            });
                        } else if (response.status == 404 || response.status == 500) {
                            $('#modalEdit').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        } else {
                            $('#modalEdit').modal('hide');
                            fetchSkills();
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

                var id = $(this).val();
                var title = $(this).data('title');
                $('#modalDelete').modal('show');

                $('#del_id').val(id);
                $('#text_del').text('Apakah kamu yakin ingin menghapus skill ' + title + '?');
            });

            $('#formDelete').on('submit', function (e) {
                e.preventDefault();

                var id = $('#del_id').val();

                $.ajax({
                    type: "DELETE",
                    url: "{{ url('dashboard/skill/destroy') }}/" + id,
                    data: {
                        id: id,
                    },
                    beforeSend: function() {
                        $('.btnDelete').html(
                            '<i class="fas fa-spin fa-spinner"></i>');
                        $('.btnDelete').prop('disabled', true);
                    },
                    complete: function() {
                        $('.btnDelete').html(
                            'Hapus <i class="uil uil-trash"></i>');
                        $('.btnDelete').prop('disabled', false);
                    },
                    success: function (response) {
                        if (response.status == 500) {
                            $('#modalDelete').modal('hide');
                            alertify.okBtn('Ok').alert(response.message);
                        } else {
                            $('#modalDelete').modal('hide');
                            fetchSkills();
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
