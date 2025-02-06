<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">
    <title>Document</title>
    <style>
        body{
            padding: 10px 20px;
        }
    </style>
</head>

<body>
    <div>
        <h3>Data {{ $data->user->name }}</h3>
        <p>Tanggal Mendaftar: {{ $data->created_at->format('d-M-Y') }}</p>
        <ul>
            <li>
                No Induk: {{ $data->no_induk }}
            </li>
            <li>
                No Telepon: {{ $data->no_telp }}
            </li>
            <li>
                Asal Institusi: {{ $data->asal_institusi }}
            </li>
            <li>
                Jurusan: {{ $data->jurusan }}
            </li>
            <li>
                Bidang Diambil: {{ $data->bidang_diambil }}
            </li>
            <li>
                Tanggal awal magang: {{ $data->tanggal_awal_magang->format('d-M-Y') }}
            </li>
            <li>
                Tanggal awal magang: {{ $data->tanggal_akhir_magang->format('d-M-Y') }}
            </li>
        </ul>
    </div>
</body>

</html>
