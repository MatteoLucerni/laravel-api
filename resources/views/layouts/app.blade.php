<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css'
        integrity='sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=='
        crossorigin='anonymous' />

    @yield('cdns')

    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
</head>

<style>
    body {
        display: none
    }
</style>

<body>
    <div id="app">


        @include('includes.navbar')

        <main class="container mt-3">
            @yield('content')
        </main>
    </div>

    {{-- @include('includes.toasts') --}}

    @yield('scripts')
</body>

</html>
