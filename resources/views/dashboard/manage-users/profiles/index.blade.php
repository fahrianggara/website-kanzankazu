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
            <div class="sticky">
                <div class="card card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (file_exists('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image))
                                <img class="profile-user-img img-circle userImage"
                                    src="{{ asset('vendor/dashboard/image/picture-profiles/' . Auth::user()->user_image) }}"
                                    alt="{{ Auth::user()->name }}">
                            @elseif (Auth::user()->provider == 'google' || Auth::user()->provider == 'github')
                                <img src="{{ Auth::user()->user_image }}" alt="{{ Auth::user()->name }}"
                                    class="profile-user-img img-circle userImage">
                            @else
                                <img class="profile-user-img img-circle userImage"
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
        </div>

        @if (Auth::user()->provider == 'anonymous')
            <div class="col-md-9">
                <div class="card m-b-20">
                    <div class="card-body">

                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link active" data-toggle="tab" href="#setting-1" role="tab">Setelan</a>
                            </li>
                        </ul>

                        <div class="tab-content">

                            {{-- Setting Profile --}}
                            <div class="tab-pane p-3 active" id="setting-1" role="tabpanel">
                                <form class="form-horizontal" method="post"
                                    action="{{ route('profile.updateInfo') }}#profile" id="formUpdateProfile"
                                    autocomplete="off">
                                    @csrf
                                    @method('put')

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Masukkan nama kamu" value="{{ Auth::user()->name }}"
                                                name="name">
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="slug" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="slug" placeholder="Username"
                                                value="{{ Auth::user()->slug }}" name="slug" readonly>
                                            <span class="text-danger error-text slug_error"></span>
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
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-md-9">
                <div class="card m-b-20">
                    <div class="card-body">

                        <ul class="nav nav-pills nav-justified" role="tablist">
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link active" data-toggle="tab" href="#profile-1" role="tab">Profile
                                    Info</a>
                            </li>
                            <li class="nav-item waves-effect waves-light">
                                <a class="nav-link" data-toggle="tab" href="#setting-1" role="tab">Setelan</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active p-3" id="profile-1" role="tabpanel">
                                {{-- Bio --}}
                                <strong class="font-18">Bio</strong>
                                <div class="font-16 mt-1 text-justify user_bio">
                                    {!! Markdown::convert(Auth::user()->bio)->getContent() !!}
                                </div>

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
                                <form class="form-horizontal" method="post"
                                    action="{{ route('profile.updateInfo') }}#profile" id="formUpdateProfile"
                                    autocomplete="off">
                                    @csrf
                                    @method('put')

                                    <div class="form-group row">
                                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Masukkan nama kamu" value="{{ Auth::user()->name }}"
                                                name="name">
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="slug" class="col-sm-2 col-form-label">Username</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="slug"
                                                placeholder="Username" value="{{ Auth::user()->slug }}" name="slug"
                                                readonly>
                                            <span class="text-danger error-text slug_error"></span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" id="inputEmail"
                                                placeholder="Email" value="{{ Auth::user()->email }}" readonly>
                                        </div>
                                    </div>
                                    @if (Auth::id() == 2)
                                        <div class="form-group row">
                                            <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="bio" name="bio" placeholder="enter your bio.."
                                                    onkeyup="countChar2(this)" cols="2" rows="6">{{ Auth::user()->bio }}</textarea>
                                                <span class="float-right" id="charNum"></span>
                                                <span class="mt-5 text-danger error-text bio_error"></span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="form-group row">
                                            <label for="bio" class="col-sm-2 col-form-label">Bio</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="bio" name="bio" placeholder="enter your bio.."
                                                    onkeyup="countChar(this)" cols="2" rows="6">{{ Auth::user()->bio }}</textarea>
                                                <span class="float-right" id="charNum"></span>
                                                <span class="mt-5 text-danger error-text bio_error"></span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="dropdown-divider mb-3 mt-3"></div>
                                    <div class="row mb-4">
                                        <div class="col-sm-4"><b>SOCIALS MEDIA</b></div>
                                        <div class="col-sm-8"></div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control ig" id="instagram"
                                                placeholder="Instagram" value="{{ Auth::user()->instagram }}"
                                                name="instagram">
                                            <span class="text-danger error-text instagram_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control tw" id="twitter"
                                                placeholder="Twitter" value="{{ Auth::user()->twitter }}"
                                                name="twitter">
                                            <span class="text-danger error-text twitter_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control fb" id="facebook"
                                                placeholder="Facebook" value="{{ Auth::user()->facebook }}"
                                                name="facebook">
                                            <span class="text-danger error-text facebook_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="github" class="col-sm-2 col-form-label">Github</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control gh" id="github"
                                                placeholder="Github" value="{{ Auth::user()->github }}" name="github">
                                            <span class="text-danger error-text github_error"></span>
                                        </div>
                                    </div>

                                    @if (Auth::id() == 2)
                                        <div class="dropdown-divider mb-3 mt-3"></div>
                                        <div class="row mb-4">
                                            <div class="col-sm-4"><b>PORTFOLIO</b></div>
                                            <div class="col-sm-8"></div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="vision" class="col-sm-2 col-form-label">Vision</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="pf_vision"
                                                    placeholder="enter your vision.."
                                                    value="{{ Auth::user()->pf_vision }}" name="pf_vision">
                                                <span class="text-danger error-text pf_vision_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="mission" class="col-sm-2 col-form-label">Mission</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="pf_mission" name="pf_mission" placeholder="enter your mission.."
                                                    onkeyup="countChar(this)" cols="2" rows="3">{{ Auth::user()->pf_mission }}</textarea>
                                                <span class="mt-5 text-danger error-text pf_mission_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="skill_desc" class="col-sm-2 col-form-label">Skill Desc</label>
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="pf_skill_desc" name="pf_skill_desc" placeholder="enter your skill desc.."
                                                    onkeyup="countChar(this)" cols="2" rows="3">{{ Auth::user()->pf_skill_desc }}</textarea>
                                                <span class="mt-5 text-danger error-text pf_skill_desc_error"></span>
                                            </div>
                                        </div>

                                        {{-- CV --}}
                                        @php
                                            if (Auth::user()->pf_resume != null) {
                                                $cv = Auth::user()->pf_resume;
                                            } else {
                                                $cv = 'search your resume..';
                                            }
                                        @endphp
                                        <div class="form-group row">
                                            <label for="pf_resume" class="col-sm-2 col-form-label">CV</label>
                                            <div class="col-sm-10">
                                                <div class="custom-file">
                                                    <input type="file" name="pf_resume" value="{{ $cv }}"
                                                        class="custom-file-input" id="pf_resume">
                                                    <label class="custom-file-label"
                                                        for="pf_resume">{{ $cv }}</label>
                                                </div>
                                                <span class="invalid-feedback d-block error-text pf_resume_error"></span>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button type="submit" id="buttonProfile" class="btn btn-primary">Update
                                                Profile</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->uid == null)
                    <div class="card m-b-30">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-justified" role="tablist">
                                <li class="nav-item waves-effect waves-light">
                                    <a disabled class="nav-link" data-toggle="tab" href="#setting-3" role="tab"
                                        style="cursor: default">Ganti
                                        Password</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                {{-- Change Password --}}
                                <div class="tab-pane p-3" id="setting-3" role="tabpanel">

                                    <form action="{{ route('profile.changePassword') }}" method="POST"
                                        class="form-horizontal" id="formPassword" autocomplete="off">
                                        @csrf
                                        @method('put')

                                        <div class="form-group row">
                                            <label for="oldpass" class="col-sm-2 col-form-label">Password Lama</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="oldpass"
                                                    placeholder="Masukkan password yang sekarang" name="oldpass">
                                                <span class="invalid-feedback d-block error-text oldpass_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="newpass" class="col-sm-2 col-form-label">Password Baru</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="newpass"
                                                    placeholder="Masukkan password yang baru" name="newpass">
                                                <span class="invalid-feedback d-block error-text newpass_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="confirmpass" class="col-sm-2 col-form-label">Konfimasi</label>
                                            <div class="col-sm-10">
                                                <input type="password" class="form-control" id="confirmpass"
                                                    placeholder="Masukkan password yang dibuat baru tadi"
                                                    name="confirmpass">
                                                <span class="invalid-feedback d-block error-text confirmpass_error"></span>
                                            </div>
                                        </div>

                                        <div id="forgotPassword" class="d-none">
                                            <div class="form-group row">
                                                <div class="offset-sm-10 col-sm-10">
                                                    <a target="_blank" href="{{ route('password.request') }}">Forgot
                                                        Password</a>
                                                </div>
                                            </div>

                                            <div class="dropdown-divider mb-3 mt-3"></div>
                                        </div>


                                        <div class="form-group row">
                                            <div class="offset-sm-2 col-sm-10">
                                                <button name="submitPass" type="submit" id="buttonPassword"
                                                    class="btn btn-primary">
                                                    Update Password
                                                </button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif

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
        function countChar2(val) {
            let max = 1000
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
            // change name to username no number to lowercase
            $('#name').on('keyup', function() {
                var name = $(this).val();
                var username = name.replace(/[^a-zA-Z]/g, '').toLowerCase();
                $('#slug').val(username);
            });

            $('input[type="file"]').on('change', function() {
                var fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass('selected').html(fileName);
            });

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
                            setTimeout((function() {
                                // window.location.href =
                                //     '{{ route('profile.index') }}#profile';
                                window.location.reload();
                            }), 980);

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

                            $('#forgotPassword').removeClass('d-none');
                        } else {
                            $('#forgotPassword').addClass('d-none');
                            $('#formPassword')[0].reset();

                            alertify
                                .delay(3500)
                                .log(data.msg);
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
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
        });
    </script>
@endpush
