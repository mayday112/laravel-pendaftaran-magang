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
                <h4>Data Pengguna</h4>
            </div>
            <div class="container d-flex justify-content-end">
                <a href="{{ route('manage-user.create') }}" class="btn btn-primary mx-2">+<span>Tambah</span></a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Username</th>
                                <th scope="col">Role</th>
                                <th scope="col">Terakhir Update</th>
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
                ajax: "{{ route('manage-user.index') }}", // Ubah route ke route yang sesuai dengan data mahasiswa
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'foto', name: 'foto', searchable : false , orderable : false},
                    {data: 'name', name: 'name'},
                    {data: 'username', name: 'username'},
                    {data: 'role', name: 'role'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable : false, searchable: false},
                ]
            });

        });
    </script>
@endpush
