<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets écologiques en Normandie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .project-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .project-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .project-card img {
            height: 200px;
            object-fit: cover;
            border-top-left-radius: 0.75rem;
            border-top-right-radius: 0.75rem;
        }
        .project-card .description {
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
        }
        .project-card .description.expanded {
            -webkit-line-clamp: unset;
        }
        .progress-bar {
            height: 8px;
            border-radius: 9999px;
            background-color: #f3f4f6;
            overflow: hidden;
        }
        .progress-value {
            height: 100%;
            border-radius: 9999px;
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    @include('layouts.navigation')

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-7xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 mb-8 border border-gray-100">
                <h1 class="text-3xl font-bold text-center text-[var(--primary-green-dark)] mb-2">Projets écologiques à soutenir en Normandie</h1>
                <p class="text-center text-[var(--primary-green)] mb-0">Découvrez les initiatives locales qui font la différence</p>
            </div>

            @if($projets->isEmpty())
                <div class="bg-white rounded-xl shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-xl text-[var(--primary-gray)]">Aucun projet n'est en cours dans la région.</p>
                    <p class="text-[var(--primary-gray-light)] mt-2">Revenez bientôt pour découvrir de nouvelles initiatives.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projets as $projet)
                        <div class="project-card bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="relative">
                                <img src="{{ asset('images/' . $projet->image) }}" alt="{{ $projet->name }}" class="w-full">
                                <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-xs font-medium text-[var(--primary-red)]">
                                    <span>Fin estimée {{ \Carbon\Carbon::parse($projet->end_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <!-- Nom du projet -->
                                <h2 class="text-xl font-bold text-[var(--primary-black)] mb-2">{{ $projet->name }}</h2>

                                <!-- Dates et utilisateur -->
                                <div class="flex justify-between items-center mb-4">
                                    <!-- Dates -->
                                    <span class="text-sm text-[var(--primary-gray)]">
                                        {{ \Carbon\Carbon::parse($projet->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($projet->end_date)->format('d/m/Y') }}
                                    </span>
                                    <!-- Utilisateur -->
                                    <span class="text-sm text-[var(--primary-gray)]">Par <span class="font-medium text-[var(--primary-green-dark)]">{{ $projet->user->name }}</span></span>
                                </div>

                                <!-- Description -->
                                <p class="text-[var(--primary-gray-dark)] mb-4 description">{{ $projet->description }}</p>

                                <!-- Barre de progression -->
                                @php
                                    $percentage = $projet->goal > 0 ? min(100, ($projet->contributions->sum('amount') / $projet->goal) * 100) : 0;
                                    $progressColor = $percentage < 25 ? 'var(--primary-green-superlight)' : 
                                                    ($percentage < 50 ? 'var(--primary-green-light)' : 
                                                    ($percentage < 75 ? 'var(--primary-green)' : 'var(--primary-green-dark)'));
                                @endphp
                                <div class="progress-bar mb-2">
                                    <div class="progress-value" style="width: {{ $percentage }}%; background-color: {{ $progressColor }};"></div>
                                </div>

                                <!-- Informations de financement -->
                                <div class="flex justify-between text-sm mb-4">
                                    <span class="font-medium text-[var(--primary-green-dark)]">{{ number_format($projet->contributions->sum('amount'), 0, ',', ' ') }} €</span>
                                    <span class="text-[var(--primary-gray)]">Objectif: {{ number_format($projet->goal, 0, ',', ' ') }} €</span>
                                </div>

                                <!-- Statistiques du projet -->
                                <div class="grid grid-cols-2 gap-2 mb-4">
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <span class="block text-sm text-[var(--primary-gray)]">Donateurs</span>
                                        <span class="block text-lg font-bold text-[var(--primary-black)]">{{ $projet->contributions->count() }}</span>
                                    </div>
                                    <div class="bg-gray-50 rounded-lg p-3 text-center">
                                        <span class="block text-sm text-[var(--primary-gray)]">Jours restants</span>
                                        <span class="block text-lg font-bold text-[var(--primary-black)]">{{ \Carbon\Carbon::now()->diffInDays($projet->end_date) }}</span>
                                    </div>
                                </div>

                                <!-- Bouton participer -->
                                <a href="{{ route('projets.contribute', $projet->id) }}" class="block w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 text-center">
                                    Participer au projet
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Bouton "Devenez pionnier" -->
            <div class="text-center mt-12">
                <a href="{{ route('projets.create') }}" class="inline-flex items-center bg-[var(--primary-green)] text-white px-8 py-4 rounded-xl text-lg font-semibold hover:bg-[var(--primary-green-dark)] transition-colors duration-300 shadow-md hover:shadow-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Devenez pionnier
                </a>
                <p class="text-[var(--primary-gray)] mt-3">Lancez votre propre projet écologique et faites la différence</p>
            </div>
        </div>
    </div>

    <!-- Script pour étendre la description -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.description').forEach(desc => {
                desc.addEventListener('click', () => {
                    desc.classList.toggle('expanded');
                });
            });
        });
    </script>
</body>
</html>