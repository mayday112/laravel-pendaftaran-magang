@extends('layouts.apps')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4>Data Magang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <a href="{{ route('export-excel') }}" class="btn btn-primary mb-5 float-end">Export to Excel</a>
                    <a href="{{ route('export-dompdf') }}" class="btn btn-primary mb-5 float-end">Export to PDF</a>
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">No Induk</th>
                                {{-- <th scope="col">ID</th> --}}
                                <th scope="col">Nama</th>
                                <th scope="col">No Telp</th>
                                {{-- <th scope="col">Jurusan</th> --}}
                                <th scope="col">Posisi diambil</th>
                                <th scope="col">Surat Pengantar</th>
                                {{-- <th scope="col">Tanggal Awal Magang</th>
                                <th scope="col">Tanggal Akhir Magang</th> --}}
                                <th scope="col">Approve</th>
                                {{-- <th scope="col">Nilai Magang</th> --}}
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody> </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script type="text/javascript">
        $(document).ready( function () {

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('manage-magang') }}", // Ubah route ke route yang sesuai dengan data mahasiswa
                columns: [
                    {data: 'no_induk', name: 'no_induk'},
                    // {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'no_telp', name: 'no_telp'},
                    {data: 'jurusan', name: 'jurusan'},
                    // {data: 'bidang_diambil', name: 'bidang_diambil'},
                    {data: 'surat_pengantar', name: 'surat_pengantar'},
                    // {data: 'tanggal_awal_magang', name: 'tanggal_awal_magang'},
                    // {data: 'tanggal_akhir_magang', name: 'tanggal_akhir_magang'},
                    {data: 'approve_magang', name: 'approve_magang'},
                    // {data: 'nilai_magang', name: 'nilai_magang'},
                    // {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable : false, searchable: false},
                ]
            });
        });
    </script>
@endpush
