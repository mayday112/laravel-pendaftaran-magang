@extends('layouts.apps')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <div class="section">
            <div class="section-header">
                <h1>Data Magang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active">Data Magang {{ Auth::user()->name }}</div>
                </div>
            </div>
            <div class="section-body">
                <div class="col-12 mb4">
                    <div class="section-body">
                        <div class="row d-flex justify-content-center">
                            <div class="col-12 col-md-8 col-lg-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Data Magang Anda</h4>
                                    </div>
                                    <div class="card-body">
                                        {{-- Informasi Pemagang --}}
                                        <p>Nama : {{ $data->user->name }}</p>
                                        <p>No Telp : {{ $data->no_telp }}</p>
                                        <p>No Induk : {{ $data->no_induk }}</p>
                                        <p>Asal Sekolah/kampus :
                                            {{ $data->asal_institusi . ' -' . $data->jurusan }}
                                        </p>
                                        <p>Bidang : {{ $data->bidang_diambil }}</p>
                                        <p>Tanggal Magang :
                                            {{ $data->tanggal_awal_magang->format('d M Y') . ' - ' . $data->tanggal_akhir_magang->format('d M Y') }}
                                        </p> Surat Pengantar :
                                        <a id="surat-pengantar"
                                            href="{{ Storage::url('surat pengantar/' . $data->surat_pengantar) }}"
                                            target="_blank">{{ $data->surat_pengantar }}</a>
                                        <p>Nilai : <a
                                                href="{{ $data->nilai_magang ? Storage::url('nilai magang/' . $data->nilai_magang) : '#' }}"
                                                target="_blank">{{ $data->nilai_magang ? $data->nilai_magang : 'Belum ada nilai' }}</a>
                                            @if ($data->nilai_magang)
                                                <div class="button button-primary">
                                                    <a href="{{ route('intern-download-nilai', $data->nilai_magang) }}"
                                                        class="button button-primary">Download</a>
                                                </div>
                                            @endif
                                        </p>
                                        <div class="helper text-warning">Jika ada data yang tidak sesuai hubungi admin</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
