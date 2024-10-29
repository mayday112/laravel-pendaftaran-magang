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
                    <div class="breadcrumb-item "><a href="{{ route('intern') }}">Data Magang {{ Auth::user()->name }}</a>
                    </div>
                    <div class="breadcrumb-item active">Edit</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <form action="{{ route('intern-edit-data') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="card">
                                <div class="card-header">
                                    <h1>Hello World</h1>
                                </div>
                                <div class="card-body">
                                    {{-- nama --}}
                                    <div class="form-group">
                                        <label>Nama</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $data->user->name }}" disabled>
                                    </div>
                                    {{-- no telepon --}}
                                    <div class="form-group">
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
                                    <div class="form-group">
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
                                    {{-- asal institusi --}}
                                    <div class="form-group">
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
                                    <div class="form-group">
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
                                    <div class="form-group">
                                        <label>Bidang diambil</label>
                                        <select class="form-control @error('bidang_diambil') is-invalid @enderror"
                                            name="bidang_diambil" required>
                                            <option value="Bidang Persandian"
                                                {{ old('bidang_diambil', $data['bidang_diambil']) === 'Bidang Persandian' ? 'selected' : '' }}>
                                                Bidang Persandian</option>
                                            <option value="Bidang TIK"
                                                {{ old('bidang_diambil', $data['bidang_diambil']) === 'Bidang TIK' ? 'selected' : '' }}>
                                                Bidang TIK
                                            </option>
                                            <option>Option 3</option>
                                        </select>
                                        <div class="helper">Pilih bidang yang akan anda ambil saat magang</div>
                                        @error('bidang_diambil')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- tanggal magang --}}
                                    <div class="form-group">
                                        {{-- tanggal awal magang --}}
                                        <input type="hidden" name="start_date" id="start_date"
                                            value="{{ old('start_date', $data['tanggal_awal_magang']->format('d/m/Y')) }}"
                                            readonly>
                                        {{-- tanggal akhir magang --}}
                                        <input type="hidden" name="end_date" id="end_date"
                                            value="{{ old('end_date', $data['tanggal_akhir_magang']->format('d/m/Y')) }}"
                                            readonly>

                                        <label>Date Range Picker</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-calendar"></i>
                                                </div>
                                            </div>
                                            <input type="text" class="form-control daterange-cus" name="daterange">
                                        </div>
                                        <div class="helper">Format tanggal : bulan/tanggal/tahun</div>
                                    </div>
                                    {{-- surat pengantar --}}
                                    <div class="form-group">
                                        <label for="surat_pengantar">Surat Pengantar</label>
                                        <input type="file" name="surat_pengantar" id="surat_pengantar" accept=".pdf"
                                            class="form-control @error('surat_pengantar') is-invalid @enderror">
                                        <div class="helper">Pastikan anda memasukkan file PDF</div>
                                        <p>
                                            <a id="surat-pengantar"
                                                href="{{ Storage::url('surat pengantar/' . $data['surat_pengantar']) }}"
                                                target="_blank">{{ $data->surat_pengantar }}</a>
                                        </p>
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
                            </div>
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
    {{-- <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script> --}}
    <!-- Page Specific JS File -->
    <script>
        $(function() {
            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                "startDate": "{{ old('start_date', $data['tanggal_awal_magang']->format('m/d/Y')) }}",
                "endDate": "{{ old('end_date', $data['tanggal_akhir_magang']->format('m/d/Y')) }}",
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format(
                    'YYYY-MM-DD') + ' (predefined range: ' + label + ')');
                $('#start_date').val(start.format('MM/DD/YYYY'));
                $('#end_date').val(end.format('MM/DD/YYYY'));
            });
        });
    </script>
@endpush
