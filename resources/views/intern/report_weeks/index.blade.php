@extends('layouts.apps')

@section('title', 'Laporan')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4>Laporan Mingguan</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div class="container d-flex justify-content-end mb-5" style="gap:1rem;">
                        <a href="{{ route('report-to-excel') }}" class="btn btn-success">Export to Excel</a>
                        <a href="{{ route('report-to-pdf') }}" class="btn btn-danger">Export to PDF</a>
                        <a href="{{ route('report-weeks.create') }}" class="btn btn-primary">+<span>Tambah</span></a>
                    </div>
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">Tanggal dibuat</th>
                                <th scope="col">foto</th>
                                <th scope="col">Deskripsi</th>
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
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('report-weeks.index') }}", // Ubah route ke route yang sesuai dengan data laporan mingguan
                columns: [{
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'foto',
                        name: 'foto',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });
    </script>
@endpush
