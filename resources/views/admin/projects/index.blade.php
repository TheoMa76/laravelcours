@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-admin-layout>
@section('content')
    <div class="bg-white shadow-sm sm:rounded-lg p-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <h3 class="text-lg font-medium text-[var(--primary-black)]">Liste des projets</h3>
            <a href="{{ route('admin.projects.create') }}" 
               class="w-full sm:w-auto bg-[var(--primary-green)] text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-[var(--primary-green-dark)] transition-colors duration-300 text-center">
                Créer un projet
            </a>
        </div>

        {{-- Bloc responsive pour le tableau --}}
        <div class="w-full overflow-x-auto">
            <div class="min-w-[900px]">
                <x-table 
                    :columns="[
                        ['name' => 'Nom', 'key' => 'name'],
                        ['name' => 'Description', 'key' => 'description'],
                        ['name' => 'Date début', 'key' => 'start_date', 'format' => 'date'],
                        ['name' => 'Date fin', 'key' => 'end_date', 'format' => 'date'],
                        ['name' => 'Statut', 'key' => 'status'],
                        ['name' => 'Responsable', 'key' => 'user_name', 'link' => [
                            'route' => 'admin.users.show',
                            'param' => 'user_id'
                        ]],
                        [
                            'name' => 'Contributeurs',
                            'key' => 'total_contributions_count',
                            'tooltip' => fn($item) => '
                                <div class=\'grid grid-cols-2 gap-2\'>
                                    <div class=\'font-medium\'>Financières:</div>
                                    <div>'.$item->financial_contributions_count.' ('.$item->total_amount.'€)</div>

                                    <div class=\'font-medium\'>Matérielles:</div>
                                    <div>'.$item->material_contributions_count.'</div>

                                    <div class=\'font-medium\'>Bénévoles:</div>
                                    <div>'.$item->volunteer_contributions_count.'</div>
                                </div>
                            ',
                        ],
                        ['name' => 'Date création', 'key' => 'created_at', 'format' => 'date']
                    ]" 

                    :data="$projets"

                    :actions="[
                        'view' => true,
                        'edit' => true,
                        'delete' => true,
                        'custom' => [
                            [
                                'route' => 'admin.projects.validate',
                                'label' => 'Valider',
                                'icon' => 'fas fa-check',
                                'confirm' => true,
                                'confirm_message' => 'Êtes-vous sûr de vouloir valider ce projet ?',
                                'condition' => fn($item) => $item->status === 'en_attente',
                                'method' => 'POST'
                            ]
                        ]
                    ]"
                />
            </div>
        </div>
    </div>
@endsection
</x-admin-layout>
