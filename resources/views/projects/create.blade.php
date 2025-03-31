<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un Projet</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- Assurez-vous d'avoir Tailwind ou un autre CSS -->
</head>
<body class="bg-gray-100">
    @include('layouts.navigation') <!-- Inclusion du layout de navigation -->

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg p-6">
            <h1 class="text-3xl font-bold text-center mb-6">Votre projet écologique</h1>

            <!-- Formulaire de création de projet -->
            <form action="{{ route('projets.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf <!-- Protection CSRF -->

                <!-- Nom du projet -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du projet</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm"
                           placeholder="Ex: Recyclage en Normandie">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Image du projet</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Description du projet -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" required
                              class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm"
                              placeholder="Décrivez votre projet en détail..."></textarea>
                </div>

                <!-- Statut du projet -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                    <select name="status" id="status" required
                            class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                        <option value="en_attente">En attente</option>
                        <option value="en_cours">En cours</option>
                    </select>
                </div>

                <!-- Date de début -->
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Date de début</label>
                    <input type="date" name="start_date" id="start_date" required
                           class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Objectif financier -->
                <div>
                    <label for="goal" class="block text-sm font-medium text-gray-700">Objectif financier (€)</label>
                    <input type="number" name="goal" id="goal" step="0.01" required
                           class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm"
                           placeholder="Ex: 10000">
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Date de fin</label>
                    <input type="date" name="end_date" id="end_date" required
                           class="mt-1 block w-full form-input rounded-md border-gray-300 shadow-sm">
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Bouton de soumission -->
                <div class="text-center">
                    <button type="submit"
                    class="bg-green-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-green-600 transition-colors duration-300">
                        Donnez vie à votre projet
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>