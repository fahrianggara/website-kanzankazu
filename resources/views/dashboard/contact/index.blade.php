@extends('layouts.dashboard')

@section('title')
    Kontak Inbox
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('list-contact') }}
@endsection

@section('content')
    <div class="row">

        <div class="col-12">
            <form action="#contact" method="GET" class="">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card m-b-10">
                            <div class="card-header">

                                <div class="col">
                                    <div class="input-group mx-1">
                                        <select id="statusInbox" name="status" class="custom-select"
                                            style="border-radius: 4px" data-toggle="tooltip" data-placement="bottom"
                                            title="Status">
                                            <option value="unanswered"
                                                {{ $statusSelected == 'unanswered' ? 'selected' : null }}>
                                                Belum dijawab ({{ $unansweredCount }})
                                            </option>
                                            <option value="answered"
                                                {{ $statusSelected == 'answered' ? 'selected' : null }}>
                                                Sudah dijawab ({{ $answeredCount }})
                                            </option>
                                        </select>

                                        <button id="submitStatus" class="btn btn-primary d-none" type="submit">Apply
                                        </button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 mb-3">
                        <div class="card">
                            <div class="card-header">

                                <div class="col-12">
                                    <div class="input-group mx-1">
                                        <input autocomplete="off" name="keyword" type="search"
                                            value="{{ request()->get('keyword') }}" class="form-control"
                                            placeholder="Cari pesan..">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit" data-toggle="tooltip"
                                                data-placement="bottom" title="Telusuri">
                                                <i class="uil uil-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12">
            <div class="card card-body m-b-30 table-responsive shadow-sm table-wrapper">
                @if (count($contacts) >= 1)
                    <table class="table table-hover align-items-center overflow-hidden">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Subjek Pesan</th>
                                <th>Isi Pesan</th>
                                @if (request()->get('status') == 'answered')
                                    <th>Waktu Mengirim</th>
                                @else
                                    <th>Waktu Terkirim</th>
                                @endif

                                @can('inbox_delete')
                                    <th></th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($contacts as $c)
                                <tr>
                                    <td>
                                        <a href="javascript:void(0)" class="d-flex align-items-center"
                                            style="cursor: default">
                                            <div class="d-block">
                                                <span class="fw-bold name-user">{{ $c->name }}</span>
                                                <div class="small text-secondary">
                                                    {{ $c->email }}
                                                </div>
                                            </div>
                                        </a>
                                    </td>
                                    <td class="name-user">{{ $c->subject }}</td>
                                    <td class="name-user">{{ $c->message }}</td>
                                    @if ($c->status == 'answered')
                                        <td class="name-user">{{ $c->updated_at->format('d M, Y - H:i T') }}</td>
                                    @else
                                        <td class="name-user">{{ $c->created_at->format('d M, Y - H:i T') }}</td>
                                    @endif

                                    @can('inbox_delete')
                                        <td>
                                            <div class="btn-group dropleft">
                                                <button
                                                    class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-0"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="uil uil-ellipsis-v"></i>
                                                </button>
                                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mb-4 py-1">
                                                    @if ($c->status == 'answered')
                                                        <a id="infoContact" href="javascript:void(0)"
                                                            data-id="{{ $c->id }}"
                                                            class="info_btn dropdown-item d-flex align-items-center ">
                                                            <i class="uil uil-envelope-open text-primary"></i>
                                                            <span class="ml-2">Info pesan si pembalas</span>
                                                        </a>

                                                        <form action="{{ route('contact.destroy', ['contact' => $c]) }}"
                                                            method="POST" role="alert"
                                                            alert-text="Apakah kamu yakin? inbox dengan subjek ({{ $c->subject }}) akan dihapus permanen.">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="dropdown-item d-flex align-items-center">
                                                                <i class="uil uil-envelope-times text-danger"></i>
                                                                <span class="ml-2">Hapus pesan</span>
                                                            </button>
                                                        </form>
                                                    @endif

                                                    @if ($c->status == 'unanswered')
                                                        <a id="replayContact" href="javascript:void(0)"
                                                            data-id="{{ $c->id }}"
                                                            class="replay_btn dropdown-item d-flex align-items-center">
                                                            <i class="uil uil-envelope-upload text-primary"></i>
                                                            <span class="ml-2">Balas pesan</span>
                                                        </a>
                                                    @endif


                                                </div>
                                            </div>

                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="card-body">
                        <div class="text-center">
                            <p class="card-text">
                                @if (request()->get('keyword'))
                                    Oops.. sepertinya inbox dengan subjek "{{ request()->get('keyword') }}" tidak
                                    ditemukan.
                                @elseif (request()->get('status') == 'answered')
                                    Oops.. sepertinya belum ada pesan yang dijawab.
                                @elseif (request()->get('status') == 'unanswered')
                                    Oops.. sepertinya belum ada inbox yang masuk.
                                @else
                                    Oops.. sepertinya inbox masih kosong.
                                @endif
                            </p>
                        </div>
                    </div>
                @endif

                @if ($contacts->hasPages())
                    <div class="card-footer">
                        <div class="page-footer">
                            {{ $contacts->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal info --}}
    <div class="modal fade" id="infoInboxModal" tabindex="-1" role="dialog" aria-labelledby="infoTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoTitle">Info pembalas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formInfoContacts">
                    <div class="modal-body">
                        <input type="hidden" id="inbox_id" name="id" value="">

                        <div class="form-group mb-3">
                            <label for="email">Dibalas oleh</label>
                            <input type="text" name="email" id="answerer" class="form-control"
                                placeholder="email" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject">Replay pesan</label>
                            <input type="text" name="subject" id="replay_subject" class="form-control" readonly>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message">Replay message</label>
                            <textarea name="message" class="form-control" id="replay_message" cols="2" rows="5" readonly></textarea>
                        </div>

                        <br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal replay --}}
    <div class="modal fade" id="replayInboxModal" tabindex="-1" role="dialog" aria-labelledby="replayTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-centered">
                <div class="modal-header">
                    <h5 class="modal-title" id="replayTitle">Balas inbox</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formReplayComments" action="#" autocomplete="off" method="GET">
                    <div class="modal-body">
                        @csrf
                        @method('GET')
                        <input type="hidden" id="inbox_id" name="id" value="">

                        <div class="form-group mb-3">
                            <label for="email">Kirim ke</label>
                            <input type="text" name="email" id="email" value="" class="form-control"
                                placeholder="email" readonly>
                            <span class="invalid-feedback d-block error-text email_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="message">Pesan</label>
                            <textarea name="message" class="form-control" id="message" cols="2" rows="2"
                                placeholder="Balas pesan" readonly></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="judul">Judul Pesan</label>
                            <input type="text" name="judul" id="judul" value="" class="form-control"
                                placeholder="Masukkan judul pesan">
                            <span class="invalid-feedback d-block error-text judul_error"></span>
                        </div>
                        <div class="form-group mb-3">
                            <label for="replay">Balas Pesan</label>
                            <textarea name="replay" class="form-control" id="replay" cols="2" rows="6"
                                placeholder="Balas pesan"></textarea>

                            <span class="invalid-feedback d-block error-text replay_error"></span>
                            <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' => 'https://www.markdownguide.org/cheat-sheet/'])</small>
                        </div>

                        <br>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="submitReply btn btn-primary">
                                <i class="uil uil-message"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $(document).ready(function() {

            $('#statusInbox').on('change', function() {
                $('#submitStatus').click();
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('[data-dismiss="modal"]').on('click', function() {
                $(document).find('span.error-text').text('');
                $(document).find('input.form-control').removeClass(
                    'is-invalid');
                $(document).find('textarea.form-control').removeClass(
                    'is-invalid');
                $('#formReplayComments')[0].reset();
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

            $(document).on('click', '#infoContact', function(e) {
                e.preventDefault();

                let inbox_id = $(this).data('id');
                $('#infoInboxModal').modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/show-replay') }}/" + inbox_id,
                    success: function(response) {
                        if (response.status == 400) {
                            alertify
                                .delay(4500)
                                .log(response.msg);
                        } else {
                            $('#answerer').val(response.dataInbox.answerer);
                            $("#replay_subject").val(response.dataInbox.replay_subject);
                            $("#replay_message").val(response.dataInbox.replay_message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $(document).on('click', '#replayContact', function(e) {
                e.preventDefault();

                let inbox_id = $(this).data('id');
                $("#replayInboxModal").modal('show');

                $.ajax({
                    type: "GET",
                    url: "{{ url('dashboard/show-replay') }}/" + inbox_id,
                    success: function(response) {
                        if (response.status == 400) {
                            alertify
                                .delay(4500)
                                .log(response.msg);
                        } else {
                            $("#inbox_id").val(inbox_id);
                            $("#email").val(response.dataInbox.email);
                            $("#message").val(response.dataInbox.message);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            });

            $('#formReplayComments').on('submit', function(e) {
                e.preventDefault();

                let id = $('#inbox_id').val();
                console.log(id);

                $.ajax({
                    method: "GET",
                    url: "{{ url('dashboard/replay') }}/" + id,
                    data: {
                        'replay': $('#replay').val(),
                        'judul': $('#judul').val(),
                    },
                    dataType: 'JSON',
                    beforeSend: function() {
                        $('.submitReply').attr('disable', 'disable');
                        $('.submitReply').html('<i class="fas fa-spin fa-spinner"></i>');
                        // Ketika benar sudah melewati validasi maka hilangkan error validasinya
                        $(document).find('span.error-text').text('');
                    },
                    complete: function() {
                        $('.submitReply').removeAttr('disable');
                        $('.submitReply').html('<i class="uil uil-message"></i>');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            alertify
                                .delay(4500)
                                .log(response.msg);

                            $("#replayInboxModal").modal('hide');
                            $('#formReplayComments')[0].reset();
                            $(document).find('span.error-text').text('');

                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('contact.index') }}#contact';
                            }, 1500);
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
