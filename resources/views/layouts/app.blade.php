<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('css')
</head>

<body>
    @include('layouts.header')

    <div class="row" style="height: 81vh; margin: 0px;">
        <div class="col-2 p-0">
            @include('layouts.sidebar')
        </div>
        <div class="col bg-danger p-0">
            @yield('content')
        </div>
    </div>

    @yield('customeJs')
</body>

</html>