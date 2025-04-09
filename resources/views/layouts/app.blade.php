<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @yield('css')

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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

<body>
    <div class="bg-primary" style="height: 9.3vh;">
        <!-- @include('layouts.header') -->
    </div>

    <div class="d-flex flex-column flex-lg-row m-0 my-body w-100" style="height: 90.7vh;">
        <div class="sidebar-container p-0 bg-light" style="width: 18%;">
            @include('layouts.sidebar')
        </div>
        <div class="content-container px-5 py-3" style="width: 82%; height: 100%;">
            @yield('content')
        </div>
    </div>

    @yield('customeJs')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Search Filter -->
    <script src="{{asset('/assets/js/searchFilter.js')}}"></script>

</body>

</html>