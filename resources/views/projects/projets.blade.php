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
        }
        .project-card img {
            height: 200px;
            object-fit: cover;
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
    </style>
</head>
<body class="bg-[var(--primary-gray-light)]">
    @include('layouts.navigation')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Projets écologiques à soutenir en Normandie</h1>

        @if($projets->isEmpty())
            <p class="text-center text-[var(--primary-gray)]">Aucun projet n'est en cours dans la région.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projets as $projet)
                    <div class="project-card relative bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                        <img src="{{ asset('images/' . $projet->image) }}" alt="{{ $projet->name }}" class="w-full">
                        <div class="p-6">
                            <!-- Nom du projet -->
                            <h2 class="text-xl font-semibold mb-2">{{ $projet->name }}</h2>

                            <!-- Dates et utilisateur -->
                            <div class="flex justify-between items-center mb-4">
                                <!-- Dates -->
                                <span class="text-sm text-[var(--primary-gray)]">
                                    {{ \Carbon\Carbon::parse($projet->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($projet->end_date)->format('d/m/Y') }}
                                </span>
                                <!-- Utilisateur -->
                                <span class="text-sm text-[var(--primary-gray)]">Créé par <span class="font-bold">{{ $projet->user->name }}</span></span>
                            </div>

                            <!-- Description -->
                            <p class="text-[var(--primary-gray)] mb-4 description">{{ $projet->description }}</p>

                            <!-- Informations supplémentaires -->
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm text-blue-500">Donateurs</span>
                                    <span class="text-sm font-bold">{{ $projet->contributions->count() }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-[var(--primary-green)]">Argent Collecté</span>
                                    <span class="text-sm font-bold">€{{ $projet->contributions->sum('amount') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-purple-500">Objectif</span>
                                    <span class="text-sm font-bold">€{{ $projet->goal }}</span>
                                </div>
                            </div>
                        </div>
                        <!-- Lien pour participer -->
                        <a href="{{ route('projets.contribute', $projet->id) }}" class="absolute inset-0 bg-white bg-opacity-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:bg-opacity-90 transition-opacity duration-300">
                            <span class="text-lg font-semibold text-[var(--primary-black)]">Participer</span>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Bouton "Devenez pionnier" -->
        <div class="text-center mt-8">
            <a href="{{ route('projets.create') }}" class="bg-[var(--primary-green)] text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-[var(--primary-green-dark)] transition-colors duration-300">Devenez pionnier</a>
        </div>
    </div>

    <!-- Script pour étendre la description -->
    <script>
        document.querySelectorAll('.description').forEach(desc => {
            desc.addEventListener('click', () => {
                desc.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>