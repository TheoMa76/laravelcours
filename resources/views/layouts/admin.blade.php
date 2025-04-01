<x-app-layout>    
    <div class="flex flex-row min-h-screen">
        <!-- Sidebar Admin -->
        <nav class="bg-white border-r w-1/6 flex flex-col border-[var(--primary-gray-light)] drop-shadow-lg">
            <!-- Primary Navigation Menu -->
            <div class="w-full flex flex-col mx-auto px-4 sm:px-6 lg:px-8 py-52">
                <!-- Navigation Links - Disposition verticale -->
                <div class="flex flex-col gap-1">
                    <x-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.index')" class="px-4 py-3">
                        {{ __('Projets') }}
                    </x-nav-link>
                    
                    @auth
                    @if(Auth::user()->isAdmin())
                    <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="px-4 py-3">
                        {{ __('Utilisateurs') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.index')" class="px-4 py-3">
                        {{ __('Contributions') }}
                    </x-nav-link>
                    @endif
                    @endauth
                </div>
            </div>
        </nav>

        @hasSection('header')
            <div class="w-full mx-auto py-6 px-4 sm:px-6 lg:px-8">
                @yield('header')
            </div>
        @endif

        <div class="py-12 w-full">
            <div class="w-full mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
