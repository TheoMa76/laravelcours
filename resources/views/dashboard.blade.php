<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-[var(--primary-black)] leading-tight">
            {{ __('Tableau de bord') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
                <!-- Projects Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green-dark)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Mes Projets</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $userProjects->count() }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green-dark)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-2">
                        <a href="{{ route('projets') }}" class="text-[var(--primary-green-dark)] text-sm font-medium hover:underline">Voir mes projets</a>
                    </div>
                </div>

                <!-- Contributions Count Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Mes Contributions</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ $userContributionsCount }}</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                        </div>
                    </div>
                    {{-- <div class="mt-2">
                        <a href="{{ route('contributions') }}" class="text-[var(--primary-green)] text-sm font-medium hover:underline">Voir mes contributions</a>
                    </div> --}}
                </div>

                <!-- Contributions Total Card -->
                <div class="bg-white rounded-lg shadow p-4 border-l-4 border-[var(--primary-green)]">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm text-[var(--primary-gray)]">Total des contributions</p>
                            <h3 class="text-xl font-bold text-[var(--primary-black)]">{{ number_format($userContributionsTotal, 2, ',', ' ') }} €</h3>
                        </div>
                        <div class="bg-[var(--primary-green-light)] p-2 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[var(--primary-green)]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Projects Section -->
            <div class="bg-white p-4 rounded-lg shadow mb-6">
                <h3 class="text-md font-semibold text-[var(--primary-black)] mb-4">Mes projets</h3>
                
                @if($userProjects->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--primary-gray)] uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--primary-gray)] uppercase tracking-wider">Statut</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--primary-gray)] uppercase tracking-wider">Date de création</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-[var(--primary-gray)] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($userProjects as $project)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-[var(--primary-black)]">{{ $project->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if($project->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[var(--primary-green-light)] text-[var(--primary-green-dark)]">
                                                    En attente
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-[var(--primary-green)] text-white">
                                                    En cours
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-[var(--primary-gray)]">
                                            {{ $project->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <a href="{{ route('projets.contribute', $project) }}" class="text-[var(--primary-green-dark)] hover:text-[var(--primary-green)] mr-3">Voir</a>
                                            <a href="{{ route('projets.edit', $project) }}" class="text-[var(--primary-green-dark)] hover:text-[var(--primary-green)]">Modifier</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-[var(--primary-gray)]">Vous n'avez pas encore de projets.</p>
                    <div class="mt-4">
                        <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-[var(--primary-green-dark)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--primary-green)] active:bg-[var(--primary-green)] focus:outline-none focus:border-[var(--primary-green-dark)] focus:ring ring-[var(--primary-green-light)] disabled:opacity-25 transition ease-in-out duration-150">
                            Créer un projet
                        </a>
                    </div>
                @endif
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-6">
                <!-- Contributions Chart -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Mes contributions</h3>
                    <div id="contributionsChart" class="h-64" 
                        data-contributions='@json($userContributions)'></div>
                </div>
                
                <!-- Projects Status Chart -->
                <div class="bg-white p-4 rounded-lg shadow">
                    <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Statut de mes projets</h3>
                    <div id="projectsStatusChart" class="h-64"
                        data-projects='@json($userProjects)'></div>
                </div>
            </div>

            <!-- Recent Contributions -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h3 class="text-md font-semibold text-[var(--primary-black)] mb-2">Contributions récentes</h3>
                
                @if($userContributions->count() > 0)
                    <div class="space-y-3">
                        @foreach($userContributions->sortByDesc('created_at')->take(5) as $contribution)
                            <div class="flex items-start">
                                <div class="bg-[var(--primary-green-light)] p-1.5 rounded-full mr-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[var(--primary-green)]" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fillRule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clipRule="evenodd" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-[var(--primary-black)]">{{ number_format($contribution->amount, 2, ',', ' ') }} € - {{ $contribution->project->name ?? 'Projet inconnu' }}</p>
                                    <p class="text-xs text-[var(--primary-gray)]">{{ $contribution->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-center">
                        <a href="{{ route('contributions.index') }}" class="inline-flex items-center px-4 py-2 bg-[var(--primary-green-dark)] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[var(--primary-green)] active:bg-[var(--primary-green)] focus:outline-none focus:border-[var(--primary-green-dark)] focus:ring ring-[var(--primary-green-light)] disabled:opacity-25 transition ease-in-out duration-150">
                            Voir toutes mes contributions
                        </a>
                    </div>
                @else
                    <p class="text-[var(--primary-gray)]">Vous n'avez pas encore fait de contributions.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Charts Scripts -->
    @vite(['resources/js/user-dashboard-charts.js'])
</x-app-layout>
