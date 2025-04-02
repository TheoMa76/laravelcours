<x-admin-layout>
    @section('content')
            <h2 class="text-2xl font-bold text-[var(--primary-black)] mb-6">Tableau de bord administratif</h2>
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Users Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Utilisateurs</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $userCount }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-[var(--primary-green)] text-sm font-medium">+{{ $usersCreatedThisPeriod }}</span>
                        <span class="text-[var(--primary-gray)] text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                    </div>
                </div>

                <!-- Projects Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green-dark)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Projets</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $projectCount }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-[var(--primary-green-dark)] text-sm font-medium">+{{ $projectsCreatedThisPeriod }}</span>
                        <span class="text-[var(--primary-gray)] text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                    </div>
                </div>

                <!-- Contributions Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Contributions</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $contributionCount }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <span class="text-[var(--primary-green)] text-sm font-medium">+{{ $contributionsCreatedThisPeriod }}</span>
                        <span class="text-[var(--primary-gray)] text-xs ml-1">{{ request()->has('weeklyStats') ? 'cette semaine' : 'ce mois' }}</span>
                    </div>
                </div>

                <!-- Pending Projects Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Projets en attente</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $pendingProjects }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('admin.projects.index') }}" class="text-[var(--primary-green)] text-sm font-medium hover:underline">Voir les projets</a>
                    </div>
                </div>
            </div>

            <!-- Time Period Toggle -->
            <div class="flex justify-end mb-4">
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <a href="?weeklyStats=true" class="{{ request()->has('weeklyStats') ? 'bg-[var(--primary-green)] text-white' : 'bg-white text-[var(--primary-gray)] hover:bg-[var(--primary-green-light)]' }} px-3 py-1 text-xs font-medium rounded-l-lg border border-[var(--primary-gray-light)] focus:z-10 focus:outline-none focus:ring-1 focus:ring-[var(--primary-green)] transition-colors">
                        Par semaine
                    </a>
                    <a href="?" class="{{ !request()->has('weeklyStats') ? 'bg-[var(--primary-green)] text-white' : 'bg-white text-[var(--primary-gray)] hover:bg-[var(--primary-green-light)]' }} px-3 py-1 text-xs font-medium rounded-r-lg border border-[var(--primary-gray-light)] focus:z-10 focus:outline-none focus:ring-1 focus:ring-[var(--primary-green)] transition-colors">
                        Par mois
                    </a>
                </div>
            </div>

            <!-- Charts Section - Structure originale préservée -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <!-- Users Chart -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Évolution des utilisateurs</h3>
                    <div id="usersChart" class="h-64" 
                        data-labels='@json($labels)'
                        data-values='@json($usersData ?? [])'></div>
                </div>
        
                <!-- Projects Chart -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Évolution des projets</h3>
                    <div id="projectsChart" class="h-64"
                        data-labels='@json($labels)'
                        data-values='@json($projectsData ?? [])'></div>
                </div>
        
                <!-- Contributions Chart -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Répartition des contributions</h3>
                    <div id="contributionsChart" 
                        data-values="{{ json_encode($contributionsData) }}"
                        data-financial-total="{{ number_format($financialContributionsTotal, 2, '.', ' ') }}">
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.contributions.index') }}" class="inline-flex items-center px-4 py-2 bg-[var(--primary-green-dark)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--primary-green)] active:bg-[var(--primary-green)] focus:outline-none focus:border-[var(--primary-green-dark)] focus:ring ring-[var(--primary-green-light)] disabled:opacity-25 transition ease-in-out duration-150">
                            Voir les détails
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Activité récente</h3>
                    <div class="space-y-3">
                        <div class="flex items-start">
                            <div class="bg-[var(--primary-green-light)] p-1.5 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary-green)]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-[var(--primary-black)]">Nouvel utilisateur inscrit</p>
                                <p class="text-xs text-[var(--primary-gray)]">{{ $lastUserCreated }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[var(--primary-green-light)] p-1.5 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary-green-dark)]" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-[var(--primary-black)]">Nouveau projet créé</p>
                                <p class="text-xs text-[var(--primary-gray)]">{{ $lastProjectCreated }}</p>
                            </div>
                        </div>
                        <div class="flex items-start">
                            <div class="bg-[var(--primary-green-light)] p-1.5 rounded-full mr-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary-green)]" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-[var(--primary-black)]">Nouvelle contribution</p>
                                <p class="text-xs text-[var(--primary-gray)]">{{ $lastContributionCreated }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
</x-admin-layout>

<!-- charts -->
@vite(['resources/js/admin-dashboard-charts.js'])

