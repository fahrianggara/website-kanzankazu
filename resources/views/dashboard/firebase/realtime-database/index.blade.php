@extends('layouts.dashboard')

@section('title')
    Firebase: Realtime Database
@endsection

@section('breadcrumbs')
    {{-- {{ Breadcrumbs::render('databaseRealtime') }} --}}
@endsection

@section('content')
    <div class="row">

        <div class="col-lg-12 m-b-20">
            <div class="row flex-row-reverse">
                <div class="col-xl-9 col-lg-9 col-md-7">
                    <div class="card">
                        <div class="card-body">

                            <div class="col-12">
                                <div class="input-group mx-1">
                                    <input autocomplete="off" id="keyword" type="search" class="form-control cariData"
                                        placeholder="Cari user yang ingin kamu cari..">

                                    <div class="input-group-append">
                                        <button class="btn btn-primary">
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

        <div class="col-lg-12">
            <div class="card m-b-30">
                <div id="tableUsers" class="card-body table-responsive shadow-sm table-wrapper">

                </div>
            </div>
        </div>

    </div>

    <a href="javascript:void(0)" class="to-the-top" data-toggle="modal" data-target="#modalCreate">
        <i class="uil uil-plus"></i>
    </a>

    <div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateUser"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalCreateUser">Buat user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                @php
                    $uid = \Str::random(20);
                @endphp

                <div class="modal-body">
                    <div class="form-group">
                        <label for="uid">uid</label>
                        <input type="text" class="form-control" id="add_uid" name="uid" value="{{ $uid }}"
                            readonly>
                        <span class="invalid-feedback d-block error-text uid_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="add_name" name="name"
                            placeholder="Masukkan nama user" autofocus required autocomplete="off">
                        <span class="invalid-feedback d-block error-text nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="add_email" name="email"
                            placeholder="Masukkan email user" required autocomplete="off">
                        <span class="invalid-feedback d-block error-text email_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="add_user_image">Avatar</label>
                        <input type="text" name="user_image"
                            value="https://www.gravatar.com/avatar/{{ md5($uid) }}?d=wavatar&f=y.jpg"
                            class="form-control" id="add_user_image" readonly>
                        <span class="invalid-feedback d-block error-text user_image_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="add_provider">Provider</label>
                        <select class="form-control" id="add_provider" name="provider">
                            <option value="google">Google</option>
                            <option value="github">Github</option>
                            <option value="anonymous">Anonymous</option>
                            <option value="kanzankazu">Kanzankazu</option>
                        </select>
                        <span class="invalid-feedback d-block error-text provider_error"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="submitAdd btn btn-primary">
                        Tambah <i class="uil uil-plus"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditUser" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUser">Edit user</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <input type="hidden" id="edit_key">
                    <input type="hidden" id="email_edit">
                    <input type="hidden" id="name_edit">

                    <div class="form-group">
                        <label for="uid">uid</label>
                        <input type="text" class="form-control" id="edit_uid" name="uid" value=""
                            readonly>
                        <span class="invalid-feedback d-block error-text uid_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="edit_name" name="name"
                            placeholder="Masukkan nama user" autofocus required autocomplete="off">
                        <span class="invalid-feedback d-block error-text nama_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email"
                            placeholder="Masukkan email user" required autocomplete="off" readonly>
                        <span class="invalid-feedback d-block error-text email_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="user_image">Avatar</label>
                        <input type="text" name="user_image" class="form-control" id="edit_userimage" readonly>
                        <span class="invalid-feedback d-block error-text user_image_error"></span>
                    </div>
                    <div class="form-group">
                        <label for="edit_provider">Provider</label>
                        <select class="form-control" id="edit_provider" name="provider">
                            <option value="google">Google</option>
                            <option value="github">Github</option>
                            <option value="anonymous">Anonymous</option>
                            <option value="kanzankazu">Kanzankazu</option>
                        </select>
                        <span class="invalid-feedback d-block error-text provider_error"></span>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="submitEdit btn btn-warning">
                        Edit <i class="uil uil-pen"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="deleteTitle"
        aria-hidden="true">
        <div class="modal-dialog " role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <input id="del_id" type="hidden">
                    <input id="nameUser" type="hidden">
                    <p id="text_del"></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger btnDelete">
                        Hapus <i class="uil uil-trash"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    @push('js-internal')
        <script type="module">
            import { initializeApp } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-app.js";
            import { getDatabase, ref, set, child, update, remove, push, get, onValue } from "https://www.gstatic.com/firebasejs/9.9.1/firebase-database.js";

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
            const db = getDatabase(app);

            const showTable = document.getElementById('tableUsers');

            function fetchItemToTable() {
                const dbRef = ref(db, "users");

                onValue(dbRef, (snapshot) => {
                    let html = '';
                    html += `
                    <table id="dataUsers" class="table table-hover align-items-center overflow-hidden">
                        <thead>
                            <tr>
                                <th>UID</th>
                                <th>User Data</th>
                                <th>Provider</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                    `;
                    snapshot.forEach(function(childSnapshot) {
                        let user = childSnapshot.val();
                        let key = childSnapshot.key;

                        html += `
                            <tr>
                                <td>${user.uid}</td>
                                <td>
                                    <a href="javascript:void(0)" class="d-flex align-items-center" style="cursor: default">
                                        <img src="${user.user_image}" width="40" class="avatar rounded-circle me-3">
                                        <div class="d-block ml-3">
                                            <span id="namaUser" class="fw-bold name-user">${user.name}</span>
                                            <div id="emailUser" class="small text-secondary">${user.email}</div>
                                        </div>
                                    </a>
                                </td>
                                <td>${user.provider}</td>
                                <td>
                                    <div class="btn-group dropleft">
                                        <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="uil uil-ellipsis-v"></i>
                                        </button>
                                        <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-1" style="margin-bottom: 80px">
                                            <button id="editUser" value="${key}" data-uid="${user.uid}" data-name="${user.name}" data-email="${user.email}" data-provider="${user.provider}" data-userimage="${user.user_image}" class="edit_btn dropdown-item d-flex align-items-center">
                                                <i class="uil uil-pen text-warning"></i>
                                                <span class="ml-2">Edit User</span>
                                            </button>
                                            <button id="hapusUser" value="${key}" data-name="${user.name}"
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

                    html += `
                        </tbody>
                    </table>
                    `;

                    showTable.innerHTML = html;

                    let tableUser = $('#dataUsers').dataTable({
                        "order": [
                            [0, "asc"]
                        ],
                        "columnDefs": [{
                            "targets": [0],
                            "visible": true,
                            "searchable": true,
                        }],
                        "bInfo": false,
                        "pageLength": 10,
                        "language": {
                            "emptyTable": "Tidak ada data yang tersedia",
                        }
                    });

                    $('#keyword').on('keyup', function() {
                        tableUser.fnFilter(this.value);
                    });
                    $('#selectData').on('change', function() {
                        tableUser.page.len(this.value);
                    });
                    $('.dataTables_wrapper').find('.col-sm-12.col-md-5').remove();
                });
            }

            window.addEventListener('load', function() {
                fetchItemToTable();
            });

            function reloadInputCreate() {
                $('#add_name').val('');
                $('#add_email').val('');
                $('#add_provider').val('google');
                $('#add_user_image').val('https://www.gravatar.com/avatar/{{ md5('+math.random()+') }}?d=wavatar&f=y.jpg');
                $('#add_uid').val('{{ Str::random(20) }}');
            }
            function insert() {
                push(ref(db, 'users'), {
                    name: $('#add_name').val(),
                    email: $('#add_email').val(),
                    provider: $('#add_provider').val(),
                    user_image: $('#add_user_image').val(),
                    uid: $('#add_uid').val(),
                }).then(() => {
                    alertify.delay(4500).log('Data user berhasil ditambahkan');
                    $('#modalCreate').modal('hide');
                    reloadInputCreate();
                }).catch(error => {
                    alertify.okBtn("OK").alert(error);
                });
            }
            $('.submitAdd').click(function() {
                var email = $('#add_email').val();
                var patternValidEmail = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

                if ($('#add_name').val() == '' || $('#add_email').val() == '') {
                    if ($('#add_name').val() != '') {
                        alertify.delay(4000).error('Email tidak boleh kosong');
                    } else if (email != '') {
                        alertify.delay(4000).error('Nama tidak boleh kosong');
                    } else {
                        alertify.delay(4000).error("Nama dan Email tidak boleh kosong");
                    }
                } else if (!patternValidEmail.test(email)) {
                    alertify.delay(4000).error('Alamat email tidak valid');
                } else {
                    insert();
                }
            });

            function edit() {
                update(ref(db, 'users/' + $('#edit_key').val()), {
                    name: $('#edit_name').val(),
                    email: $('#edit_email').val(),
                    provider: $('#edit_provider').val(),
                }).then(() => {
                    alertify.delay(4500).log('Data user berhasil diubah');
                    $('#modalEdit').modal('hide');
                    reloadInputCreate();
                }).catch(error => {
                    alertify.okBtn("OK").alert(error);
                });
            }
            $(document).on('click', '#editUser', function (e) {
                e.preventDefault();
                $('#modalEdit').modal('show');

                $('#edit_key').val($(this).val());
                $('#edit_name').val($(this).data('name'));
                $('#edit_email').val($(this).data('email'));
                $('#edit_provider').val($(this).data('provider'));
                $('#edit_userimage').val($(this).data('userimage'));
                $('#edit_uid').val($(this).data('uid'));

                $('#email_edit').val($(this).data('email'));
                $('#name_edit').val($(this).data('name'));
                $('h5#modalEditUser').text('Edit Pengguna: ' + $(this).data('name'));
            });
            $('.submitEdit').click(function() {
                var email = $('#edit_email').val();
                var patternValidEmail = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;

                if ($('#edit_name').val() == '' || $('#edit_email').val() == '') {
                    if ($('#edit_name').val() != '') {
                        alertify.delay(4000).error('Email tidak boleh kosong');
                    } else if (email != '') {
                        alertify.delay(4000).error('Nama tidak boleh kosong');
                    } else {
                        alertify.delay(4000).error("Nama dan Email tidak boleh kosong");
                    }
                } else if (!patternValidEmail.test(email)) {
                    alertify.delay(4000).error('Alamat email tidak valid');
                } else {
                    edit();
                }
            });

            $(document).on('click', '.del_btn', function (e) {
                e.preventDefault();
                $('#modalDelete').modal('show');

                let key = $(this).val();
                $('#del_id').val(key);

                let  name = $(this).data('name');
                $('#nameUser').val(name);
                $('#text_del').text('Apakah anda yakin ingin menghapus user ' + name + '?');
            });

            $('.btnDelete').click(function() {
                let key = $('#del_id').val();
                let name = $('#nameUser').val();
                remove(ref(db, 'users/' + key)).then(() => {
                    alertify.delay(4500).log(`User dengan nama ${name} berhasil dihapus`);
                    $('#modalDelete').modal('hide');
                }).catch(error => {
                    alertify.okBtn("OK").alert(error);
                });
            });
        </script>
    @endpush
@endsection
