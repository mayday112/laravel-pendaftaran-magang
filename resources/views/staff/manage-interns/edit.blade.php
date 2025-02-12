@extends('layouts.apps')


@section('title', 'Edit Data Magang')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Manage Data Magang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('magang.index') }}">Data Magang</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('magang.edit', $data['id']) }}">Edit Data
                            Magang</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form action="{{ route('magang.update', $data['id']) }}" method="POST" class="needs-validation"
                                novalidate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-header">
                                    <h4>Edit Data Magang</h4>
                                </div>
                                <div class="card-body row">

                                    <input type="hidden" name="user_id" value="{{ $data->user->id }}">
                                    {{-- Nama --}}
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="name">Nama Lengkap</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            tabindex="1" value="{{ old('name', $data->user->name) }}" required autofocus>
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
                                            tabindex="1" value="{{ old('username', $data->user->username) }}" required
                                            autofocus>
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
                                            value="{{ old('no_telp', $data->no_telp) }}" required>
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
                                            value="{{ old('no_induk', $data->no_induk) }}" required>
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
                                            value="{{ old('asal_institusi', $data->asal_institusi) }}" required>
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
                                            value="{{ old('jurusan', $data->jurusan) }}" required>
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
                                                {{ old('bidang_diambil', $data->bidang_diambil) === 'Bidang Persandian' ? 'selected' : '' }}>
                                                Bidang Persandian</option>
                                            <option value="Bidang TIK"
                                                {{ old('bidang_diambil', $data->bidang_diambil) === 'Bidang TIK' ? 'selected' : '' }}>
                                                Bidang TIK
                                            </option>
                                            <option value="Bidang KIP"
                                                {{ old('bidang_diambil', $data->bidang_diambil) === 'Bidang KIP' ? 'selected' : '' }}>
                                                Bidang KIP
                                            </option>
                                            <option value="Keuangan"
                                                {{ old('bidang_diambil', $data->bidang_diambil) === 'Keuangan' ? 'selected' : '' }}>
                                                Keuangan
                                            </option>
                                            <option value="Sekretariat"
                                                {{ old('bidang_diambil', $data->bidang_diambil) === 'Sekretariat' ? 'selected' : '' }}>
                                                Sekretariat
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
                                            value="{{ old('start_date', $data->tanggal_awal_magang->format('d/m/Y')) }}"
                                            readonly>
                                        {{-- tanggal akhir magang --}}
                                        <input type="hidden" name="end_date" id="end_date"
                                            value="{{ old('end_date', $data->tanggal_akhir_magang->format('d/m/Y')) }}"
                                            readonly>
                                        <label>Tanggal Magang</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control daterange-cus" name="daterange"
                                                value="{{ old('start_date', $data->tanggal_awal_magang->format('d/m/Y')) . ' - ' . old('end_date', $data->tanggal_akhir_magang->format('d/m/Y')) }}"
                                                required>
                                        </div>
                                        <div class="helper">Masukkan tanggal anda akan magang</div>

                                    </div>
                                    {{-- surat pengantar --}}
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label for="surat_pengantar">Surat Pengantar</label>
                                        <input type="file" name="surat_pengantar" id="surat_pengantar"
                                            class="form-control @error('surat_pengantar') is-invalid @enderror"
                                            accept=".pdf,.doc,.docx">
                                        <div class="helper">Pastikan anda memasukkan file PDF</div>

                                        @error('surat_pengantar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        <a href="{{ Storage::url('surat pengantar/' . $data->surat_pengantar) }}"
                                            target="_blank">Surat Pengantar {{ $data->user->name }}</a>
                                    </div>

                                    {{-- input file nilai --}}
                                    <div class="form-group col-12 col-md-6 col-lg-4">
                                        <label>File Nilai</label>
                                        {{-- file nilai terdahulu jika ada --}}
                                        <input type="file" name="nilai_magang"
                                            class="form-control @error('nilai_magang') is-invalid @enderror">
                                        @error('nilai_magang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        @if ($data['nilai_magang'])
                                            <a href="{{ Storage::url('nilai magang/' . $data['nilai_magang']) }}"
                                                target="_blank">Nilai {{ $data->user->name }}</a>
                                        @endif
                                    </div>
                                </div>

                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
    <script src="{{ asset('library/cleave.js/dist/cleave.min.js') }}"></script>
    <script src="{{ asset('library/cleave.js/dist/addons/cleave-phone.us.js') }}"></script>
    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('library/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/auth-register.js') }}"></script> --}}
    <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                "minDate": "DD-MM-YYYY",
                "maxDate": "DD-MM-YYYY"
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                    'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                $('#start_date').val(start.format('DD/MM/YYYY'));
                $('#end_date').val(end.format('DD/MM/YYYY'));
            });
        });
    </script>
@endpush
