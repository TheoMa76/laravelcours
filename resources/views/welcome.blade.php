<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GreenPot</title>


        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @endif
    </head>
    <body>
        <div class=" flex p-6 lg:p-8 items-center min-h-screen flex-col">
            <div class="fixed top-0 left-0 w-full shadow-md p-4 lg:px-8 z-50 ">
                    <nav class="flex items-center justify-between w-full max-w-6xl mx-auto">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <img src="{{ asset('images/greenPot.png') }}" alt="Logo" class="w-8 h-8" />
                        <span class="text-lg font-bold">GreenPot</span>
                    </a>
                        @if (Route::has('login'))
                            <div class="ml-auto flex items-center gap-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-md shadow">
                                        Mon compte
                                    </a>
                                @else
                                    <a href="{{ route('login') }}" class="px-5 py-2 border rounded-md shadow">
                                        Se connecter
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="px-5 py-2">
                                            S'enregistrer
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </nav>
                </div>

            <main class="mt-20 flex flex-col items-center w-full">
                @if (Route::has('login'))
                    <div class="h-14 hidden lg:block"></div>
                @endif
            </main>
        </div>
    </body>
</html>
