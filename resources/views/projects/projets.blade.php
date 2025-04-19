<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets écologiques en Normandie</title>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/admin-dashboard.js',user-dashboard.js'])
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
        
        /* Conteneur d'image amélioré */
        .image-container {
            height: 200px;
            width: auto;
            overflow: hidden;
            position: relative;
            background-color: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .image-container img {
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: auto;
            object-fit: contain;
            transition: transform 0.3s ease;
        }
        
        .project-card:hover .image-container img {
            transform: scale(1.03);
        }
        
        /* Contenu de la carte */
        .card-content {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        
        /* Alignement du texte */
        .description-container {
            flex: 1;
            min-height: 60px; /* Hauteur minimale pour aligner */
        }
        
        .description {
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            cursor: pointer;
        }
        
        .description.expanded {
            -webkit-line-clamp: unset;
        }
        
        /* Barre de progression */
        .progress-bar {
            height: 8px;
            border-radius: 9999px;
            background-color: #d5d5d5;
            overflow: hidden;
            margin: 0.5rem 0;
        }
        
        .progress-value {
            height: 100%;
            border-radius: 9999px;
        }
        
        /* Statistiques */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0.5rem;
            margin: 1rem 0;
        }
        
        .stat-item {
            background-color: #f8f8f8;
            border-radius: 0.5rem;
            padding: 0.75rem;
            text-align: center;
        }
        
        /* Bouton en bas de carte */
        .card-button {
            margin-top: auto;
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
                            <div class="image-container">
                                <img src="{{ asset('images/' . $projet->image) }}" alt="{{ $projet->name }}" 
                                     style="max-width: {{ $projet->image_width > $projet->image_height ? '100%' : 'auto' }}; 
                                            max-height: {{ $projet->image_width > $projet->image_height ? 'auto' : '100%' }}">
                                <div class="absolute top-3 right-3 bg-white bg-opacity-90 px-3 py-1 rounded-full text-xs font-medium text-[var(--primary-red)]">
                                    <span>Fin estimée {{ \Carbon\Carbon::parse($projet->end_date)->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <div class="card-content">
                                <h2 class="text-xl font-bold text-[var(--primary-black)] mb-2">{{ $projet->name }}</h2>
                                
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-sm text-[var(--primary-gray)]">
                                        {{ \Carbon\Carbon::parse($projet->start_date)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($projet->end_date)->format('d/m/Y') }}
                                    </span>
                                    <span class="text-sm text-[var(--primary-gray)]">Par <span class="font-medium text-[var(--primary-green-dark)]">{{ $projet->user->name }}</span></span>
                                </div>
                                
                                <div class="description-container">
                                    <p class="text-[var(--primary-gray-dark)] description">{{ $projet->description }}</p>
                                </div>
                                
                                @php
                                    $percentage = $projet->money_goal > 0 ? min(100, ($projet->contributions->sum('amount') / $projet->money_goal) * 100) : 0;
                                    $progressColor = $percentage < 25 ? 'var(--primary-green-superlight)' : 
                                                    ($percentage < 50 ? 'var(--primary-green-light)' : 
                                                    ($percentage < 75 ? 'var(--primary-green)' : 'var(--primary-green-dark)'));
                                @endphp
                                
                                <div class="progress-bar">
                                    <div class="progress-value" style="width: {{ $percentage }}%; background-color: {{ $progressColor }};"></div>
                                </div>
                                
                                <div class="flex justify-between text-sm mb-3">
                                    <span class="font-medium text-[var(--primary-green-dark)]">{{ number_format($projet->contributions->sum('amount'), 0, ',', ' ') }} €</span>
                                    <span class="text-[var(--primary-gray)]">Objectif: {{ number_format($projet->money_goal, 0, ',', ' ') }} €</span>
                                </div>

                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <span class="block text-sm text-[var(--primary-gray)]">Donateurs</span>
                                        <span class="block text-lg font-bold text-[var(--primary-black)]">{{ $projet->contributions->count() }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <span class="block text-sm text-[var(--primary-gray)]">Jours restants</span>
                                        <span class="block text-lg font-bold text-[var(--primary-black)]">{{ intval(\Carbon\Carbon::now()->diffInDays($projet->end_date)) }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('projets.contribute', $projet->id) }}" class="card-button block w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 text-center">
                                    Participer au projet
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.description').forEach(desc => {
                desc.addEventListener('click', () => {
                    desc.classList.toggle('expanded');
                    // Ajuster la hauteur du conteneur parent si nécessaire
                    const container = desc.closest('.description-container');
                    if (desc.classList.contains('expanded')) {
                        container.style.minHeight = 'auto';
                    } else {
                        container.style.minHeight = '60px';
                    }
                });
            });
        });
    </script>
</body>
</html>