@extends('layouts.dashboard')

@section('title')
    Profile kamu
@endsection

@section('breadcrumbs')
    {{ Breadcrumbs::render('dash-profile') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-3 m-b-30">
            <div class="card card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if (file_exists('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image))
                            <img class="profile-user-img userImage img-fluid img-circle"
                                src="{{ asset('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image) }}"
                                alt="{{ Auth::user()->name }}">
                        @else
                            <img class="profile-user-img userImage img-fluid img-circle"
                                src="{{ asset('vendor/dashboard/image/avatar.png') }}" alt="{{ Auth::user()->name }}">
                        @endif
                    </div>
                    <div class="dropdown-divider mt-4 mb-3"></div>
                    <h3 class="profile-username text-center user_name mb-4">{{ Auth::user()->name }}</h3>

                    <input type="file" name="user_image" id="user_image" class="user-update">
                    <a href="javascript:void(0)" class="btn btn-primary btn-block" id="changeImageBtn">
                        <b>Ganti Foto Profile</b>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card m-b-30">
                <div class="card-body">

                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link active" data-toggle="tab" href="#profile-1" role="tab">Profile Info</a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#setting-1" role="tab">Setelan</a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#setting-2" role="tab">Sosial Media</a>
                        </li>
                        <li class="nav-item waves-effect waves-light">
                            <a class="nav-link" data-toggle="tab" href="#setting-3" role="tab">Ganti Password</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane active p-3" id="profile-1" role="tabpanel">
                            {{-- Bio --}}
                            <strong class="font-18">Bio</strong>
                            <p class="font-16 mt-2 text-justify user_bio">
                                {{ Auth::user()->bio }}
                            </p>

                            <div class="dropdown-divider mt-3 mb-3"></div>

                            {{-- Social media --}}
                            <div class="social-links">
                                <a href="{{ Auth::user()->facebook }}">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="{{ Auth::user()->twitter }}">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="{{ Auth::user()->instagram }}">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="{{ Auth::user()->github }}">
                                    <i class="fab fa-github"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Setting Profile --}}
                        <div class="tab-pane p-3" id="setting-1" role="tabpanel">
                            <form class="form-horizontal" method="post" action="{{ route('profile.updateInfo') }}"
                                id="formUpdateProfile" autocomplete="off">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="name" placeholder="Masukkan nama kamu"
                                            value="{{ Auth::user()->name }}" name="name">
                                        <span class="text-danger error-text name_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="slug" class="col-sm-2 col-form-label">Slug</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="slug" placeholder="Slug"
                                            value="{{ Auth::user()->slug }}" name="slug" readonly>
                                        <span class="text-danger error-text slug_error"></span>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" id="inputEmail" placeholder="Email"
                                            value="{{ Auth::user()->email }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="bio" name="bio" placeholder="enter your bio.." onkeyup="countChar(this)" cols="2"
                                            rows="6">{{ Auth::user()->bio }}</textarea>
                                        <span class="float-right" id="charNum"></span>
                                        <span class="mt-5 text-danger error-text bio_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" id="buttonProfile" class="btn btn-primary">Update
                                            Profile</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Sosial media --}}
                        <div class="tab-pane p-3" id="setting-2" role="tabpanel">
                            <form action="{{ route('profile.updateSocial') }}" method="POST" class="form-horizontal"
                                id="formSosmed" autocomplete="off">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control ig" id="instagram" placeholder="Instagram"
                                            value="{{ Auth::user()->instagram }}" name="instagram">
                                        <span class="text-danger error-text instagram_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control tw" id="twitter" placeholder="Twitter"
                                            value="{{ Auth::user()->twitter }}" name="twitter">
                                        <span class="text-danger error-text twitter_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control fb" id="facebook" placeholder="Facebook"
                                            value="{{ Auth::user()->facebook }}" name="facebook">
                                        <span class="text-danger error-text facebook_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="github" class="col-sm-2 col-form-label">Github</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control gh" id="github" placeholder="Github"
                                            value="{{ Auth::user()->github }}" name="github">
                                        <span class="text-danger error-text github_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" id="buttonSosmed" class="btn btn-primary">
                                            Update Sosial Media
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>

                        {{-- Change Password --}}
                        <div class="tab-pane p-3" id="setting-3" role="tabpanel">
                            <form action="{{ route('profile.changePassword') }}" method="POST" class="form-horizontal"
                                id="formPassword" autocomplete="off">
                                @csrf
                                @method('put')

                                <div class="form-group row">
                                    <label for="oldpass" class="col-sm-2 col-form-label">Password Lama</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="oldpass"
                                            placeholder="Masukkan password yang sekarang" name="oldpass">
                                        <span class="text-danger error-text oldpass_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="newpass" class="col-sm-2 col-form-label">Password Baru</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="newpass"
                                            placeholder="Masukkan password yang baru" name="newpass">
                                        <span class="text-danger error-text newpass_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="confirmpass" class="col-sm-2 col-form-label">Konfimasi</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" id="confirmpass"
                                            placeholder="Masukkan password yang dibuat baru tadi" name="confirmpass">
                                        <span class="text-danger error-text confirmpass_error"></span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" id="buttonPassword" class="btn btn-primary">
                                            Update Password
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js-internal')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Count limit character
        function countChar(val) {
            let max = 500
            let limit = val.value.length;
            if (limit >= max) {
                val.value = val.value.substring(0, max);
                $('#charNum').text('Kamu telah mencapai batas');
            } else {
                var char = max - limit;
                $('#charNum').text(char + ' Karakter tersisa');
            };
        }

        $(function() {

            // Update user info
            $('#formUpdateProfile').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $('#buttonProfile').attr('disable', 'disable');
                        $('#buttonProfile').html(
                            '<i class="fa fa-spin uil uil-spinner-alt"></i>');
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                        $(document).find('textarea.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('#buttonProfile').removeAttr('disable');
                        $('#buttonProfile').html('Update Profile');
                    },
                    success: function(response) {
                        if (response.status == 400) {
                            $.each(response.errors, function(key, val) {
                                $("#" + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            // $('#formUpdateProfile')[0].reset();
                            $('.user_name').each(function() {
                                $(this).html($('#formUpdateProfile').find($(
                                    'input[name="name"]')).val());
                            });
                            $('.user_bio').each(function() {
                                $(this).html($('#formUpdateProfile').find($(
                                    'textarea[name="bio"]')).val());
                            });

                            alertify
                                .delay(3500)
                                .log(response.msg);
                        }
                    },
                    error: function(response) {
                        alert(response.status + "\n" + response.errors + "\n" + thrownError);
                    }
                });
            });

            // Change password
            $('#formPassword').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $('#buttonPassword').attr('disable', 'disable');
                        $('#buttonPassword').html(
                            '<i class="fa fa-spin uil uil-spinner-alt"></i>');
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('#buttonPassword').removeAttr('disable');
                        $('#buttonPassword').html('Update Password');
                    },
                    success: function(data) {
                        if (data.status == 400) {
                            $.each(data.errors, function(key, val) {
                                $("#" + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            $('#formPassword')[0].reset();

                            alertify
                                .delay(3500)
                                .log(data.msg);
                        }
                    },
                    error: function(response) {
                        alert(response.status + "\n" + response.errors + "\n" + thrownError);
                    }
                });
            })

            $('#formSosmed').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: new FormData(this),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $('#buttonSosmed').attr('disable', 'disable');
                        $('#buttonSosmed').html(
                            '<i class="fa fa-spin uil uil-spinner-alt"></i>');
                        $(document).find('span.error-text').text('');
                        $(document).find('input.form-control').removeClass(
                            'is-invalid');
                    },
                    complete: function() {
                        $('#buttonSosmed').removeAttr('disable');
                        $('#buttonSosmed').html('Update Sosial Media');
                    },
                    success: function(data) {
                        if (data.status == 400) {
                            $.each(data.errors, function(key, val) {
                                $("#" + key).addClass('is-invalid');
                                $('span.' + key + '_error').text(val[0]);
                            });
                        } else {
                            $('.ig').each(function() {
                                $(this).html($('#formSosmed').find($(
                                    'input[name="instagram"]')).val());
                            });
                            $('.fb').each(function() {
                                $(this).html($('#formSosmed').find($(
                                    'input[name="facebook"]')).val());
                            });
                            $('.tw').each(function() {
                                $(this).html($('#formSosmed').find($(
                                    'input[name="twitter"]')).val());
                            });
                            $('.gh').each(function() {
                                $(this).html($('#formSosmed').find($(
                                    'input[name="github"]')).val());
                            });

                            alertify
                                .delay(3500)
                                .log(data.msg);
                        }
                    },
                    error: function(response) {
                        alert(response.status + "\n" + response.errors + "\n" + thrownError);
                    }
                });
            })


            $(document).on('click', '#changeImageBtn', function() {
                $('#user_image').click();
            });


            $('#user_image').ijaboCropTool({
                preview: '.userImage',
                setRatio: 1,
                allowedExtensions: ['jpg', 'jpeg', 'png'],
                buttonsText: ['CROP & UPLOAD', 'CANCEL'],
                buttonsColor: ['#30bf7d', '#ee5155', -15],
                processUrl: '{{ route('profile.updateImage') }}',
                // withCSRF:['_token','{{ csrf_token() }}'],
                onSuccess: function(message, element, status) {
                    alertify.okBtn("OK").alert(message);
                },
                onError: function(message, element, status) {
                    alertify.okBtn("OK").alert(message);
                }
            });

            const generateSlug = (value) => {
                return value.trim()
                    .toLowerCase()
                    .replace(/[^a-z\d-]/gi, '-')
                    .replace(/-+/g, '-').replace(/^-|-$/g, "")
            }

            $('#name').change(function(e) {
                e.preventDefault();

                let title = $(this).val();
                $('#slug').val(generateSlug(title));
            });
        });
    </script>
@endpush
