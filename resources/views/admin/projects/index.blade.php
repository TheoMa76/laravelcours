@vite(['resources/css/app.css', 'resources/js/app.js'])
@extends('layouts.admin')

@section('header')
    <h2 class="font-semibold text-xl text-[var(--primary-black)] leading-tight ml-4">
        {{ __('Projets') }}
    </h2>
@endsection

@section('content')
    <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-[var(--primary-gray-light)]">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-[var(--primary-black)]">Liste des projets</h3>
                    <a href="{{ route('admin.projects.create') }}" 
                       class="bg-[var(--primary-green)] text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-[var(--primary-green-dark)] transition-colors duration-300">
                        Créer un projet
                    </a>
                </div>
                
                <x-table 
                    :columns="[
                        ['name' => 'Nom', 'key' => 'name'],
                        ['name' => 'Description', 'key' => 'description'],
                        ['name' => 'Date début', 'key' => 'start_date','format'=> 'date'],
                        ['name' => 'Date fin', 'key' => 'end_date','format'=> 'date'],
                        ['name' => 'Statut', 'key' => 'status'],
                        ['name' => 'Responsable', 'key' => 'user_name','link' => [
                            'route' => 'admin.users.show',
                            'param' => 'user_id'
                        ]],
                        [
                            'name' => 'Contributeurs',
                            'key' => 'total_contributions_count',
                            'tooltip' => fn($item) => '
                                    <div class=grid grid-cols-2 gap-2>
                                        <div class=font-medium>Financières:</div>
                                        <div>'.$item->financial_contributions_count.' ('.$item->total_amount.'€)</div>
                                        
                                        <div class=font-medium>Matérielles:</div>
                                        <div>'.$item->material_contributions_count.'</div>
                                        
                                        <div class=font-medium>Bénévoles:</div>
                                        <div>'.$item->volunteer_contributions_count.'</div>
                                    </div>
                            ',
                        ],
                        ['name' => 'Date création', 'key' => 'created_at','format'=> 'date']
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
                                'icon'=> 'fas fa-check',
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