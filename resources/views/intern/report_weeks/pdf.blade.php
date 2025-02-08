<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Data Laporan</title>
    <style>
        body {
            max-width: fit-content;
        }

        table {
            border-collapse: collapse;
            margin-top: 10px;
            width: 80%;
        }

        table,
        td,
        th {
            border: 1px solid black;

        }

        td,
        th {
            padding: 5px 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3>Laporan Magang</h3>

        <table class="table mt-3" >
            <thead>
                <tr>
                    <th style="width: 20%;"> Tanggal dibuat</th>
                    <th style="width: 30%;"> Foto</th>
                    <th style="width: 50%;"> Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $data->created_at->format('d-M-Y') }}</td>
                        <td><img src="{{ $data->foto }}"
                                style="width: 100px;object-fit: center;" alt=""></td>
                        <td>{!! $data->deskripsi !!}</td>
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
