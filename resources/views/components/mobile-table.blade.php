@props([
    'columns',
    'data',
    'actions' => [
        'view' => true,
        'edit' => true,
        'delete' => true,
        'custom' => []
    ],
    'actionUrls' => [],
    'successMessage' => 'Opération réussie!',
    'errorMessage' => 'Une erreur est survenue!',
    'breakpoint' => '768px' // Mobile breakpoint, can be customized
])

<div x-data="{ 
    sortColumn: '{{ request('sort', '') }}', 
    sortDirection: '{{ request('direction', 'asc') }}',
    openActionMenu: null,
    openItem: null,
    isMobile: window.innerWidth < parseInt('{{ $breakpoint }}'),
    showToast(message, type) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            backgroundColor: type === 'success' ? 'var(--primary-green)' : 'var(--primary-red)',
        }).showToast();
    },
    updateSort(column) {
        if(this.sortColumn === column) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            this.sortColumn = column;
            this.sortDirection = 'asc';
        }
        window.location = `${window.location.pathname}?sort=${this.sortColumn}&direction=${this.sortDirection}`;
    },
    toggleActionMenu(id, event) {
        event.stopPropagation();
        this.openActionMenu = this.openActionMenu === id ? null : id;
    },
    toggleItem(id) {
        this.openItem = this.openItem === id ? null : id;
        this.openActionMenu = null;
    },
    closeActionMenu() {
        this.openActionMenu = null;
    },
    checkMobile() {
        this.isMobile = window.innerWidth < parseInt('{{ $breakpoint }}');
    }
}" 
@click.away="closeActionMenu()"
x-init="
    checkMobile();
    window.addEventListener('resize', checkMobile);
"
class="relative w-full">

    <!-- Desktop Table View -->
    <div x-show="!isMobile" class="overflow-x-auto rounded-lg shadow-sm border border-[var(--primary-gray-light)]">
        <div class="inline-block min-w-full align-middle">
            <table class="min-w-full divide-y divide-[var(--primary-gray-light)]">
                <thead class="bg-[var(--primary-green)]">
                    <tr>
                        @foreach($columns as $column)
                        <th 
                            class="px-2 py-2 md:px-4 md:py-3 text-center text-xs font-medium text-white uppercase tracking-wider cursor-pointer hover:bg-[var(--primary-green-dark)] transition-colors duration-200"
                            @click="updateSort('{{ $column['key'] }}')"
                        >
                            <div class="flex justify-between items-center">
                                <span>{{ $column['name'] }}</span>
                                <template x-if="sortColumn === '{{ $column['key'] }}'">
                                    <span class="ml-1" x-text="sortDirection === 'asc' ? '↑' : '↓'"></span>
                                </template>
                            </div>
                        </th>
                        @endforeach
                        @if($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom']))
                        <th class="px-2 py-2 md:px-4 md:py-3 text-center text-xs font-medium text-white cursor-default uppercase tracking-wider">
                            Actions
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-[var(--primary-green-superlight)]">
                    @if($data->count() > 0)
                        @foreach($data as $item)
                        <tr class="{{ $loop->even ? 'bg-[var(--primary-green-superlight)]' : 'bg-white' }} hover:bg-[var(--primary-light-hover)] transition-colors duration-150">
                            @foreach($columns as $column)
                            <td class="px-2 py-2 md:px-4 md:py-3 cursor-default text-center text-xs text-[var(--primary-black)]">
                                <div class="max-w-[80px] md:max-w-xs truncate inline-block">
                                    @if(isset($column['tooltip']))
                                        <div x-data="{ showTooltip: false }" class="relative inline-block">
                                            <!-- Élément déclencheur -->
                                            <span 
                                                x-on:mouseenter="showTooltip = true"
                                                x-on:mouseleave="showTooltip = false"
                                                class="cursor-pointer underline decoration-dotted truncate"
                                            >
                                                @if(isset($column['format']))
                                                    @if($column['format'] === 'date')
                                                        {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                                                    @elseif($column['format'] === 'datetime')
                                                        {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y H:i') }}
                                                    @elseif($column['format'] === 'boolean')
                                                        {!! $item->{$column['key']} ? '<span class="text-[var(--primary-green)]">✓</span>' : '<span class="text-[var(--primary-red)]">✗</span>' !!}
                                                    @elseif($column['format'] === 'custom' && isset($column['callback']))
                                                        {{ $column['callback']($item) }}
                                                    @else
                                                        {{ $item->{$column['key']} }}
                                                    @endif
                                                @else
                                                    {{ $item->{$column['key']} }}
                                                @endif
                                            </span>
                                            
                                            <!-- Tooltip -->
                                            <div 
                                                x-show="showTooltip"
                                                x-transition:enter="transition ease-out duration-200"
                                                x-transition:enter-start="opacity-0 scale-95"
                                                x-transition:enter-end="opacity-100 scale-100"
                                                x-transition:leave="transition ease-in duration-150"
                                                x-transition:leave-start="opacity-100 scale-100"
                                                x-transition:leave-end="opacity-0 scale-95"
                                                class="fixed z-50 w-48 p-2 text-xs text-white bg-[var(--primary-black)] rounded-lg shadow-xl"
                                                style="display: none; left: calc(var(--mouse-x) + 10px); top: calc(var(--mouse-y) + 10px);"
                                                x-cloak
                                                x-init="
                                                    document.addEventListener('mousemove', (e) => {
                                                        document.documentElement.style.setProperty('--mouse-x', `${e.clientX}px`);
                                                        document.documentElement.style.setProperty('--mouse-y', `${e.clientY}px`);
                                                    })
                                                "
                                            >
                                                @if(is_callable($column['tooltip']))
                                                    {!! $column['tooltip']($item) !!}
                                                @else
                                                    {!! $column['tooltip'] !!}
                                                @endif
                                                <!-- Pointeur du tooltip -->
                                                <div class="absolute w-3 h-3 -top-1.5 left-1/2 transform -translate-x-1/2 rotate-45 bg-[var(--primary-black)]"></div>
                                            </div>
                                        </div>
                                    @else
                                        @if(isset($column['format'])) 
                                            @if($column['format'] === 'date')
                                                {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                                            @elseif($column['format'] === 'datetime')
                                                {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y H:i') }}
                                            @elseif($column['format'] === 'boolean')
                                                {!! $item->{$column['key']} ? '<span class="text-[var(--primary-green)]">✓</span>' : '<span class="text-[var(--primary-red)]">✗</span>' !!}
                                            @elseif($column['format'] === 'custom' && isset($column['callback']))
                                                {{ $column['callback']($item) }}
                                            @else
                                                {{ $item->{$column['key']} }}
                                            @endif
                                        @elseif(isset($column['link']))
                                            <a href="{{ route($column['link']['route'], $item->{$column['link']['param']}) }}" 
                                            class="text-[var(--primary-blue)] hover:text-[var(--primary-blue-hover)] hover:underline truncate">
                                                {{ $item->{$column['key']} }}
                                            </a>
                                        @else
                                            {{ $item->{$column['key']} }}
                                        @endif
                                    @endif
                                </div>
                            </td>
                            @endforeach
                            
                            @if($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom']))
                            <td class="px-2 py-2 md:px-4 md:py-3 text-center">
                                <div class="relative inline-block text-left">
                                    <button 
                                        @click="toggleActionMenu('{{ $item->id }}', $event)"
                                        class="inline-flex items-center justify-center p-1 rounded-md text-[var(--primary-black)] hover:text-[var(--primary-green)] hover:bg-[var(--primary-green-superlight)] focus:outline-none transition-colors duration-200"
                                    >
                                        <i class="fas fa-ellipsis text-xs"></i>
                                    </button>

                                    <div 
                                        x-show="openActionMenu === '{{ $item->id }}'"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="origin-top-right absolute right-0 mt-2 w-40 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                        style="position: fixed;"
                                    >
                                        <div class="py-1 max-h-60 overflow-y-auto">
                                            @if($actions['view'])
                                            <a 
                                                href="{{ isset($actionUrls['view']) ? route($actionUrls['view'], $item->id) : '#' }}"
                                                class="flex items-center px-3 py-1.5 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                            >
                                                <i class="fas fa-eye mr-2 text-[var(--primary-gray)] text-xs"></i>
                                                <span class="truncate">Détails</span>
                                            </a>
                                            @endif
                                            
                                            @if($actions['edit'])
                                            <a 
                                                href="{{ isset($actionUrls['edit']) ? route($actionUrls['edit'], $item->id) : '#' }}"
                                                class="flex items-center px-3 py-1.5 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                            >
                                                <i class="fas fa-edit mr-2 text-[var(--primary-gray)] text-xs"></i>
                                                <span class="truncate">Modifier</span>
                                            </a>
                                            @endif
                                            
                                            @if($actions['delete'])
                                            <form method="POST" action="{{ isset($actionUrls['delete']) ? route($actionUrls['delete'], $item->id) : '#' }}">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="flex items-center w-full px-3 py-1.5 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"
                                                >
                                                    <i class="fas fa-trash mr-2 text-[var(--primary-gray)] text-xs"></i>
                                                    <span class="truncate">Supprimer</span>
                                                </button>
                                            </form>
                                            @endif
                                            @if(isset($actions['custom']))
                                                @foreach($actions['custom'] as $customAction)
                                                    @if(($customAction['condition'] ?? true) && ($customAction['condition']($item) ?? true))
                                                        @if($customAction['confirm'] ?? false)
                                                            <div x-data="{ openConfirm: false }">
                                                                <button 
                                                                    @click="openConfirm = true"
                                                                    class="flex items-center w-full px-3 py-1.5 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                                                >
                                                                    @if(isset($customAction['icon']))
                                                                    <i class="{{ $customAction['icon'] }} mr-2 text-xs"></i>
                                                                    @endif
                                                                    <span class="truncate">{{ $customAction['label'] }}</span>
                                                                </button>
                                            
                                                                <!-- Modal de confirmation -->
                                                                <div 
                                                                    x-show="openConfirm"
                                                                    class="fixed inset-0 bg-[var(--primary-gray)] bg-opacity-50 flex items-center justify-center z-50 p-2"
                                                                >
                                                                    <div class="bg-white rounded-lg p-3 max-w-xs w-full shadow-xl">
                                                                        <h3 class="text-sm font-medium text-[var(--primary-black)] mb-2">
                                                                            Confirmation
                                                                        </h3>
                                                                        <p class="text-xs text-[var(--primary-black)] mb-3">
                                                                            {{ $customAction['confirm_message'] }}
                                                                        </p>
                                                                        <div class="flex justify-end space-x-2">
                                                                            <button 
                                                                                @click="openConfirm = false"
                                                                                class="px-2 py-1 border border-[var(--primary-gray)] rounded-md text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                                                            >
                                                                                Annuler
                                                                            </button>
                                                                            <form 
                                                                                method="{{ $customAction['method'] ?? 'POST' }}"
                                                                                action="{{ route($customAction['route'], $item->id) }}"
                                                                                @submit.prevent="
                                                                                    fetch($event.target.action, {
                                                                                        method: $event.target.method,
                                                                                        headers: {
                                                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                            'Accept': 'application/json',
                                                                                            'Content-Type': 'application/json'
                                                                                        },
                                                                                        body: JSON.stringify(Object.fromEntries(new FormData($event.target)))
                                                                                    })
                                                                                    .then(response => {
                                                                                        if (response.ok) {
                                                                                            showToast('{{ $successMessage }}', 'success');
                                                                                            setTimeout(() => window.location.reload(), 1000);
                                                                                        } else {
                                                                                            showToast('{{ $errorMessage }}', 'error');
                                                                                        }
                                                                                    })
                                                                                    .catch(() => {
                                                                                        showToast('{{ $errorMessage }}', 'error');
                                                                                    });
                                                                                    openConfirm = false;
                                                                                "
                                                                            >
                                                                                @csrf
                                                                                @if(($customAction['method'] ?? 'POST') !== 'GET')
                                                                                    @method($customAction['method'])
                                                                                @endif
                                                                                <button 
                                                                                    type="submit"
                                                                                    class="px-2 py-1 bg-[var(--primary-green)] text-white rounded-md text-xs hover:bg-[var(--primary-green-dark)] transition-colors duration-150"
                                                                                >
                                                                                    Confirmer
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a 
                                                                href="{{ route($customAction['route'], $item->id) }}"
                                                                class="flex items-center px-3 py-1.5 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                                            >
                                                                @if(isset($customAction['icon']))
                                                                <i class="{{ $customAction['icon'] }} mr-2 text-xs"></i>
                                                                @endif
                                                                <span class="truncate">{{ $customAction['label'] }}</span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="{{ count($columns) + (($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom'])) ? 1 : 0) }}" class="px-4 py-3 text-center text-xs text-[var(--primary-gray)]">
                                Aucune donnée pour le moment
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div x-show="isMobile" class="space-y-3">
        @if($data->count() > 0)
            <!-- Mobile Sort Dropdown -->
            <div class="mb-3 px-2">
                <div x-data="{ open: false }" class="relative">
                    <button 
                        @click="open = !open" 
                        class="flex items-center justify-between w-full px-3 py-2 text-xs bg-white border border-[var(--primary-gray-light)] rounded-md shadow-sm"
                    >
                        <span>Trier par: {{ collect($columns)->where('key', request('sort'))->first()['name'] ?? 'Par défaut' }}</span>
                        <i class="fas fa-chevron-down text-xs ml-2"></i>
                    </button>
                    <div 
                        x-show="open" 
                        @click.away="open = false"
                        class="absolute z-10 w-full mt-1 bg-white border border-[var(--primary-gray-light)] rounded-md shadow-lg"
                    >
                        <div class="py-1">
                            @foreach($columns as $column)
                                <button 
                                    @click="updateSort('{{ $column['key'] }}'); open = false"
                                    class="flex items-center justify-between w-full px-3 py-2 text-xs text-left hover:bg-[var(--primary-gray-light)]"
                                >
                                    <span>{{ $column['name'] }}</span>
                                    @if(request('sort') === $column['key'])
                                        <i class="fas fa-{{ request('direction') === 'asc' ? 'arrow-up' : 'arrow-down' }} text-xs"></i>
                                    @endif
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            @foreach($data as $item)
                <div 
                    class="border border-[var(--primary-gray-light)] rounded-lg overflow-hidden bg-white shadow-sm"
                >
                    <!-- Card Header with Primary Info -->
                    <div 
                        @click="toggleItem('{{ $item->id }}')"
                        class="flex items-center justify-between p-3 bg-[var(--primary-green-superlight)] cursor-pointer"
                    >
                        <div class="flex-1 truncate">
                            <div class="font-medium text-sm">
                                @if(isset($columns[0]))
                                    @if(isset($columns[0]['format']))
                                        @if($columns[0]['format'] === 'date')
                                            {{ \Carbon\Carbon::parse($item->{$columns[0]['key']})->format('d/m/Y') }}
                                        @elseif($columns[0]['format'] === 'datetime')
                                            {{ \Carbon\Carbon::parse($item->{$columns[0]['key']})->format('d/m/Y H:i') }}
                                        @elseif($columns[0]['format'] === 'boolean')
                                            {!! $item->{$columns[0]['key']} ? '<span class="text-[var(--primary-green)]">✓</span>' : '<span class="text-[var(--primary-red)]">✗</span>' !!}
                                        @elseif($columns[0]['format'] === 'custom' && isset($columns[0]['callback']))
                                            {{ $columns[0]['callback']($item) }}
                                        @else
                                            {{ $item->{$columns[0]['key']} }}
                                        @endif
                                    @else
                                        {{ $item->{$columns[0]['key']} }}
                                    @endif
                                @endif
                            </div>
                            @if(isset($columns[1]))
                                <div class="text-xs text-[var(--primary-gray)]">
                                    @if(isset($columns[1]['format']))
                                        @if($columns[1]['format'] === 'date')
                                            {{ \Carbon\Carbon::parse($item->{$columns[1]['key']})->format('d/m/Y') }}
                                        @elseif($columns[1]['format'] === 'datetime')
                                            {{ \Carbon\Carbon::parse($item->{$columns[1]['key']})->format('d/m/Y H:i') }}
                                        @elseif($columns[1]['format'] === 'boolean')
                                            {!! $item->{$columns[1]['key']} ? '<span class="text-[var(--primary-green)]">✓</span>' : '<span class="text-[var(--primary-red)]">✗</span>' !!}
                                        @elseif($columns[1]['format'] === 'custom' && isset($columns[1]['callback']))
                                            {{ $columns[1]['callback']($item) }}
                                        @else
                                            {{ $item->{$columns[1]['key']} }}
                                        @endif
                                    @else
                                        {{ $item->{$columns[1]['key']} }}
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex items-center gap-2">
                            @if($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom']))
                                <div class="relative">
                                    <button 
                                        @click="toggleActionMenu('{{ $item->id }}', $event)"
                                        class="p-1.5 rounded-full text-[var(--primary-black)] hover:bg-[var(--primary-green-superlight)]"
                                    >
                                        <i class="fas fa-ellipsis-v text-xs"></i>
                                    </button>

                                    <div 
                                        x-show="openActionMenu === '{{ $item->id }}'"
                                        x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 z-50 mt-1 w-40 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
                                    >
                                        <div class="py-1 max-h-60 overflow-y-auto">
                                            @if($actions['view'])
                                            <a 
                                                href="{{ isset($actionUrls['view']) ? route($actionUrls['view'], $item->id) : '#' }}"
                                                class="flex items-center px-3 py-2 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)]"
                                            >
                                                <i class="fas fa-eye mr-2 text-[var(--primary-gray)]"></i>
                                                <span>Détails</span>
                                            </a>
                                            @endif
                                            
                                            @if($actions['edit'])
                                            <a 
                                                href="{{ isset($actionUrls['edit']) ? route($actionUrls['edit'], $item->id) : '#' }}"
                                                class="flex items-center px-3 py-2 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)]"
                                            >
                                                <i class="fas fa-edit mr-2 text-[var(--primary-gray)]"></i>
                                                <span>Modifier</span>
                                            </a>
                                            @endif
                                            
                                            @if($actions['delete'])
                                            <form method="POST" action="{{ isset($actionUrls['delete']) ? route($actionUrls['delete'], $item->id) : '#' }}">
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="flex items-center w-full px-3 py-2 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)]"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"
                                                >
                                                    <i class="fas fa-trash mr-2 text-[var(--primary-gray)]"></i>
                                                    <span>Supprimer</span>
                                                </button>
                                            </form>
                                            @endif
                                            
                                            @if(isset($actions['custom']))
                                                @foreach($actions['custom'] as $customAction)
                                                    @if(($customAction['condition'] ?? true) && ($customAction['condition']($item) ?? true))
                                                        @if($customAction['confirm'] ?? false)
                                                            <div x-data="{ openConfirm: false }">
                                                                <button 
                                                                    @click="openConfirm = true"
                                                                    class="flex items-center w-full px-3 py-2 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)]"
                                                                >
                                                                    @if(isset($customAction['icon']))
                                                                    <i class="{{ $customAction['icon'] }} mr-2"></i>
                                                                    @endif
                                                                    <span>{{ $customAction['label'] }}</span>
                                                                </button>
                                            
                                                                <!-- Modal de confirmation -->
                                                                <div 
                                                                    x-show="openConfirm"
                                                                    class="fixed inset-0 bg-[var(--primary-gray)] bg-opacity-50 flex items-center justify-center z-50 p-4"
                                                                >
                                                                    <div class="bg-white rounded-lg p-4 max-w-xs w-full shadow-xl">
                                                                        <h3 class="text-sm font-medium text-[var(--primary-black)] mb-2">
                                                                            Confirmation
                                                                        </h3>
                                                                        <p class="text-xs text-[var(--primary-black)] mb-4">
                                                                            {{ $customAction['confirm_message'] }}
                                                                        </p>
                                                                        <div class="flex justify-end space-x-2">
                                                                            <button 
                                                                                @click="openConfirm = false"
                                                                                class="px-2 py-1 border border-[var(--primary-gray)] rounded-md text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)] transition-colors duration-150"
                                                                            >
                                                                                Annuler
                                                                            </button>
                                                                            <form 
                                                                                method="{{ $customAction['method'] ?? 'POST' }}"
                                                                                action="{{ route($customAction['route'], $item->id) }}"
                                                                                @submit.prevent="
                                                                                    fetch($event.target.action, {
                                                                                        method: $event.target.method,
                                                                                        headers: {
                                                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                                                                            'Accept': 'application/json',
                                                                                            'Content-Type': 'application/json'
                                                                                        },
                                                                                        body: JSON.stringify(Object.fromEntries(new FormData($event.target)))
                                                                                    })
                                                                                    .then(response => {
                                                                                        if (response.ok) {
                                                                                            showToast('{{ $successMessage }}', 'success');
                                                                                            setTimeout(() => window.location.reload(), 1000);
                                                                                        } else {
                                                                                            showToast('{{ $errorMessage }}', 'error');
                                                                                        }
                                                                                    })
                                                                                    .catch(() => {
                                                                                        showToast('{{ $errorMessage }}', 'error');
                                                                                    });
                                                                                    openConfirm = false;
                                                                                "
                                                                            >
                                                                                @csrf
                                                                                @if(($customAction['method'] ?? 'POST') !== 'GET')
                                                                                    @method($customAction['method'])
                                                                                @endif
                                                                                <button 
                                                                                    type="submit"
                                                                                    class="px-2 py-1 bg-[var(--primary-green)] text-white rounded-md text-xs hover:bg-[var(--primary-green-dark)] transition-colors duration-150"
                                                                                >
                                                                                    Confirmer
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <a 
                                                                href="{{ route($customAction['route'], $item->id) }}"
                                                                class="flex items-center px-3 py-2 text-xs text-[var(--primary-black)] hover:bg-[var(--primary-gray-light)]"
                                                            >
                                                                @if(isset($customAction['icon']))
                                                                <i class="{{ $customAction['icon'] }} mr-2"></i>
                                                                @endif
                                                                <span>{{ $customAction['label'] }}</span>
                                                            </a>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <button 
                                @click="toggleItem('{{ $item->id }}')"
                                class="p-1.5 rounded-full text-[var(--primary-black)] hover:bg-[var(--primary-green-superlight)]"
                            >
                                <i class="fas" :class="openItem === '{{ $item->id }}' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Card Details (Expandable) -->
                    <div 
                        x-show="openItem === '{{ $item->id }}'"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-2"
                        class="p-3 border-t border-[var(--primary-gray-light)]"
                    >
                        <dl class="grid grid-cols-1 gap-2">
                            @foreach($columns as $index => $column)
                                @if($index > 1) <!-- Skip the first two columns as they're shown in the header -->
                                    <div class="flex justify-between py-1 border-b border-[var(--primary-gray-light)] last:border-0">
                                        <dt class="text-xs font-medium text-[var(--primary-gray)]">{{ $column['name'] }}</dt>
                                        <dd class="text-xs text-right">
                                            @if(isset($column['format']))
                                                @if($column['format'] === 'date')
                                                    {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                                                @elseif($column['format'] === 'datetime')
                                                    {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y H:i') }}
                                                @elseif($column['format'] === 'boolean')
                                                    {!! $item->{$column['key']} ? '<span class="text-[var(--primary-green)]">✓</span>' : '<span class="text-[var(--primary-red)]">✗</span>' !!}
                                                @elseif($column['format'] === 'custom' && isset($column['callback']))
                                                    {{ $column['callback']($item) }}
                                                @else
                                                    {{ $item->{$column['key']} }}
                                                @endif
                                            @elseif(isset($column['link']))
                                                <a href="{{ route($column['link']['route'], $item->{$column['link']['param']}) }}" 
                                                class="text-[var(--primary-blue)] hover:text-[var(--primary-blue-hover)] hover:underline">
                                                    {{ $item->{$column['key']} }}
                                                </a>
                                            @else
                                                {{ $item->{$column['key']} }}
                                            @endif
                                        </dd>
                                    </div>
                                @endif
                            @endforeach
                        </dl>
                        
                        <!-- Quick Action Buttons -->
                        @if($actions['view'] || $actions['edit'] || $actions['delete'])
                            <div class="flex gap-2 mt-3 pt-2 border-t border-[var(--primary-gray-light)]">
                                @if($actions['view'])
                                    <a 
                                        href="{{ isset($actionUrls['view']) ? route($actionUrls['view'], $item->id) : '#' }}"
                                        class="flex-1 py-1.5 px-2 text-center text-xs bg-[var(--primary-green-superlight)] text-[var(--primary-green)] rounded-md hover:bg-[var(--primary-green-light)] transition-colors duration-150"
                                    >
                                        <i class="fas fa-eye mr-1"></i> Détails
                                    </a>
                                @endif
                                
                                @if($actions['edit'])
                                    <a 
                                        href="{{ isset($actionUrls['edit']) ? route($actionUrls['edit'], $item->id) : '#' }}"
                                        class="flex-1 py-1.5 px-2 text-center text-xs bg-[var(--primary-blue-superlight)] text-[var(--primary-blue)] rounded-md hover:bg-[var(--primary-blue-light)] transition-colors duration-150"
                                    >
                                        <i class="fas fa-edit mr-1"></i> Modifier
                                    </a>
                                @endif
                                
                                @if($actions['delete'])
                                    <form method="POST" action="{{ isset($actionUrls['delete']) ? route($actionUrls['delete'], $item->id) : '#' }}" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="w-full py-1.5 px-2 text-center text-xs bg-[var(--primary-red-superlight)] text-[var(--primary-red)] rounded-md hover:bg-[var(--primary-red-light)] transition-colors duration-150"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"
                                        >
                                            <i class="fas fa-trash mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="p-4 text-center text-xs text-[var(--primary-gray)] bg-white border border-[var(--primary-gray-light)] rounded-lg">
                Aucune donnée pour le moment
            </div>
        @endif
    </div>

    @if(method_exists($data, 'links') && $data->count() > 0)
    <div class="mt-3 px-2 flex justify-center">
        <div class="inline-flex">
            {{ $data->appends(['sort' => request('sort'), 'direction' => request('direction')])->links() }}
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pagination a').forEach(link => {
        const url = new URL(link.href);
        url.searchParams.set('sort', '{{ request('sort') }}');
        url.searchParams.set('direction', '{{ request('direction') }}');
        link.href = url.toString();
    });
});
</script>