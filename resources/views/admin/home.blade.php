<x-app-layout>
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Tableau de bord administratif</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Users Card -->
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-green-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Utilisateurs</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $userCount }}</h3>
                    </div>
                    <div class="bg-green-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-green-500 text-sm font-medium">+{{ $usersCreatedThisPeriod }}</span>
                    <span class="text-gray-500 text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                </div>
            </div>

            <!-- Projects Card -->
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-teal-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Projets</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $projectCount }}</h3>
                    </div>
                    <div class="bg-teal-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-teal-500 text-sm font-medium">+{{ $projectsCreatedThisPeriod }}</span>
                    <span class="text-gray-500 text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                </div>
            </div>

            <!-- Contributions Card -->
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-emerald-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Contributions</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $contributionCount }}</h3>
                    </div>
                    <div class="bg-emerald-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <span class="text-emerald-500 text-sm font-medium">+{{ $contributionsCreatedThisPeriod }}</span>
                    <span class="text-gray-500 text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                </div>
            </div>

            <!-- Pending Projects Card -->
            <div class="bg-white rounded-lg shadow p-4 border-l-4 border-amber-500">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Projets en attente</p>
                        <h3 class="text-xl font-bold text-gray-800">{{ $pendingProjects }}</h3>
                    </div>
                    <div class="bg-amber-100 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-2">
                    <a href="{{ route('admin.projects.index') }}" class="text-amber-500 text-sm font-medium hover:underline">Voir les projets</a>
                </div>
            </div>
        </div>

        <!-- Time Period Toggle -->
        <div class="flex justify-end mb-4">
            <div class="inline-flex rounded-md shadow-sm" role="group">
                <a href="?weeklyStats=true" class="{{ request()->has('weeklyStats') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-3 py-1 text-xs font-medium rounded-l-lg border border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 transition-colors">
                    Par semaine
                </a>
                <a href="?" class="{{ !request()->has('weeklyStats') ? 'bg-green-500 text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }} px-3 py-1 text-xs font-medium rounded-r-lg border border-gray-200 focus:z-10 focus:outline-none focus:ring-1 focus:ring-green-500 transition-colors">
                    Par mois
                </a>
            </div>
        </div>

        <!-- Charts Section - Structure originale préservée -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Users Chart -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-2">Évolution des utilisateurs</h3>
                <div id="usersChart" class="h-64" 
                     data-labels='@json($labels)'
                     data-values='@json($usersData ?? [])'></div>
            </div>
    
            <!-- Projects Chart -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-2">Évolution des projets</h3>
                <div id="projectsChart" class="h-64"
                     data-labels='@json($labels)'
                     data-values='@json($projectsData ?? [])'></div>
            </div>
    
            <!-- Contributions Chart -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-2">Répartition des contributions</h3>
                <div id="contributionsChart" 
                    data-values="{{ json_encode($contributionsData) }}"
                    data-financial-total="{{ number_format($financialContributionsTotal, 2, '.', ' ') }}">
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-600 active:bg-green-500 focus:outline-none focus:border-green-800 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                        Voir les détails
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-gray-800 mb-2">Activité récente</h3>
                <div class="space-y-3">
                    <div class="flex items-start">
                        <div class="bg-green-100 p-1.5 rounded-full mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-800">Nouvel utilisateur inscrit</p>
                            <p class="text-xs text-gray-500">{{ $lastUserCreated }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-teal-100 p-1.5 rounded-full mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-teal-500" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-800">Nouveau projet créé</p>
                            <p class="text-xs text-gray-500">{{ $lastProjectCreated }}</p>
                        </div>
                    </div>
                    <div class="flex items-start">
                        <div class="bg-emerald-100 p-1.5 rounded-full mr-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-500" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-800">Nouvelle contribution</p>
                            <p class="text-xs text-gray-500">{{ $lastContributionCreated }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- charts -->
@vite(['resources/js/admin-dashboard-charts.js'])

