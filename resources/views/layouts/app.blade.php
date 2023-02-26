{{-- 
|--------------------------------------------------------------------------
| App Layout
|--------------------------------------------------------------------------
|
| This is the main layout that will be used 
| for the mainly part of website.
|
 --}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title' , config('app.name', 'Laravel'))
    </title>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    
    @yield('links')
    
    <!-- Usando Vite -->
    @vite(['resources/js/app.js'])
    
    @yield('scripts')
</head>

<body>
    <div id="loadOverlay" style="background-color:#333; position:absolute; top:0px; left:0px; width:100vw; height:100vh; z-index:2;">
    </div>
    
    <div id="app">
        @include('partials.header')
        
        <main>
            @yield('content')
        </main>
    </div>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
</body>

</html>
