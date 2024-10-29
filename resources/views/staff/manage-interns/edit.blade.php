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
                    <div class="breadcrumb-item active"><a href="{{ route('manage-magang') }}">Manage Data Magang</a></div>
                    <div class="breadcrumb-item active"><a href="{{ route('edit-magang', $data['id']) }}">Manage Data
                            Magang</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="row d-flex justify-content-center">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="card">
                            <form action="{{ route('update-magang', $data['id']) }}" method="POST" class="needs-validation"
                                novalidate="" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="card-header">
                                    <h4>Edit Data Magang</h4>
                                </div>
                                <div class="card-body">

                                    {{-- Informasi Pemagang --}}
                                    <div class="form-group">
                                        <p>Nama : {{ $data->user->name }}</p>
                                        <p>No Induk : {{ $data->no_induk }}</p>
                                        <p>{{ $data['asal_institusi'] . ' -' . $data['jurusan'] }}</p>
                                        <p>Bidang : {{ $data['bidang_diambil'] }}</p>
                                        <p>Tanggal Magang :
                                            {{ $data['tanggal_awal_magang']->format('d M Y') . ' - ' . $data['tanggal_akhir_magang']->format('d M Y') }}
                                        </p>
                                        <a id="surat-pengantar"
                                            href="{{ Storage::url('surat pengantar/' . $data['surat_pengantar']) }}"
                                            target="_blank">Surat Pengantar</a>
                                    </div>
                                    {{-- input approve magang --}}
                                    <div class="form-group">
                                        <select name="approve_magang" class="form-control select2"
                                            {{-- {{ $data['approve_magang'] == 'diterima' || $data['approve_magang'] == 'ditolak' ? 'disabled' : '' }} --}}
                                            >
                                            <option value="diterima"
                                                {{ old('role', $data['approve_magang']) == 'diterima' ? 'selected' : '' }}>
                                                Terima</option>
                                            <option value="ditolak"
                                                {{ old('role', $data['approve_magang']) == 'ditolak' ? 'selected' : '' }}>
                                                Tolak</option>
                                            <option value="diproses"
                                                {{ old('role', $data['approve_magang']) == 'diproses' ? 'selected' : '' }}>
                                                Diproses</option>
                                        </select>
                                        @error('approve_magang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    {{-- input file nilai --}}
                                    <div class="form-group">
                                        <label>File Nilai</label>
                                        {{-- file nilai terdahulu jika ada --}}
                                        @if ($data['nilai_magang'])
                                            <a href="{{ Storage::url('nilai magang/' . $data['nilai_magang']) }}"
                                                target="_blank">{{ $data['nilai_magang'] }}</p>
                                        @endif
                                        <input type="file" name="nilai_magang"
                                            class="form-control @error('nilai_magang') is-invalid @enderror"
                                            @if ($data['approve_magang'] == 'ditolak' || $data['approve_magang'] == 'diproses') disabled @endif>
                                        @error('nilai_magang')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    {{-- tanggal  magang --}}
                                    {{-- <div class="form-group">

                                    <input type="hidden" name="start_date" id="start_date" value="{{ $data['tanggal_awal_magang']->format('d/m/Y') }}" readonly>

                    <input type="hidden" name="end_date" id="end_date" value="{{ $data['tanggal_akhir_magang']->format('d/m/Y') }}" readonly>

                    <label>Date Range Picker</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </div>
                        </div>
                        <input type="text" class="form-control daterange-cus" name="daterange" value="{{ $data['tanggal_awal_magang']->format('d/m/y') . ' - ' . $data['tanggal_akhir_magang']->format('d/m/y') }}" readonly>
                    </div>
                </div> --}}
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
