@extends('layouts.auth')

@section('title', 'Daftar akun')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
<div class="card card-primary">
    <div class="card-header">
        <h4>Mendaftar</h4>
    </div>


    <div class="card-body">
        <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate="">
            @csrf

            {{-- Nama --}}
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" tabindex="1" value="{{ old('name') }}" required autofocus>
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- username --}}
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" tabindex="1" value="{{ old('username') }}" required autofocus>
                @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            {{-- password --}}
            <div class="form-group">
                <label for="password" class="d-block">Password</label>
                <input id="password" type="password" class="form-control pwstrength  @error('password') is-invalid @enderror" data-indicator="pwindicator" name="password">
                <div id="pwindicator" class="pwindicator">
                    <div class="bar"></div>
                    <div class="label"></div>
                </div>
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation" class="d-block">Masukkan ulang Password</label>
                <input id="password_confirmation" type="password" class="form-control  @error('password_confirmation') is-invalid @enderror" name="password_confirmation">
            </div>

            {{-- submit --}}
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                    Daftar
                </button>
            </div>
        </form>
        <div class="text-muted mt-5 text-center">
            Sudah punya akun?<a href="{{ route('login') }}">Login disini</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
