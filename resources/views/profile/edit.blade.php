{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

@extends('layouts.apps')

@section('title', 'Blank Page')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
    <style>
        .form-group img {
            display: none;
            width: 150px;
            height: auto;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Hi, {{ $user->name }}!</h2>
                <div class="row mt-sm-4">
                    {{-- update username, name, & avatar --}}
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                <img alt="image"
                                    src="{{ $user->photo_path ? Storage::url('foto profil/' . $user->photo_path) : asset('img/avatar/avatar-1.png') }}"
                                    class="rounded-circle profile-widget-picture shadow"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                {{-- <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Posts</div>
                                        <div class="profile-widget-item-value">187</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Followers</div>
                                        <div class="profile-widget-item-value">6,8K</div>
                                    </div>
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">Following</div>
                                        <div class="profile-widget-item-value">2,1K</div>
                                    </div>
                                </div> --}}
                            </div>
                            {{-- update name,profile foto, & username --}}
                            <div class="profile-widget-description">
                                <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                                    @csrf
                                </form>
                                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('patch')

                                    <div class="row">
                                        {{-- nama --}}
                                        {{-- <div class="form-group col-md-6 col-12"> --}}
                                        <div class="form-group col-md-6 col-lg-10 col-12">
                                            <label>Nama</label>
                                            <input type="text" name="name" class="form-control"
                                                value="{{ old('name', $user->name) }}" required="">
                                            <div class="invalid-feedback">
                                                Please fill in the first name
                                            </div>
                                        </div>
                                        {{-- username --}}
                                        <div class="form-group col-md-6 col-lg-10 col-12">
                                            <label>Username</label>
                                            <input type="text" name="username" class="form-control"
                                                value="{{ old('username', $user->username) }}" required="">
                                            <div class="invalid-feedback">
                                                Please fill in the first username
                                            </div>
                                        </div>
                                    </div>
                                    {{-- foto profil --}}
                                    <div class="form-group row">
                                        <label for="photo_profile" class="col-12">Foto profil</label>
                                        <img class="mt-1 mb-3 mx-3"
                                            src="{{ $user->photo_path ? Storage::url('foto profil/' . $user->photo_path) : asset('img/avatar/avatar-1.png') }}"
                                            id="preview-img" />
                                        {{-- <div id="preview-img"></div> --}}
                                        <input class="col-lg-10 col-11 form-control" type="file" name="photo_profile"
                                            id="photo_profile" accept="image/*" onchange="previewImage()">
                                        <div class="m-3 text-danger">*Pastikan file foto beresolusi 1:1</div>
                                    </div>
                                    {{-- button save --}}
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>

                            </div>
                            <div class="card-footer text-center">

                            </div>
                        </div>
                    </div>

                    {{-- update password --}}
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form action="{{ route('password.update') }}" method="post" class="needs-validation"
                                novalidate="">
                                @csrf
                                @method('put')

                                <div class="card-header">
                                    <h4>Update Password</h4>
                                </div>
                                <div class="card-body">
                                    {{-- password sekarang --}}
                                    <div class="form-group ">
                                        <label for="current_password">Password Sekarang</label>
                                        <input type="password" name="current_password" id="current_password"
                                            class="form-control" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the first current password
                                        </div>
                                    </div>
                                    {{-- password baru --}}
                                    <div class="form-group ">
                                        <label for="password">Password Baru</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            required="">
                                        <div class="invalid-feedback">
                                            Please fill in the last new passowrd
                                        </div>
                                    </div>
                                    {{-- konfirmasi passoword baru --}}
                                    <div class="form-group ">
                                        <label for="password_confirmation">Konfirmasi Password Baru</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control" required="">
                                        <div class="invalid-feedback">
                                            Please fill in the last confirmation password
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan Password</button>
                                </div>
                        </div>
                        </form>
                    </div>

                    {{-- delete account --}}
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form action="{{ route('profile.destroy') }}" method="post">
                                @csrf
                                @method('delete')

                                <div class="card-header">
                                    <h4>Hapus akun</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group ">
                                        <label for="password">Masukkan Password</label>
                                        <input type="password" name="password" id="password" class="form-control"
                                            required="">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                Please fill in the last new passowrd
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-danger">Hapus akun</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection

@push('scripts')
    <!-- JS Libraies -->
    {{-- <script defer src="https://cdn.crop.guide/loader/l.js?c=123ABC"></script> --}}
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    {{-- <script src="{{ asset('library/croppie/croppie.js') }}"></script> --}}
    <!-- Page Specific JS File -->
    <script>
        const imageUpload = document.getElementById('photo_profile');
        const previewImage = document.getElementById('preview-img');

        // var previewImage = new Croppie($('#preview-img')[0], {
        //     viewport: {
        //         width: 150,
        //         height: 150
        //     },
        //     boundary: {
        //         width: 200,
        //         height: 200
        //     },
        //     enableResize: true,
        //     enableOrientation: true,
        //     enableExif: true,
        // });

        imageUpload.addEventListener('change', event => {
            const file = imageUpload.files[0];

            if (file) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    previewImage.style.display = 'block';
                    previewImage.src = e.target.result;

                    // previewImage.setAttribute('display','block');
                    // previewImage.setAttribute('src', e.target.result);
                };

                reader.readAsDataURL(file);
            } else {
                previewImage.setAttribute('src', '{{ asset('img/avatar/avatar-1.png') }}');
            }
        });
        // imageUpload.addEventListener('change', event => {
        //     const file = imageUpload.files[0];

        //     if (file) {
        //         const reader = new FileReader();

        //         reader.onload = (e) => {
        //             // previewImage.style.display = 'block';
        //             // previewImage.src = e.target.result;

        //             // previewImage.setAttribute('display','block');
        //             // previewImage.setAttribute('src', e.target.result);
        //             previewImage.bind({
        //                 url: e.target.result
        //             }).then(()=>{
        //                 console.log('okee')
        //             });
        //         };

        //         reader.readAsDataURL(file);
        //     } else {
        //         previewImage.setAttribute('src', '{{ asset('img/avatar/avatar-1.png') }}');
        //     }
        // });
    </script>
@endpush
