@extends('layouts.dashboard')

@section('title')
    Dashboard
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dashboard') }}
@endsection

@section('content')
    <div class="row">

        @can('manage_posts')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('posts.index') }}#posts" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-book-medical"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countPost }}</h5>
                                        <p class="mb-0 text-muted">Postingan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_categories')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('categories.index') }}#posts" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-bookmark"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countCategory }}</h5>
                                        <p class="mb-0 text-muted">Kategori</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_tags')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('tags.index') }}#posts" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-tag-alt"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countTag }}</h5>
                                        <p class="mb-0 text-muted">Tag</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_categories')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('tutorials.index') }}#posts" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-layer-group"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countTutorial }}</h5>
                                        <p class="mb-0 text-muted">Tutorial</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_roles')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('roles.index') }}#users" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-user-arrows"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countRole }}</h5>
                                        <p class="mb-0 text-muted">Roles</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_users')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('users.index') }}#users" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-users-alt"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countUser }}</h5>
                                        <p class="mb-0 text-muted">Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

        @can('manage_inbox')
            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('contact.index') }}#contact" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-inbox"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countContact }}</h5>
                                        <p class="mb-0 text-muted">Inbox</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-3">
                <div class="card m-b-30">
                    <a href="{{ route('newsletter.index') }}#contact" class="waves-effect">
                        <div class="card-body">
                            <div class="d-flex flex-row">
                                <div class="col-3 align-self-center">
                                    <div class="round">
                                        <i class="uil uil-at"></i>
                                    </div>
                                </div>
                                <div class="col-9 align-self-center text-center">
                                    <div class="m-l-10">
                                        <h5 class="mt-0 round-inner">{{ $countNewsletter }}</h5>
                                        <p class="mb-0 text-muted">Pelanggan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan

    </div>

    <div class="row">

        <div class="col-lg-6">
            <div class="sticky m-b-30">
                <div class="card ">
                    <div class="card-header">
                        Todo List
                    </div>

                    <div class="card-body">
                        <form id="formCreate" action="{{ route('todolist.store') }}" method="post"
                            class="input-group mb-3" autocomplete="off">
                            @method('POST')
                            @csrf

                            <input type="text" name="title" class="form-control" placeholder="Tambah tugas baru.."
                                id="inputTitle">

                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="btnAdd">Tambah</button>
                            </div>
                        </form>

                        <div id="fetchLists"></div>

                    </div>
                </div>
            </div>
        </div>

        {{-- Modal edit --}}
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEdit"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-centered ">
                    <div class="modal-body">
                        <form id="formEdit" action="#" method="PUT" class="input-group" autocomplete="off">
                            @csrf

                            <input type="hidden" id="edit_id">
                            <input type="hidden" name="oldTitle" id="old_title_edit">
                            <input type="text" name="title" id="edit_title" class="form-control">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="btnEdit">Edit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('js-internal')
            <script>
                $(function() {
                    // titleTodo click checkbox
                    // $(document).on('click', '#titleTodo', function() {
                    //     $(this).closest('li').find('input[type="checkbox"]').click();
                    // });

                    // csrf
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    fetchLists()

                    // fetch
                    function fetchLists() {
                        $.ajax({
                            type: "get",
                            url: "{{ route('todolist.index') }}",
                            success: function(response) {
                                $('#fetchLists').html(response);
                                $('#todoList').sortable({
                                    items: 'li',
                                    opacity: 0.8,
                                    update: function() {
                                        sortAbleItems()
                                    }
                                });

                                $('input#checkList').css('cursor', 'pointer');

                                ln = $('#todoList li.notDone').length;
                                todoListLn = ln - $('#todoList li').length;

                                // add border bottom to last item
                                if (todoListLn != 0) {
                                    $('.titleCompleted:eq(' + todoListLn + ')').removeClass('d-none');
                                    $('.titleCompleted').text('Tugas yang diselesaikan (' + $(
                                        '#todoList li.done').length + ')');
                                }

                                if ($('#todoList li.notDone').length == 0) {
                                    $('.titleTask').addClass('d-none');
                                    $('.titleCompleted').addClass('d-none');
                                    $('#ul.titleCompleted').removeClass('d-none');
                                } else {
                                    $('.titleTask').text('Tugas (' + $('#todoList li.notDone').length + ')');

                                }
                            }
                        });
                    }

                    function sortAbleItems() {
                        var sort = [];

                        $("li.itemLists").each(function(index, element) {
                            sort.push({
                                id: $(this).attr('data-id'),
                                position: index + 1
                            });
                        });

                        $.ajax({
                            type: "POST",
                            url: "{{ route('todolist.sort') }}",
                            data: {
                                sort: sort
                            },
                            dataType: "json",
                            success: function(response) {
                                fetchLists()
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr
                                    .responseText + "\n" +
                                    thrownError);
                            }
                        });
                    }

                    // formCreate on submit
                    $('#formCreate').on('submit', function(e) {
                        e.preventDefault();

                        $.ajax({
                            url: $(this).attr('action'),
                            method: $(this).attr('method'),
                            data: $(this).serialize(),
                            dataType: 'json',
                            beforeSend: function() {
                                $('#btnAdd').attr('disabled', true);
                                $('#btnAdd').html('<i class="fas fa-spin fa-spinner"></i>');
                            },
                            complete: function() {
                                $('#btnAdd').attr('disabled', false);
                                $('#btnAdd').html('Tambah');
                            },
                            success: function(response) {
                                if (response.status == 400) {
                                    alertify
                                        .delay(4000)
                                        .error(response.error.title[0]);
                                } else {
                                    $('#formCreate')[0].reset();
                                    alertify.delay(4000).log(response.message);

                                    fetchLists()
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });

                    $(document).on('click', '.edit_btn', function() {

                        let id = $(this).attr('data-id');
                        $("#modalEdit").modal('show');

                        $.ajax({
                            type: "GET",
                            url: "{{ url('dashboard/todolist') }}/" + id,
                            success: function(response) {
                                if (response.status == 200) {
                                    $('#edit_id').val(id);
                                    $('#edit_title').val(response.data.title);
                                    $('#old_title_edit').val(response.data.title);
                                } else {
                                    $("#modalEdit").modal('hide');
                                    alertify.delay(4000).error(response.message);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });

                    $('#formEdit').on('submit', function(e) {
                        e.preventDefault();

                        let id = $('#edit_id').val();

                        $.ajax({
                            type: "PUT",
                            url: "{{ url('dashboard/todolist') }}/" + id,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "title": $('#edit_title').val(),
                                "oldTitle": $('#old_title_edit').val()
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#btnEdit').attr('disabled', true);
                                $('#btnEdit').html('<i class="fas fa-spin fa-spinner"></i>');
                            },
                            complete: function() {
                                $('#btnEdit').attr('disabled', false);
                                $('#btnEdit').html('Edit');
                            },
                            success: function(response) {
                                if (response.status == 400) {
                                    alertify
                                        .delay(4000)
                                        .error(response.error.title[0]);
                                } else {
                                    $("#modalEdit").modal('hide');
                                    alertify.delay(5000).log(response.message);

                                    fetchLists();
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });

                    $(document).on('click', '.del_btn', function() {

                        let id = $(this).attr('data-id');

                        $.ajax({
                            type: "DELETE",
                            url: "{{ url('dashboard/todolist') }}/" + id,
                            data: {
                                "id": id
                            },
                            success: function(response) {
                                if (response.status == 200) {
                                    alertify.delay(4000).log(response.message);
                                    fetchLists();
                                } else {
                                    $("#modalDelete").modal('hide');
                                    alertify.delay(4000).error(response.message);
                                }
                            },
                            error: function(xhr, ajaxOptions, thrownError) {
                                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                            }
                        });
                    });

                    // checkbox on click save todo list
                    $(document).on('click', '#checkList', function() {

                        let id = $(this).val();
                        let status = $(this).is(':checked');

                        $.ajax({
                            type: "PUT",
                            url: "{{ url('dashboard/todolist/completed') }}/" + id,
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "status": status
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status == 200) {
                                    fetchLists();
                                    alertify.delay(4000).log(response.message);
                                } else {
                                    alertify.delay(4000).error(response.message);
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

        <div class="col-lg-6">
            {{-- POST TODAY --}}
            @can('manage_posts')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                Postingan hari ini
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-row flex-nowrap overflow-auto">
                    @if ($postToday->count() >= 1)
                        @foreach ($postToday as $post)
                            @if ($post->user_id == Auth::user()->id)
                                <div class="col-10 col-sm-6 col-md-6 col-lg-7">
                                    <div class="card m-b-30">
                                        @if (file_exists('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail))
                                            <img src="{{ asset('vendor/dashboard/image/thumbnail-posts/' . $post->thumbnail) }}"
                                                alt="{{ $post->title }}" class="card-img-top img-fluid">
                                        @else
                                            <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $post->title }}"
                                                class="card-img-top img-fluid">
                                        @endif

                                        <div class="card-body">
                                            <h5 class="card-title font-20 mt-0">{{ $post->title }}</h5>
                                            <p class="card-text">{{ substr($post->description, 0, 150) }}...</p>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center m-b-30" role="alert">
                                Sepertinya kamu belum membuat postingan dihari ini.
                                <a href="{{ route('posts.create') }}#posts">buat postingan?</a>
                            </div>
                        </div>
                    @endif
                </div>
                @if ($postToday->count() >= 1)
                    <div class="row">
                        <div class="col-12 m-b-30">
                            @if ($postToday->hasPages())
                                {{ $postToday->links('vendor.pagination.bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                @endif
            @endcan

            {{-- CATEGORY TODAY --}}
            @can('manage_categories')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                Kategori hari ini
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-row flex-nowrap overflow-auto">
                    @if ($cateToday->count() >= 1)
                        @foreach ($cateToday as $cate)
                            <div class="col-10 col-sm-6 col-md-6 col-lg-7">
                                <div class="card m-b-30">
                                    @if (file_exists('vendor/dashboard/image/thumbnail-categories/' . $cate->thumbnail))
                                        <img src="{{ asset('vendor/dashboard/image/thumbnail-categories/' . $cate->thumbnail) }}"
                                            alt="{{ $cate->title }}" class="card-img-top img-fluid">
                                    @else
                                        <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $cate->title }}"
                                            class="card-img-top img-fluid">
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title font-20 mt-0">{{ $cate->title }}</h5>
                                        <p class="card-text">{{ substr($cate->description, 0, 150) }}...</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center m-b-30" role="alert">
                                Tidak ada kategori yang dibuat hari ini
                            </div>
                        </div>
                    @endif
                </div>
                @if ($cateToday->count() >= 1)
                    <div class="row">
                        <div class="col-12 m-b-30">
                            @if ($cateToday->hasPages())
                                {{ $cateToday->links('vendor.pagination.bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                @endif
            @endcan

            {{-- TAG TODAY --}}
            @can('manage_tags')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                Tag hari ini
                            </div>
                            <div class="card-body">
                                @if ($tagToday->count() >= 1)
                                    @foreach ($tagToday as $tag)
                                        <span class="badge badge-pill badge-primary">{{ $tag->title }}</span>
                                    @endforeach
                                @else
                                    <div class="text-center" role="alert">
                                        Tidak ada tag yang dibuat hari ini
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- CATEGORY TODAY --}}
            @can('manage_categories')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-body">
                                Tutorial hari ini
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row d-flex flex-row flex-nowrap overflow-auto">
                    @if ($tutorToday->count() >= 1)
                        @foreach ($tutorToday as $tutor)
                            <div class="col-10 col-sm-6 col-md-6 col-lg-7">
                                <div class="card m-b-30">
                                    @if (file_exists('vendor/dashboard/image/thumbnail-tutorials/' . $tutor->thumbnail))
                                        <img src="{{ asset('vendor/dashboard/image/thumbnail-tutorials/' . $tutor->thumbnail) }}"
                                            alt="{{ $tutor->title }}" class="card-img-top img-fluid">
                                    @else
                                        <img src="{{ asset('vendor/blog/img/default.png') }}" alt="{{ $tutor->title }}"
                                            class="card-img-top img-fluid">
                                    @endif

                                    <div class="card-body">
                                        <h5 class="card-title font-20 mt-0">{{ $tutor->title }}</h5>
                                        <p class="card-text">{{ substr($tutor->description, 0, 150) }}...</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="text-center m-b-30" role="alert">
                                Tidak ada tutorial yang dibuat hari ini
                            </div>
                        </div>
                    @endif
                </div>
                @if ($tutorToday->count() >= 1)
                    <div class="row">
                        <div class="col-12 m-b-30">
                            @if ($tutorToday->hasPages())
                                {{ $tutorToday->links('vendor.pagination.bootstrap-4') }}
                            @endif
                        </div>
                    </div>
                @endif
            @endcan

            {{-- USER TODAY --}}
            @can('manage_users')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                Pengguna yang mendaftar hari ini
                            </div>
                            <div class="card-body">
                                @if ($userToday->count() >= 1)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php $no = 1; @endphp
                                                @foreach ($userToday as $user)
                                                    <tr class="text-center">
                                                        <td>{{ $no++ }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email ?? '(anonymous)' }}</td>
                                                        <td>{{ $user->roles->first()->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        @if ($userToday->hasPages())
                                            <div class="card-footer">
                                                <div class="page-footer">
                                                    {{ $userToday->links('vendor.pagination.bootstrap-4') }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center">
                                        Belum ada yang mendaftar hari ini
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- ROLE TODAY --}}
            @can('manage_roles')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                Role hari ini
                            </div>
                            <div class="card-body">
                                @if ($roleToday->count() >= 1)
                                    @foreach ($roleToday as $role)
                                        <span class="badge badge-pill badge-primary">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <div class="text-center" role="alert">
                                        Tidak ada role yang dibuat hari ini
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan

            {{-- INBOX CONTACT TODAY --}}
            @can('manage_inbox')
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                Pesan masuk hari ini
                            </div>
                            <div class="card-body">
                                @if ($inboxToday->count() >= 1)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Subject</th>
                                                    <th>Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($inboxToday as $inbox)
                                                    <tr class="text-center">
                                                        <td>{{ $inbox->name }}</td>
                                                        <td>{{ $inbox->email }}</td>
                                                        <td>{{ $inbox->subject }}</td>
                                                        <td>{{ $inbox->message }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center" role="alert">
                                        Belum ada pesan yang masuk hari ini
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card m-b-30">
                            <div class="card-header">
                                Langganan website hari ini
                            </div>
                            <div class="card-body">
                                @if ($newsletterToday->count() >= 1)
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr class="text-center">
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($newsletterToday as $nl)
                                                    <tr class="text-center">
                                                        <td>{{ $nl->email }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="text-center" role="alert">
                                        Belum ada yang berlangganan hari ini
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>

@endsection
