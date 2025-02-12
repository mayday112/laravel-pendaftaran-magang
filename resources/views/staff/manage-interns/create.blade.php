@extends('layouts.apps')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Data Magang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item "><a href="{{ route('magang.index') }}">Data Magang
                            {{ Auth::user()->name }}</a>
                    </div>
                    <div class="breadcrumb-item active">Tambah Peserta</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('magang.store') }}" class="card" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <ul>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </ul>
                                </div>
                            @endif
                            {{-- <div class="card"> --}}
                            <div class="card-header">
                                <h1>Tambah Peserta Magang</h1>
                            </div>
                            <div class="card-body row">
                                {{-- Nama --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="name">Nama Lengkap</label>
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        tabindex="1" value="{{ old('name') }}" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- username --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="username">Username</label>
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        tabindex="1" value="{{ old('username') }}" required autofocus>
                                    @error('username')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- password --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="password">Password</label>
                                    <input id="password" type="password"
                                        class="form-control   @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- masukkan ulang password --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="password_confirmation" class="d-block">Masukkan ulang Password</label>
                                    <input id="password_confirmation" type="password"
                                        class="form-control  @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation">
                                </div>
                                {{-- no telepon --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>No Telepon</label>
                                    <input type="text" name="no_telp"
                                        class="form-control @error('no_telp') is-invalid @enderror"
                                        value="{{ old('no_telp') }}" required>
                                    <div class="helper">Isi dengan angka saja, contoh : 081234567890</div>
                                    @error('no_telp')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- no induk --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>No Induk</label>
                                    <input type="text" name="no_induk"
                                        class="form-control @error('no_induk') is-invalid @enderror"
                                        value="{{ old('no_induk') }}" required>
                                    @error('no_induk')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- asal institut --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Asal sekolah/kampus</label>
                                    <input type="text" name="asal_institusi"
                                        class="form-control @error('asal_institusi') is-invalid @enderror"
                                        value="{{ old('asal_institusi') }}" required>
                                    @error('asal_institusi')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- jurusan --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Jurusan</label>
                                    <input type="text" name="jurusan"
                                        class="form-control @error('jurusan') is-invalid @enderror"
                                        value="{{ old('jurusan') }}" required>
                                    @error('jurusan')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- bidang diambil --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label>Bidang diambil</label>
                                    <select class="form-control @error('bidang_diambil') is-invalid @enderror"
                                        name="bidang_diambil" required>
                                        <option value="Bidang Persandian"
                                            {{ old('bidang_diambil') === 'Bidang Persandian' ? 'selected' : '' }}>
                                            Bidang Persandian</option>
                                        <option value="Bidang TIK"
                                            {{ old('bidang_diambil') === 'Bidang TIK' ? 'selected' : '' }}>Bidang TIK
                                        </option>
                                        <option value="Bidang KIP"
                                            {{ old('bidang_diambil') === 'Bidang KIP' ? 'selected' : '' }}>Bidang KIP
                                        </option>
                                        <option value="Keuangan"
                                            {{ old('bidang_diambil') === 'Keuangan' ? 'selected' : '' }}>Keuangan
                                        </option>
                                        <option value="Sekretariat"
                                            {{ old('bidang_diambil') === 'Sekretariat' ? 'selected' : '' }}>Sekretariat
                                        </option>
                                    </select>
                                    @error('bidang_diambil')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                {{-- tanggal magang --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    {{-- tanggal awal magang --}}
                                    <input type="hidden" name="start_date" id="start_date"
                                        value="{{ old('start_date', now()->format('m/d/Y')) }}" readonly>
                                    {{-- tanggal akhir magang --}}
                                    <input type="hidden" name="end_date" id="end_date"
                                        value="{{ old('end_date', now()->format('m/d/Y')) }}" readonly>
                                    <label>Tanggal Magang</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="fas fa-calendar"></i>
                                            </div>
                                        </div>
                                        <input type="text" class="form-control daterange-cus" name="daterange"
                                            value="{{ old('start_date', now()->format('m/d/Y')) . ' - ' . old('end_date', now()->format('m/d/Y')) }}"
                                            required>
                                    </div>
                                    <div class="helper">Masukkan tanggal anda akan magang</div>

                                </div>
                                {{-- surat pengantar --}}
                                <div class="form-group col-12 col-md-6 col-lg-4">
                                    <label for="surat_pengantar">Surat Pengantar</label>
                                    <input type="file" name="surat_pengantar" id="surat_pengantar"
                                        class="form-control @error('surat_pengantar') is-invalid @enderror"
                                        accept=".pdf,.doc,.docx" required>
                                    <div class="helper">Pastikan anda memasukkan file PDF</div>
                                    @error('surat_pengantar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                            {{-- </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <!-- Page Specific JS File -->
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                    'YYYY-MM-DD') + ' (predefined range: ' + label + ')')
                $('#start_date').val(start.format('MM/DD/YYYY'))
                $('#end_date').val(end.format('MM/DD/YYYY'))
            });
        });
    </script>
@endpush
