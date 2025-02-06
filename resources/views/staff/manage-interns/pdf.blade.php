<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- General CSS Files -->
    <link href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Data Pendaftar Magang</title>
    <style>
        body {
            max-width: fit-content;
        }

        table {
            border-collapse: collapse;
            margin-top: 10px;
        }

        table,
        td,
        th {
            border: 1px solid black;

        }

        td,
        th {
            padding: 8px 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Data Pendaftaran Magang</h3>

        <table class="table table-bordered mt-3" style="border: 1px solid black;">
            <thead>
                <tr>
                    <th> Nama</th>
                    <th> No Induk</th>
                    <th> No Telp</th>
                    <th> Jurusan</th>
                    <th> Institusi</th>
                    <th> Posisi</th>
                    <th> Tanggal Masuk</th>
                    <th>Tanggal Keluar</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bakhit</td>
                    <td>123456789</td>
                    <td>08123231312</td>
                    <td>Penggilingan Padi</td>
                    <td>Universitas Batu Duduk</td>
                    <td>Inti Bumi</td>
                    <td>12-12-2024</td>
                    <td>12-3-2025</td>
                </tr>
                <tr>
                    <td>Ridho Ohdir</td>
                    <td>123456789</td>
                    <td>08123231312</td>
                    <td>Penggilingan Gandum</td>
                    <td>Universitas Batu Duduk</td>
                    <td>Inti Atom</td>
                    <td>12-12-2024</td>
                    <td>12-3-2025</td>
                </tr>
                <tr>
                    <td>Fajaruddin</td>
                    <td>123456789</td>
                    <td>08123231312</td>
                    <td>Penggilingan Gemuk</td>
                    <td>Universitas Batu Duduk</td>
                    <td>Inti Sepeda Motor</td>
                    <td>12-12-2024</td>
                    <td>12-3-2025</td>
                </tr>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->no_induk }}</td>
                        <td>{{ $data->no_telp }}</td>
                        <td>{{ $data->jurusan }}</td>
                        <td>{{ $data->asal_institusi }}</td>
                        <td>{{ $data->bidang_diambil }}</td>
                        <td>{{ $data->tanggal_awal_magang }}</td>
                        <td>{{ $data->tanggal_akhir_magang }}</td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
