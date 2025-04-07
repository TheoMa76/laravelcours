<x-app-layout>    
    <div class="flex flex-row items-stretch h-[calc(100vh-6rem)]">
        <!-- Sidebar Admin -->
        <nav class="bg-white z-50 flex px-auto items-center gap-5 flex-col px-4 sm:px-6 lg:px-8 py-12">
                @auth
                @if(Auth::user()->isAdmin())
                <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')" class="px-4 py-3 w-full">
                    {{ __('Statistiques') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.projects.index')" :active="request()->routeIs('admin.projects.index')" class="px-4 py-3 w-full">
                    {{ __('Projets') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')" class="px-4 py-3 w-full">
                    {{ __('Utilisateurs') }}
                </x-nav-link>
                <x-nav-link :href="route('admin.contributions.index')" :active="request()->routeIs('admin.contributions.index')" class="px-4 w-full py-3">
                    {{ __('Contributions') }}
                </x-nav-link>
                @endif
                @endauth
        </nav>
        <div class="container w-full mx-auto py-10">
            @yield('content')
        </div>
    </div>
</x-app-layout>
