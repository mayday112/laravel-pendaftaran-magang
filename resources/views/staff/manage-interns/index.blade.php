@extends('layouts.apps')

@section('title', 'Pengguna')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('library/prismjs/themes/prism.min.css') }}"> --}}
@endpush

@section('main')
    <div class="main-content">
        <div class="card">
            <div class="card-header">
                <h4>Data Magang</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    {{-- <a href="{{ route('export-excel') }}" class="btn btn-success mb-5 float-end">Export to Excel</a>
                    <a href="{{ route('export-dompdf') }}" class="btn btn-danger mb-5 float-end">Export to PDF</a> --}}
                    {{-- <button class="btn btn-primary mb-5" id="modal-5">Login</button> --}}
                    <button class="btn btn-danger mb-5" id="modal-cetak-pdf">cetak pdf</button>
                    <button class="btn btn-success mb-5" id="modal-cetak-excel">cetak excel</button>
                    <a href="{{ route('magang.create') }}" class="btn btn-primary mb-5 float-end">+Tambah Peserta</a>

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

    <form class="modal-part" id="modal-login-part">
        <p>This login form is taken from elements with <code>#modal-login-part</code> id.</p>
        <div class="form-group">
            <label>Username</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-envelope"></i>
                    </div>
                </div>
                <input type="text" class="form-control" placeholder="Email" name="email">
            </div>
        </div>
        <div class="form-group">
            <label>Password</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                        <i class="fas fa-lock"></i>
                    </div>
                </div>
                <input type="password" class="form-control" placeholder="Password" name="password">
            </div>
        </div>
        <div class="form-group mb-0">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" id="remember-me">
                <label class="custom-control-label" for="remember-me">Remember Me</label>
            </div>
        </div>
    </form>

    <form class="modal-part" id="modal-cetak-pdf-part">
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun">
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
    </form>
    <form class="modal-part" id="modal-cetak-excel-part">
        <div class="form-group">
            <label for="tahun">Tahun</label>
            <select name="tahun" id="tahun">
                <option value="2020">2020</option>
                <option value="2021">2021</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
    </form>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    {{-- <script src="{{ asset('library/prismjs/prism.js') }}"></script> --}}
    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/bootstrap-modal.js') }}"></script> --}}
    <script type="text/javascript">
        $(document).ready(function() {

            var table = $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('magang.index') }}", // Ubah route ke route yang sesuai dengan data mahasiswa
                columns: [{
                        data: 'no_induk',
                        name: 'no_induk'
                    },
                    // {data: 'id', name: 'id'},
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'no_telp',
                        name: 'no_telp'
                    },
                    // {data: 'jurusan', name: 'jurusan'},
                    {
                        data: 'bidang_diambil',
                        name: 'bidang_diambil'
                    },
                    {
                        data: 'surat_pengantar',
                        name: 'surat_pengantar'
                    },
                    // {data: 'tanggal_awal_magang', name: 'tanggal_awal_magang'},
                    // {data: 'tanggal_akhir_magang', name: 'tanggal_akhir_magang'},
                    // {data: 'approve_magang', name: 'approve_magang'},
                    // {data: 'nilai_magang', name: 'nilai_magang'},
                    // {data: 'updated_at', name: 'updated_at'},
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
    {{-- modals --}}
    <script text="text/javascript">
        $("#modal-cetak-pdf").fireModal({
            title: 'Cetak PDF',
            body: $("#modal-cetak-pdf-part"),
            footerClass: 'bg-whitesmoke',
            autoFocus: false,
            onFormSubmit: function(modal, e, form) {
                e.preventDefault(); // Mencegah submit form default

                let form_data = $(e.target).serialize(); // Ambil data form

                $.ajax({
                    url: "{{ route('export-dompdf') }}", // Route yang akan menangani download PDF
                    type: "GET",
                    data: form_data,
                    xhrFields: {
                        responseType: 'blob' // Mengatur response sebagai blob
                    },
                    beforeSend: function() {
                        form.startProgress(); // Menampilkan loading state
                    },
                    success: function(response) {
                        form.stopProgress(); // Menghentikan loading state

                        // Buat URL untuk blob
                        let blob = new Blob([response], {
                            type: "application/pdf"
                        });
                        let link = document.createElement("a");
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "Laporan_Pendaftaran.pdf";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        modal.modal("hide"); // Tutup modal setelah selesai
                    },
                    error: function(xhr) {
                        form.stopProgress();
                        console.error(xhr);
                        alert("Terjadi kesalahan saat mendownload file PDF.");
                    }
                });
            },
            shown: function(modal, form) {
                console.log(form);
            },
            buttons: [{
                text: 'Cetak',
                submit: true,
                class: 'btn btn-primary btn-shadow',
                handler: function(modal) {}
            }]
        });

        $("#modal-cetak-excel").fireModal({
            title: 'Cetak PDF',
            body: $("#modal-cetak-excel-part"),
            footerClass: 'bg-whitesmoke',
            autoFocus: false,
            onFormSubmit: function(modal, e, form) {
                e.preventDefault(); // Mencegah submit form default

                let form_data = $(e.target).serialize(); // Ambil data form

                $.ajax({
                    url: "{{ route('export-excel') }}", // Route yang akan menangani download PDF
                    type: "GET",
                    data: form_data,
                    xhrFields: {
                        responseType: 'blob' // Mengatur response sebagai blob
                    },
                    beforeSend: function() {
                        form.startProgress(); // Menampilkan loading state
                    },
                    success: function(response) {
                        form.stopProgress(); // Menghentikan loading state

                        // Buat URL untuk blob
                        let blob = new Blob([response], {
                            type: "application/excel"
                        });
                        let link = document.createElement("a");
                        link.href = window.URL.createObjectURL(blob);
                        link.download = "Laporan_Pendaftaran.xlsx";
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);

                        modal.modal("hide"); // Tutup modal setelah selesai
                    },
                    error: function(xhr) {
                        form.stopProgress();
                        console.error(xhr);
                        alert("Terjadi kesalahan saat mendownload file Excel.");
                    }
                });
            },
            shown: function(modal, form) {
                console.log(form);
            },
            buttons: [{
                text: 'Cetak',
                submit: true,
                class: 'btn btn-primary btn-shadow',
                handler: function(modal) {}
            }]
        });
    </script>
@endpush
