<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <!-- resources/views/api/index.blade.php -->
<h1>Data dari API</h1>
<ul>
    <li>Nama: {{ $data['full_name'] }}</li>
    <li>Email: {{ $data['no_ktp'] }}</li>
    <!-- Dan informasi lainnya -->
</ul>


</body>
</html>