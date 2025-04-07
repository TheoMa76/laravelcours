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
        <div class="flex p-6 lg:p-8 items-center min-h-screen flex-col">
            <div class="fixed top-0 left-0 w-full shadow-md p-4 lg:px-8 z-50 bg-white mb-10">
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

            <main class="mt-20 flex flex-col items-center w-full max-w-6xl mx-auto">
                @if (Route::has('login'))
                    <div class="h-14 hidden lg:block"></div>
                @endif
                
                <!-- Projects Section -->
                <section class="w-full py-8">
                    <h2 class="text-2xl font-bold mb-6 text-center">Nos Projets</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse ($projects as $project)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200 transition-all hover:shadow-lg">
                                @if (isset($project->imagePath))
                                    <div class="h-48 overflow-hidden">
                                        <img src="{{ $project->imagePath }}" alt="{{ $project->name }}" class="w-full h-full object-cover">
                                    </div>
                                @endif
                                
                                <div class="p-4">
                                    <h3 class="text-lg font-semibold mb-2">{{ $project->name }}</h3>
                                    
                                    @if (isset($project->description))
                                        <p class="text-gray-600 mb-4">{{ Str::limit($project->description, 100) }}</p>
                                    @endif
                                    
                                    @if (isset($project->created_at))
                                        <div class="text-sm text-gray-500 mb-3">
                                            {{ $project->created_at->format('d/m/Y') }}
                                        </div>
                                    @endif
                                    
                                   
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-500">Aucun projet disponible pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                </section>
            </main>
        </div>
    </body>
</html>