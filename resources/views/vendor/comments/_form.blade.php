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
        <form id="form-comment" method="POST" action="{{ route('comments.store') }}" class="form_comment">
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
                            <input type="text" class="form-control @if ($errors->has('guest_name')) is-invalid @endif" name="guest_name"
                                placeholder="@lang('comments::comments.enter_your_name')" />
                            @error('guest_name')
                                <div class="invalid-feedback">
                                    <b>
                                        {{ $message }}
                                    </b>
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="message">@lang('comments::comments.enter_your_email_here')</label>
                            <input type="email" class="form-control @if ($errors->has('guest_email')) is-invalid @endif" name="guest_email"
                                placeholder="@lang('comments::comments.enter_your_email')" />
                            @error('guest_email')
                                <div class="invalid-feedback">
                                    <b>
                                        {{ $message }}
                                    </b>
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            @endif

            <div class="form-group">
                <label for="message">@lang('comments::comments.enter_your_message_here')</label>
                <textarea class="form-control @if ($errors->has('message')) is-invalid @endif" name="message" rows="3"
                    placeholder="@lang('comments::comments.enter_your_message')"></textarea>
                <div class="invalid-feedback">
                    <b>
                        @lang('comments::comments.your_message_is_required')
                    </b>
                </div>
                {{-- <small class="form-text text-muted">@lang('comments::comments.markdown_cheatsheet', ['url' =>
                    'https://help.github.com/articles/basic-writing-and-formatting-syntax'])</small> --}}
            </div>
            <button id="submit-comment" type="submit" class="">@lang('comments::comments.submit')</button>

        </form>
    </div>
</div>

@push('js-internal')
    <script>
        // $(document).ready(function() {
        //     $('form > .form-control').keyup(function() {

        //         var empty = false;
        //         $('form > .form-control').each(function() {
        //             if ($(this).val().length == 0) {
        //                 empty = true;
        //             }
        //         });

        //         if (empty) {
        //             $('#submit-comment').attr('disabled', 'disabled');
        //         } else {
        //             $('#submit-comment').removeAttr('disabled');
        //         }
        //     });
        // });
    </script>
@endpush
