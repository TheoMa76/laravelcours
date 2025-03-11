<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projets Écologiques en Normandie</title>
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
<body class="bg-gray-100">
    @include('layouts.navigation')

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Projets Écologiques à Soutenir en Normandie</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Carte Projet 1 -->
            <div class="project-card relative bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/borne recyclage.webp') }}" alt="Projet Recyclage en Normandie" class="w-full">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">Projet Recyclage en Normandie</h2>
                    <p class="text-gray-600 mb-4 description">Aidez-nous à mettre en place des bornes de recyclage dans les villes de Normandie. Ce projet vise à réduire les déchets et promouvoir le recyclage au niveau local.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-blue-500">Donateurs</span>
                            <span class="text-sm font-bold">120</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-green-500">Argent Collecté</span>
                            <span class="text-sm font-bold">€8,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-purple-500">Objectif</span>
                            <span class="text-sm font-bold">€20,000</span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 bg-white bg-opacity-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:bg-opacity-90 transition-opacity duration-300">
                    <span class="text-lg font-semibold text-gray-800">Participer</span>
                </div>
            </div>

            <!-- Carte Projet 2 -->
            <div class="project-card relative bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/foret.webp') }}" alt="Projet Forêts Normandes" class="w-full">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">Projet Forêts Normandes</h2>
                    <p class="text-gray-600 mb-4 description">Ce projet vise à restaurer les forêts en Normandie en plantant 50,000 arbres et en protégeant la biodiversité locale. Ensemble, agissons pour l'environnement !</p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-blue-500">Donateurs</span>
                            <span class="text-sm font-bold">200</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-green-500">Argent Collecté</span>
                            <span class="text-sm font-bold">€15,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-purple-500">Objectif</span>
                            <span class="text-sm font-bold">€50,000</span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 bg-white bg-opacity-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:bg-opacity-90 transition-opacity duration-300">
                    <span class="text-lg font-semibold text-gray-800">Participer</span>
                </div>
            </div>

            <!-- Carte Projet 3 -->
            <div class="project-card relative bg-white rounded-lg shadow-lg overflow-hidden transform transition-transform duration-300 hover:scale-105">
                <img src="{{ asset('images/agriculteur.webp') }}" alt="Projet Agriculture Durable Normande" class="w-full">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">Projet Agriculture Durable</h2>
                    <p class="text-gray-600 mb-4 description">Soutenez l'agriculture durable en Normandie en finançant des fermes locales adoptant des pratiques éco-responsables, telles que la permaculture et l'agroforesterie.</p>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-sm text-blue-500">Donateurs</span>
                            <span class="text-sm font-bold">350</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-green-500">Argent Collecté</span>
                            <span class="text-sm font-bold">€25,000</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-purple-500">Objectif</span>
                            <span class="text-sm font-bold">€75,000</span>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-0 bg-white bg-opacity-0 flex items-center justify-center opacity-0 hover:opacity-100 hover:bg-opacity-90 transition-opacity duration-300">
                    <span class="text-lg font-semibold text-gray-800">Participer</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.description').forEach(desc => {
            desc.addEventListener('click', () => {
                desc.classList.toggle('expanded');
            });
        });
    </script>
</body>
</html>
