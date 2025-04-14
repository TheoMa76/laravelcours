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
        <!-- Navbar -->
        <header class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-white shadow-md py-2">
            <div class="container mx-auto px-4 flex items-center justify-between">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center">
                        <x-application-logo class="block h-9 w-auto text-[var(--primary-black)]" />
                    </div>
                    <span class="text-xl font-bold text-[var(--primary-black)]">GreenPot</span>
                </a>
                
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="#projects" class="text-[var(--primary-black)] hover:text-[var(--primary-green)] transition-colors">
                        Projets
                    </a>
                    <a href="#how-it-works" class="text-[var(--primary-black)] hover:text-[var(--primary-green)] transition-colors">
                        Comment ça marche
                    </a>
                    <a href="#about" class="text-[var(--primary-black)] hover:text-[var(--primary-green)] transition-colors">
                        À propos
                    </a>
                </nav>
                
                <div class="flex items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2 bg-[var(--primary-green)] text-white rounded-md hover:bg-[var(--primary-green-dark)] transition-colors">
                                Mon compte
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hidden md:block px-5 py-2 border border-[var(--primary-green)] text-[var(--primary-green)] rounded-md hover:bg-[var(--primary-green-superlight)] transition-colors">
                                Se connecter
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2 bg-[var(--primary-green)] text-white rounded-md hover:bg-[var(--primary-green-dark)] transition-colors">
                                    S'inscrire
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <section class="pt-32 pb-20 px-4 bg-gradient-to-b from-[var(--primary-green-superlight)] to-white">
            <div class="container mx-auto max-w-6xl">
                <div class="flex flex-col md:flex-row items-center gap-12">
                    <div class="flex-1 space-y-6">
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-[var(--primary-black)] leading-tight">
                            Soutenez des <span class="text-[var(--primary-green)]">projets écologiques</span> près de chez vous
                        </h1>
                        <p class="text-lg text-[var(--primary-gray-dark)] max-w-xl">
                            GreenPot vous permet de découvrir et soutenir des initiatives écologiques locales qui transforment votre communauté.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <a href="#projects" class="inline-flex items-center justify-center bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white px-8 py-4 rounded-md text-lg">
                                Découvrir les projets 
                                <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                            </a>
                            <a href="#how-it-works" class="inline-flex items-center justify-center border border-[var(--primary-green)] text-[var(--primary-green)] hover:bg-[var(--primary-green-superlight)] px-8 py-4 rounded-md text-lg">
                                Comment ça marche
                            </a>
                        </div>
                    </div>
                    <div class="flex-1 relative">
                        <div class="relative z-10 rounded-lg overflow-hidden shadow-xl">
                            <img 
                                src="{{ asset('images/foret.webp') }}" 
                                alt="Projet écologique communautaire" 
                                class="w-full h-auto object-cover"
                            />
                        </div>
                        <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[var(--primary-green-light)] rounded-full opacity-50 z-0"></div>
                        <div class="absolute -top-6 -left-6 w-24 h-24 bg-[var(--primary-green)] rounded-full opacity-30 z-0"></div>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-4 bg-white">
            <div class="container mx-auto max-w-6xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-[var(--primary-black)] mb-4">
                        Pourquoi choisir GreenPot ?
                    </h2>
                    <p class="text-[var(--primary-gray)] max-w-2xl mx-auto">
                        Notre plateforme facilite la connexion entre porteurs de projets écologiques et citoyens engagés.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-[var(--primary-gray-light)] p-8 rounded-xl transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-[var(--primary-green-superlight)] rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-[var(--primary-green)] w-7 h-7" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 20A7 7 0 0 1 9.8 6.1C15.5 5 17 4.48 19 2c1 2 2 4.18 2 8 0 5.5-4.78 10-10 10Z"/><path d="M2 21c0-3 1.85-5.36 5.08-6C9.5 14.52 12 13 13 12"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[var(--primary-black)] mb-3">Projets Locaux</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Découvrez et soutenez des initiatives écologiques dans votre région pour un impact direct sur votre environnement.
                        </p>
                    </div>
                    
                    <div class="bg-[var(--primary-gray-light)] p-8 rounded-xl transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-[var(--primary-green-superlight)] rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-[var(--primary-green)] w-7 h-7" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[var(--primary-black)] mb-3">Communauté Engagée</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Rejoignez une communauté de personnes partageant les mêmes valeurs et travaillant ensemble pour un avenir plus vert.
                        </p>
                    </div>
                    
                    <div class="bg-[var(--primary-gray-light)] p-8 rounded-xl transition-all hover:shadow-lg">
                        <div class="w-14 h-14 bg-[var(--primary-green-superlight)] rounded-full flex items-center justify-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="text-[var(--primary-green)] w-7 h-7" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-[var(--primary-black)] mb-3">Impact Mesurable</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Suivez la progression des projets et voyez l'impact concret de votre contribution sur l'environnement.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="projects" class="py-20 px-4 bg-[var(--primary-gray-light)]">
            <div class="container mx-auto max-w-6xl">
                <div class="flex flex-col md:flex-row justify-between items-center mb-12">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-[var(--primary-black)] mb-4">
                            Projets à soutenir
                        </h2>
                        <p class="text-[var(--primary-gray)] max-w-xl">
                            Découvrez les initiatives écologiques qui transforment nos communautés et ont besoin de votre soutien.
                        </p>
                    </div>
                    <a href="/projets" class="mt-6 md:mt-0 flex items-center text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] font-medium">
                        Voir tous les projets 
                        <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse ($projets as $project)
                        <div class="bg-white overflow-hidden rounded-lg shadow-md transition-all hover:shadow-lg">
                            <div class="relative h-52 overflow-hidden">
                                @if (isset($project->image))
                                    <img 
                                        src="{{ asset('images/' . $project->image) }}" 
                                        alt="{{ $project->name }}" 
                                        class="w-full h-full object-cover transition-transform hover:scale-105"
                                    />
                                @else
                                    <img 
                                        src="https://via.placeholder.com/500x300" 
                                        alt="{{ $project->name }}" 
                                        class="w-full h-full object-cover transition-transform hover:scale-105"
                                    />
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-4">
                                    @if (isset($project->created_at))
                                        <span class="text-white text-sm">
                                            {{ $project->created_at->format('d/m/Y') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-[var(--primary-black)] mb-2">{{ $project->name }}</h3>
                                
                                @if (isset($project->short_description))
                                    <p class="text-[var(--primary-gray)] mb-4">{{ Str::limit($project->short_description, 100) }}</p>
                                @endif
                                
                                @if (isset($project->progress))
                                    <div class="mb-4">
                                        <div class="flex justify-between text-sm mb-1">
                                            <span>Progression</span>
                                            <span class="font-medium">{{ $project->progress }}%</span>
                                        </div>
                                        <div class="w-full bg-[var(--primary-gray-light)] rounded-full h-2.5">
                                            <div 
                                                class="bg-[var(--primary-green)] h-2.5 rounded-full" 
                                                style="width: {{ $project->progress }}%"
                                            ></div>
                                        </div>
                                    </div>
                                @endif
                                
                                <a 
                                    href="{{ route('projets.show', $project->id) }}"
                                    class="inline-flex items-center text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] font-medium"
                                >
                                    Voir le projet 
                                    <svg xmlns="http://www.w3.org/2000/svg" class="ml-1 h-5 w-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full text-center py-12 bg-white rounded-lg">
                            <p class="text-[var(--primary-gray)]">Aucun projet disponible pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <section id="how-it-works" class="py-20 px-4 bg-white">
            <div class="container mx-auto max-w-6xl">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-[var(--primary-black)] mb-4">
                        Comment ça marche
                    </h2>
                    <p class="text-[var(--primary-gray)] max-w-2xl mx-auto">
                        Participer à GreenPot est simple et transparent. Voici comment vous pouvez contribuer.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[var(--primary-green-light)] rounded-full flex items-center justify-center mx-auto mb-6 relative">
                            <span class="text-[var(--primary-green-dark)] font-bold text-xl">1</span>
                            <div class="absolute w-16 h-1 bg-[var(--primary-green-light)] right-0 top-1/2 -translate-y-1/2 -z-10 hidden md:block"></div>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--primary-black)] mb-3">Inscrivez-vous</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Créez votre compte en quelques clics pour rejoindre notre communauté.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[var(--primary-green-light)] rounded-full flex items-center justify-center mx-auto mb-6 relative">
                            <span class="text-[var(--primary-green-dark)] font-bold text-xl">2</span>
                            <div class="absolute w-16 h-1 bg-[var(--primary-green-light)] right-0 top-1/2 -translate-y-1/2 -z-10 hidden md:block"></div>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--primary-black)] mb-3">Explorez les projets</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Découvrez des initiatives locales qui correspondent à vos valeurs.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[var(--primary-green-light)] rounded-full flex items-center justify-center mx-auto mb-6 relative">
                            <span class="text-[var(--primary-green-dark)] font-bold text-xl">3</span>
                            <div class="absolute w-16 h-1 bg-[var(--primary-green-light)] right-0 top-1/2 -translate-y-1/2 -z-10 hidden md:block"></div>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--primary-black)] mb-3">Soutenez un projet</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Contribuez financièrement ou proposez votre aide aux porteurs de projets.
                        </p>
                    </div>
                    
                    <div class="text-center">
                        <div class="w-16 h-16 bg-[var(--primary-green-light)] rounded-full flex items-center justify-center mx-auto mb-6">
                            <span class="text-[var(--primary-green-dark)] font-bold text-xl">4</span>
                        </div>
                        <h3 class="text-lg font-bold text-[var(--primary-black)] mb-3">Suivez l'impact</h3>
                        <p class="text-[var(--primary-gray-dark)]">
                            Recevez des mises à jour et voyez l'impact concret de votre contribution.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 px-4 bg-[var(--primary-green-superlight)]">
            <div class="container mx-auto max-w-6xl text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-[var(--primary-black)] mb-6">
                    Prêt à faire une différence ?
                </h2>
                <p class="text-[var(--primary-gray-dark)] max-w-2xl mx-auto mb-8">
                    Rejoignez notre communauté et commencez à soutenir des projets écologiques qui transforment votre région.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white px-8 py-4 rounded-md text-lg">
                            S'inscrire maintenant 
                            <svg xmlns="http://www.w3.org/2000/svg" class="ml-2 h-5 w-5" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </a>
                    @endif
                    <a href="#about" class="inline-flex items-center justify-center border border-[var(--primary-green)] text-[var(--primary-green)] hover:bg-white px-8 py-4 rounded-md text-lg">
                        En savoir plus
                    </a>
                </div>
            </div>
        </section>

        <footer class="bg-[var(--primary-black)] text-white py-16 px-4">
            <div class="container mx-auto max-w-6xl">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <div class="space-y-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center">
                                <x-application-logo class="block h-9 w-auto text-[var(--primary-black)]" />
                            </div>
                            <span class="text-xl font-bold">GreenPot</span>
                        </div>
                        <p class="text-gray-400">
                            Plateforme participative pour soutenir les projets écologiques locaux.
                        </p>
                        <div class="flex space-x-4 pt-2">
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"></path>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>