@extends('layouts.auth')

@section('title', 'Verifikasi Email Kamu')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Verifikasi alamat email kamu.</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                Tautan verifikasi baru telah dikirim ke alamat email kamu.
                            </div>
                        @endif

                        {{ __('Sebelum melanjutkan, harap periksa email Kamu untuk tautan verifikasi.') }}
                        {{ __('Jika Kamu tidak menerima email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik disini') }}</button> untuk menerima
                            tautan verifikasi yang baru.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
