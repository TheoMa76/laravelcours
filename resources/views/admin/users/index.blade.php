@vite(['resources/css/app.css', 'resources/js/app.js'])
<x-admin-layout>
@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-[var(--primary-black)]">Liste des Utilisateurs</h3>
    </div>
            
        <x-table 
            :columns="[
                ['name' => 'Nom', 'key' => 'name'],
                ['name' => 'Email', 'key' => 'email'],
                ['name' => 'Email vérifié le', 'key' => 'email_verified_at','format'=> 'date'],
                ['name' => 'Role', 'key' => 'role'],
                ['name' => 'Date création', 'key' => 'created_at','format'=> 'date'],
                ['name' => 'Mis à jour le', 'key' => 'updated_at','format'=> 'date'],
                ['name' => 'Nombres de contributions', 'key' => 'contributions_count'],
                ['name' => 'Montant total donné', 'key' => 'total_amount','format'=> 'currency'],
                ['name' => 'Projets créés', 'key' => 'projects_count', 'link' => [
                    'route' => 'admin.projects.index',
                    'param' => 'user_id'
                ]],
                ['name' => 'Projets soutenus', 'key' => 'projects_supported_count', 'link' => [
                    'route' => 'admin.contributions.index',
                    'param' => 'user_id'
                ]]
            ]" 
            :data="$users"
            :actions="[
                'view' => true,
                'edit' => true,
                'delete' => true,
            ]"
        />
    </div>
@endsection
</x-admin-layout>