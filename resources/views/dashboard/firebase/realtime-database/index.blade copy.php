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
                            '<i class="fas fa-spinner uil uil-refresh"></i> Menghapus...');
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
