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
            <div class="card m-b-30">

                @if (count($contacts) >= 1)
                    <div class="table-responsive">

                        <table class="table">
                            <thead>
                                <tr class="text-center">
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Subjek</th>
                                    <th>Pesan</th>
                                    @can('inbox_delete')
                                        <th>Opsi</th>
                                    @endcan
                                </tr>

                            </thead>
                            <tbody>
                                @foreach ($contacts as $c)
                                    <tr class="text-center">
                                        <th>{{ $c->name }}</th>
                                        <th>{{ $c->email }}</th>
                                        <th>{{ $c->subject }}</th>
                                        <th>{{ $c->message }}</th>
                                        {{-- <th>{{ $c->created_at->format('d-m-Y / H:i:s a') }}</th> --}}

                                        @can('inbox_delete')
                                            <th>
                                                @if ($c->status == 'answered')
                                                    <a href="#" id="infoContact" class="info_btn btn btn-sm btn-info"
                                                        data-id="{{ $c->id }}" data-toggle="tooltip"
                                                        data-placement="bottom" title="info Pesan si pembalas">
                                                        <i class="uil uil-envelope-open"></i>
                                                    </a>
                                                @endif

                                                @if ($c->status == 'unanswered')
                                                    <a href="#" id="replayContact"
                                                        class="replay_btn btn btn-sm btn-primary" data-id="{{ $c->id }}"
                                                        data-toggle="tooltip" data-placement="bottom" title="Balas Pesan">
                                                        <i class="uil uil-envelope-upload"></i>
                                                    </a>
                                                @endif

                                                @if ($c->status == 'answered')
                                                    <form action="{{ route('contact.destroy', ['contact' => $c]) }}"
                                                        method="POST" role="alert"
                                                        alert-text="Apakah kamu yakin? inbox dengan subjek ({{ $c->subject }}) akan dihapus permanen.">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" data-toggle="tooltip" data-placement="bottom"
                                                            title="Hapus Pesan" class="btn btn-sm btn-danger mt-1">
                                                            <i class="uil uil-envelope-times"></i>
                                                        </button>
                                                    </form>
                                                @endif

                                            </th>
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
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
