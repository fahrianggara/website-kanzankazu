<div class="form-card">
    <div class="">
        @if ($errors->has('commentable_type'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_type') }}
            </div>
        @endif
        @if ($errors->has('commentable_id'))
            <div class="alert alert-danger" role="alert">
                {{ $errors->first('commentable_id') }}
            </div>
        @endif
        <form id="form-comment" method="POST" action="{{ route('comments.store') }}" class="form_comment"
            autocomplete="off">
            @csrf
            @honeypot
            <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
            <input type="hidden" name="commentable_id" value="{{ $model->getKey() }}" />

            {{-- Guest commenting --}}
            @if (isset($guest_commenting) and $guest_commenting == true)
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group ">
                            <label for="message">@lang('comments::comments.enter_your_name_here')</label>
                            <input id="guest_name" type="text"
                                class="form-control @if ($errors->has('guest_name')) is-invalid @endif"
                                name="guest_name" placeholder="@lang('comments::comments.enter_your_name')" />
                            <span class="invalid-feedback d-block error-text guest_name_error"></span>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="message">@lang('comments::comments.enter_your_email_here')</label>
                            <input id="guest_email" type="email"
                                class="form-control @if ($errors->has('guest_email')) is-invalid @endif"
                                name="guest_email" placeholder="@lang('comments::comments.enter_your_email')" />
                            <span class="invalid-feedback d-block error-text guest_email_error"></span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="message">@lang('comments::comments.enter_your_message_here')</label>
                <textarea id="message" class="form-control @if ($errors->has('comment')) is-invalid @endif" name="message" rows="3"
                    placeholder="@lang('comments::comments.enter_your_message')"></textarea>
                <span class="invalid-feedback d-block error-text message_error"></span>

                {{-- <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' =>
                    'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small> --}}
            </div>
            <button id="submit-comment" type="submit" class="">@lang('comments::comments.submit')</button>

        </form>
    </div>
</div>

@push('css-external')
    <link rel="stylesheet" href="{{ asset('vendor/dashboard/plugins/alertify/css/alert.css') }}">
@endpush

@push('js-external')
    <script src="{{ asset('vendor/dashboard/plugins/alertify/js/alert.js') }}"></script>
@endpush

@push('js-internal')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {
            $("#form-comment").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    type: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: new FormData(this),
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#submit-comment').attr('disable', 'disable')
                        $('#submit-comment').html('<i class="fa fa-spinner fa-spin"></i>');
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('#submit-comment').removeAttr('disable');
                        $('#submit-comment').html('@lang('comments::comments.submit')');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $("#" + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            $('#form-comment')[0].reset();

                            alertify
                                .delay(3500)
                                .log(response.msg);

                            setTimeout((function() {
                                window.location.reload();
                            }), 950);

                        }
                    },
                    error: function(response) {
                        alert(response.status + "\n" + response.errors + "\n" + thrownError);
                    }
                })
            });

        });
    </script>
@endpush
