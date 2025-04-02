@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-admin-layout>
@section('content')
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-[var(--primary-black)]">Liste des Contributions</h3>
                </div>
                
                <x-table 
                    :columns="[
                        ['name' => 'Type', 'key' => 'type'],
                        ['name' => 'Description', 'key' => 'description'],
                        ['name' => 'Montant', 'key' => 'amount'],
                        ['name' => 'A eu lieu le', 'key' => 'created_at','format'=>'date'],
                        ['name' => 'Projet', 'key' => 'project_name','link' => [
                            'route' => 'admin.projects.show',
                            'param' => 'projet_id'
                        ]],
                        ['name' => 'Utilisateur', 'key' => 'user_name','link' => [
                            'route' => 'admin.users.show',
                            'param' => 'user_id'
                        ]]
                    ]" 
                    :data="$contributions"
                    :actions="[
                        'view' => true,
                        'edit' => false,
                        'delete' => false,
                    ]"
                />
@endsection
</x-admin-layout>