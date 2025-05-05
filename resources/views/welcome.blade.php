<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles / Scripts -->
       
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        <header class="w-full lg:max-w-4xl max-w-[335px] text-sm mb-6 not-has-[nav]:hidden">
            
            @if (Route::has('login'))
            <nav class="flex items-center justify-between gap-4 px-4 py-2 bg-gray-800">
    <!-- Title on the Left Side -->
    <h6 class="text-white text-2xl font-bold tracking-wide drop-shadow-md">SRI VINAYAGA EARTH MOVERS</h6>

    <!-- Authentication Links on the Right Side -->
    <div class="flex items-center gap-4">
        @auth
            <a
                href="{{ url('/dashboard') }}"
                class="inline-block px-5 py-1.5 text-white bg-blue-600 hover:bg-blue-700 rounded-sm text-sm leading-normal transition"
            >
                Dashboard
            </a>
        @else
            <a
                href="{{ route('login') }}"
                class="inline-block px-5 py-1.5 text-white bg-green-600 hover:bg-green-700 rounded-sm text-sm leading-normal transition"
            >
                Log in
            </a>
        @endauth
    </div>
</nav>



            @endif
        </header>
        <div class="flex items-center justify-center w-full transition-opacity opacity-100 duration-750 lg:grow starting:opacity-0">
        <img src="{{ asset('assets/img/main.jpeg') }}" alt="Custom Logo" class="h-40.1 w-auto"> 
        </div>
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
