@extends('layouts.apps')


@section('title', Route::is('manage-user.create') ? 'Tambah Pengguna' : 'Edit Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('manage-user.index') }}">Pengguna</a></div>
                    @if (Route::is('manage-user.create'))
                        <div class="breadcrumb-item"><a href="{{ route('manage-user.create') }}">Tambah Pengguna</a></div>
                    @else
                        <div class="breadcrumb-item">Edit Pengguna</div>
                    @endif
                </div>
            </div>
            {{-- <a href="{{ route('manage-user.index') }}" class="text-white">&laquo; Kembali</a> --}}
            {{-- @if (Route::is('manage-user.edit'))
            @endif --}}
            <div class="section-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form
                                action="{{ Route::is('manage-user.create') ? route('manage-user.store') : route('manage-user.update', $user['id']) }}"
                                method="POST" class="needs-validation" novalidate="">
                                @csrf
                                @if (Route::is('manage-user.edit'))
                                    @method('PUT')
                                @endif

                                <div class="card-header">
                                    <h4>Tambah Pengguna</h4>
                                </div>
                                <div class="card-body">
                                    {{-- nama --}}
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="Masukkan nama pengguna"
                                            value="{{ old('name', Route::is('manage-user.edit') ? $user['name'] : '') }}"
                                            required autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- username --}}
                                    <div class="form-group">
                                        <label>Username</label>
                                        <input type="text" name="username"
                                            class="form-control @error('username') is-invalid @enderror"
                                            placeholder="Masukkan Username"
                                            value="{{ old('username', Route::is('manage-user.edit') ? $user['username'] : '') }}"
                                            required autofocus autocomplete="off">
                                        @error('username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    @if (Route::is('manage-user.create'))
                                        {{-- password --}}
                                        <div class="form-group">
                                            <label for="password" class="d-block">Password</label>
                                            <input id="password" type="password"
                                                class="form-control pwstrength  @error('password') is-invalid @enderror"
                                                data-indicator="pwindicator" name="password">
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
                                            <label for="password_confirmation" class="d-block">Masukkan ulang
                                                Password</label>
                                            <input id="password_confirmation" type="password"
                                                class="form-control  @error('password_confirmation') is-invalid @enderror"
                                                name="password_confirmation">
                                        </div>
                                    @endif

                                    {{-- role --}}
                                    <div class="form-group">
                                        <label>Role</label>
                                        <select name="role" class="form-control select2">
                                            {{-- cek dulu route, jika route adalah edit data user-->cek option yg akan di selected --}}
                                            <option value="client"
                                                {{ old('role', Route::is('manage-user.edit') ? $user['role'] : '') == 'intern' ? 'selected' : '' }}>
                                                peserta magang</option>
                                            <option value="admin"
                                                {{ old('role', Route::is('manage-user.edit') ? $user['role'] : '') == 'admin' ? 'selected' : '' }}>
                                                admin</option>
                                            <option value="staff"
                                                {{ old('role', Route::is('manage-user.edit') ? $user['role'] : '') == 'staff' ? 'selected' : '' }}>
                                                staff</option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/jquery.pwstrength/jquery.pwstrength.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
