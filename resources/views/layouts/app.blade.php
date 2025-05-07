<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}  @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
    @media (max-width: 992px) {
        .sidebar-container {
            width: 100% !important;
        }

        .content-container {
            width: 100% !important;
            padding: 15px !important;
        }
    }
    </style>
</head>

<body class="bg-light">
    <div class="">
        @include('layouts.header')
    </div>

    <div class="d-flex flex-column flex-lg-row m-0 my-body w-100" style="height: 90.7vh;">
        <div class="sidebar-container p-0 bg-light" style="width: 18%;">
            @include('layouts.sidebar')
        </div>
        <div class="content-container container-fluid p-5 m-1" style="width: 82%; height: 100%;">
            @yield('content')
        </div>
    </div>

    @yield('customeJs')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="{{asset('assets\js\active-side-menu.js')}}"></script>
    <!-- Search Filter -->
    <script src="{{asset('/assets/js/searchFilter.js')}}"></script>
</body>
</html>
