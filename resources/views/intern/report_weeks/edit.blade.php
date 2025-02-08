@extends('layouts.apps')


@section('title', 'Tambah Laporan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Pengguna</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('report-weeks.index') }}">Laporan</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('report-weeks.create') }}">Tambah Laporan</a>
                    </div>
                </div>
            </div>
            <div class="section-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <form action="{{ route('report-weeks.update', $report->id) }}" method="POST" enctype="multipart/form-data">
                            <div class="card">
                                @csrf
                                @method('PUT')

                                <div class="card-header">
                                    <h4>Tambah Laporan</h4>
                                </div>
                                <div class="card-body">
                                    <input type="hidden" name="internship_id" value="{{ $report->internship_id }}">
                                    {{-- Deskripsi --}}
                                    <div class="form-group row mb-4">
                                        <label for="deskripsi" class="col-form-label text-left">Deskripsi</label>
                                        <div class="col-12">
                                            <textarea name="deskripsi" id="deskripsi" class="summernote-simple" required>{{ old('deskripsi', $report->deskripsi) }}</textarea>
                                        </div>
                                        @error('deskripsi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- foto --}}
                                    <div class="form-group mb-4">
                                        <label for="foto" class="col-12 p-0 text-left">Foto</label>
                                        <input type="file" name="foto" id="foto"
                                            class="form-input @error('username') is-invalid @enderror" accept="image/*">
                                        @error('foto')
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

        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/auth-register.js') }}"></script>
@endpush
