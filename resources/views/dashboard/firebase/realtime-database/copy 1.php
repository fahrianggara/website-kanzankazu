@extends('layouts.dashboard')

@section('title')
    Firebase: Realtime Database
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('databaseRealtime') }}
@endsection

@section('content')
    <div class="row">

        @include('dashboard.menu-search.menu')

        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body table-responsive shadow-sm table-wrapper">

                    <table id="dataUsers" class="table table-hover align-items-center overflow-hidden">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Provider</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                                            <img src="{{ asset('vendor/dashboard/image/avatar.png') }}" width="40"
                                                class="avatar rounded-circle me-3">
                                            <div class="d-block ml-3">
                                                <span class="fw-bold name-user">{{ $user['name'] }}</span>
                                                <div class="small text-secondary">{{ $user['email'] ?? '(anonymous)' }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td>{{ $user['provider'] }}</td>
                                    <td>
                                        <div class="btn-group dropleft">
                                            <button
                                                class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="uil uil-ellipsis-v"></i>
                                            </button>
                                            <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">
                                                <button value="{{ $key }}"
                                                    class="edit_btn dropdown-item d-flex align-items-center">
                                                    <i class="uil uil-pen text-warning"></i>
                                                    <span class="ml-2">Edit User</span>
                                                </button>
                                                <button value="{{ $key }}" data-name="{{ $user['name'] }}"
                                                    class="del_btn dropdown-item d-flex align-items-center">
                                                    <i class="uil uil-trash text-danger"></i>
                                                    <span class="ml-2">Hapus User</span>
                                                </button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>

    {{-- Modal delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteTitle" aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <form action="" method="DELETE" id="formDeleteUser">
                    @csrf
                    @method('DELETE')

                    <div class="modal-body">
                        <input id="del_id" type="hidden" name="id">
                        <p id="text_del"></p>
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
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {
            // csrf token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let dataTable = $('#dataUsers').DataTable({
                "pageLength": 10,
                "bInfo": false
            });

            $('input[type="search"]').on('keyup', function() {
                dataTable.search(this.value).draw();
            });

            $('#selectData').on('change', function() {
                dataTable.page.len(this.value).draw();
            });

            // delete user
            $('#dataUsers tbody').on('click', ".del_btn", function() {
                $('#del_id').val($(this).val());
                $('#text_del').text('Apakah kamu yakin ingin menghapus user ' + $(this).data(
                    'name') + '?');
                $('#modalDelete').modal('show');
            });

            $('#formDeleteUser').on('submit', function(e) {
                e.preventDefault();

                let id = $('#del_id').val();

                $.ajax({
                    url: "{{ url('dashboard/firebase/destroy') }}/" + id,
                    type: "DELETE",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        $('.btnDelete').prop('disabled', true);
                        $('.btnDelete').html(
                            '<i class="fas fa-spin fa-spinner"></i> Menghapus...');
                    },
                    complete: function() {
                        $('.btnDelete').prop('disabled', false);
                        $('.btnDelete').html(
                            'Hapus <i class="uil uil-trash"></i>');
                    },
                    success: function(response) {
                        if (response.status == 200) {
                            $('#modalDelete').modal('hide');

                            alertify
                                .delay(3500)
                                .log(response.msg);
                        } else {
                            $('#modalDelete').modal('hide');
                            alertify
                                .delay(3500)
                                .log(response.msg);
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

@push('js-internal')
        <script type="module">
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-app.js";
            import {  getDatabase, ref, get, child, remove, update, set, push } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-database.js";

            const firebaseConfig = {
                apiKey: "AIzaSyBjRiwImCUf2YfiylqIF04m08P7_Y5s7lg",
                authDomain: "kanzankazu-d3594.firebaseapp.com",
                databaseURL: "https://kanzankazu-d3594-default-rtdb.firebaseio.com",
                projectId: "kanzankazu-d3594",
                storageBucket: "kanzankazu-d3594.appspot.com",
                messagingSenderId: "74823808367",
                appId: "1:74823808367:web:75e4de27a5e1495f3de49a",
                measurementId: "G-R9TN0JZ4MH"
            };

            const app = initializeApp(firebaseConfig);

            let db = getDatabase();

            getAllData()

            function getAllData() {
                let dbRef = ref(db);

                get(child(dbRef, 'users'))
                .then((snapshot) => {
                    let users = [];

                    snapshot.forEach((childSnapshot) => {
                        users.push(childSnapshot.val());
                    });

                    // value of users datatable
                    let no = 1;
                    let html = '';

                    html += `
                        <table id="dataUsers" class="table table-hover align-items-center overflow-hidden">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Provider</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                        `;
                    users.forEach((user) => {

                        let defaultImage = '{{ asset("vendor/dashboard/image/avatar.png") }}';

                        const imageUser = user.user_image ? user.user_image : defaultImage;
                        const emailUser = user.email ?? 'Anonymous';

                        html += `
                            <tr>
                                <td>${no++}</td>
                                <td>
                                    <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                                        <img src="${imageUser}" width="40"
                                            class="avatar rounded-circle me-3">
                                        <div class="d-block ml-3">
                                            <span class="fw-bold name-user">${user.name}</span>
                                            <div class="small text-secondary">${emailUser}</div>
                                        </div>
                                    </a>
                                </td>
                                <td>${user.provider}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <button
                                            class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1" style="margin-bottom: 80px">
                                            <button id="editUser" value="${user.uid}"
                                                class="edit_btn dropdown-item d-flex align-items-center">
                                                <i class="uil uil-pen text-warning"></i>
                                                <span class="ml-2">Edit User</span>
                                            </button>
                                            <button id="hapusUser" value="${user.uid}" data-name="${user.name}"
                                                class="del_btn dropdown-item d-flex align-items-center">
                                                <i class="uil uil-trash text-danger"></i>
                                                <span class="ml-2">Hapus User</span>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });

                    html += `</tbody></table>`;

                    $('#show_users').html(html);

                    let dataTable = $('#dataUsers').DataTable({
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
                });

                setTimeout(getAllData(), 100);
            }

            // setInterval(() => {
            //     getAllData()
            // }, 200);

            function insertData() {
                let name = $('#add_name').val();
                let email = $('#add_email').val();
                let provider = $('#add_provider').val();
                let user_image = $('#add_user_image').val();
                let uid = $('#add_uid').val();

                let data = {
                    uid: uid,
                    name: name,
                    email: email,
                    user_image: user_image,
                    provider: provider,
                };

                set(ref(db, 'users/' + uid), data).then( () => {
                    if (name == null && email == null) {
                        alertify.delay(4500).log('Data tidak boleh kosong');
                    } else {
                        alertify.delay(4500).log('Data user berhasil ditambahkan');
                    }
                }).catch((error) => {
                    alertify.okBtn("OK").alert(error);
                });
            }
            $('.submitAdd').on('click', function() {

                insertData();
                getAllData();

                $('#modalCreate').modal('hide');
            });

            $(document).on('click', '.del_btn', function(e) {
                e.preventDefault();

                let id = $(this).val();
                let name = $(this).data('name');

                $('#modalDelete').modal('show');
                $('#del_id').val(id);
                $('#nameUser').val(name);
                $('#text_del').text('Apakah kamu yakin? ingin menghapus tag ' + name + '?');

            });

            $(document).on('click', '.btnDelete', function(e) {
                e.preventDefault();

                let id = $('#del_id').val();
                let name = $('#nameUser').val();
                let dbRef = ref(db);

                remove(child(dbRef, 'users/' + id)).then(() => {
                    $('#modalDelete').modal('hide');

                    alertify
                        .delay(3500)
                        .log("User dengan nama " + name + " berhasil dihapus");

                }).catch((error) => {
                    $('#modalDelete').modal('hide');
                    alertify.okBtn("OK").alert("Gagal menghapus user: " + error);
                });
            });
        </script>
    @endpush
