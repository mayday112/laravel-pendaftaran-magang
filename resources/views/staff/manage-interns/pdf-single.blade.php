<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
                
            </li>
        </ul>
    </div>
</body>

</html>
