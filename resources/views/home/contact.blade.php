<section id="contact" class="contact">

    <div class="container">
        <div class="section-title">
            <h2>{{ trans('home.contact.title') }}</h2>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 d-flex infos align-items-stretch">
                <div class="row">

                    <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                        <i class="uil uil-map-marker"></i>
                        <h4>{{ trans('home.contact.infos.info1.title') }}</h4>
                        <p>{{ trans('home.contact.infos.info1.subtitle') }}</p>
                    </div>
                    <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                        <i class="uil uil-envelope"></i>
                        <h4>{{ trans('home.contact.infos.info3.title') }}</h4>
                        <a
                            href="mailto:fahrianggara@protonmail.com">{{ trans('home.contact.infos.info3.subtitle') }}</a>
                    </div>
                    <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                        <i class="uil uil-facebook"></i>
                        <h4>Facebook</h4>
                        <a href="https://web.facebook.com/fahri.anggara.12" target="_blank">
                            @fahrianggara
                        </a>
                    </div>
                    <div class="col-lg-6 info d-flex flex-column align-items-stretch">
                        <i class="uil uil-instagram"></i>
                        <h4>{{ trans('home.contact.infos.info4.title') }}</h4>
                        <a href="https://www.instagram.com/f.anggae/"
                            target="_blank">{{ trans('home.contact.infos.info4.subtitle') }}</a>
                    </div>

                </div>
            </div>

            <div class="col-lg-6 d-flex align-items-stretch contact-form-wrap">

                <form action="{{ route('contact.save') }}" method="POST" id="main_form" class="form_contact">
                    @method('POST')
                    @csrf

                    <div class="form-row">
                        <div class="col-md-6 form-group">
                            <label for="name"
                                class="name">{{ trans('home.contact.form.name.label') }}</label>

                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="{{ trans('home.contact.form.name.placeholder') }}">
                            <span class="text-danger error-text name_error"></span>
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="email"
                                class="email">{{ trans('home.contact.form.email.label') }}</label>
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="{{ trans('home.contact.form.email.placeholder') }}">
                            <span class="text-danger error-text email_error"></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">{{ trans('home.contact.form.subject.label') }}</label>

                        <input type="text" class="form-control fm-error-subject" name="subject" id="subject"
                            placeholder="{{ trans('home.contact.form.subject.placeholder') }}" />
                        <span class="text-danger error-text subject_error"></span>
                    </div>

                    <div class="form-group">
                        <label for="message">{{ trans('home.contact.form.message.label') }}</label>

                        <textarea class="form-control fm-error-message" name="message" id="message" rows="8"
                            placeholder="{{ trans('home.contact.form.message.placeholder') }}"></textarea>
                        <span class="text-danger error-text message_error"></span>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btnsimpan">{{ trans('home.contact.buttonform') }}</button>
                    </div>
                </form>

            </div>

        </div>
    </div>

</section>

@push('js-internal')
    <script>
        $(function() {

            $("#main_form").on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $('.btnsimpan').attr('disable', 'disable');
                        $('.btnsimpan').html('<i class="fa fa-spin fa-spinner"></i>');
                        $(document).find('span.error-text').text('');
                    },
                    complete: function() {
                        $('.btnsimpan').removeAttr('disable');
                        $('.btnsimpan').html("{{ trans('home.contact.buttonform') }}");
                    },
                    success: function(data) {
                        if (data.status == 0) {
                            $.each(data.error, function(prefix, val) {
                                $('#name').addClass('is-invalid');
                                $('#email').addClass('is-invalid');
                                $('#subject').addClass('is-invalid');
                                $('#message').addClass('is-invalid');
                                $('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#main_form')[0].reset();

                            alertify
                                .delay(3500)
                                .log(data.msg);
                        }
                    }
                });
            });
        });
    </script>
@endpush
