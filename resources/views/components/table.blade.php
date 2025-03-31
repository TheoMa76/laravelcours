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
    'errorMessage' => 'Une erreur est survenue!'
])

<div x-data="{ 
    sortColumn: '{{ request('sort', '') }}', 
    sortDirection: '{{ request('direction', 'asc') }}',
    openActionMenu: null,
    showToast(message, type) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: 'top',
            position: 'right',
            backgroundColor: type === 'success' ? '#2E7D32' : '#D32F2F',
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
    toggleActionMenu(id) {
        this.openActionMenu = this.openActionMenu === id ? null : id;
    },
    closeActionMenu() {
        this.openActionMenu = null;
    }
}" 
@click.away="closeActionMenu()"
class="relative">
    <div class="overflow-x-auto rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-[#2E7D32]">
                <tr>
                    @foreach($columns as $column)
                    <th 
                        class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider cursor-pointer hover:bg-[#1B5E20]"
                        @click="updateSort('{{ $column['key'] }}')"
                    >
                        <div class="flex justify-between items-center">
                            <span>{{ $column['name'] }}</span>
                            <template x-if="sortColumn === '{{ $column['key'] }}'">
                                <span x-text="sortDirection === 'asc' ? '↑' : '↓'"></span>
                            </template>
                        </div>
                    </th>
                    @endforeach
                    @if($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom']))
                    <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">
                        Actions
                    </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y-2 divide-[#86EFAC]">
                @foreach($data as $item)
                <tr class="{{ $loop->even ? 'bg-[#86EFAC]' : 'bg-white' }} hover:bg-[#22C55E]">
                    @foreach($columns as $column)
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                        @if(isset($column['tooltip']))
                            <div x-data="{ showTooltip: false }" class="relative inline-block">
                                <!-- Élément déclencheur -->
                                <span 
                                    x-on:mouseenter="showTooltip = true"
                                    x-on:mouseleave="showTooltip = false"
                                    class="cursor-pointer underline decoration-dotted"
                                >
                                    @if(isset($column['format']))
                                        @if($column['format'] === 'date')
                                            {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                                        @elseif($column['format'] === 'datetime')
                                            {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y H:i') }}
                                        @elseif($column['format'] === 'boolean')
                                            {!! $item->{$column['key']} ? '<span class="text-green-500">✓</span>' : '<span class="text-red-600">✗</span>' !!}
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
                                    class="absolute z-50 w-64 p-3 text-sm text-white bg-gray-800 rounded-lg shadow-xl max-h-60 overflow-y-auto"
                                    style="display: none;"
                                    x-cloak
                                >
                                    @if(is_callable($column['tooltip']))
                                        {!! $column['tooltip']($item) !!}
                                    @else
                                        {!! $column['tooltip'] !!}
                                    @endif
                                    <!-- Pointeur du tooltip -->
                                    <div class="absolute w-3 h-3 -top-1.5 left-1/2 transform -translate-x-1/2 rotate-45 bg-gray-800"></div>
                                </div>
                            </div>
                        @else
                            @if(isset($column['format'])) 
                                @if($column['format'] === 'date')
                                    {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y') }}
                                @elseif($column['format'] === 'datetime')
                                    {{ \Carbon\Carbon::parse($item->{$column['key']})->format('d/m/Y H:i') }}
                                @elseif($column['format'] === 'boolean')
                                    {!! $item->{$column['key']} ? '<span class="text-green-500">✓</span>' : '<span class="text-red-600">✗</span>' !!}
                                @elseif($column['format'] === 'custom' && isset($column['callback']))
                                    {{ $column['callback']($item) }}
                                @else
                                    {{ $item->{$column['key']} }}
                                @endif
                            @elseif(isset($column['link']))
                                <a href="{{ route($column['link']['route'], $item->{$column['link']['param']}) }}" 
                                class="text-[#1D4ED8] hover:text-[#1E40AF] hover:underline">
                                    {{ $item->{$column['key']} }}
                                </a>
                            @else
                                {{ $item->{$column['key']} }}
                            @endif
                        @endif
                    </td>
                    @endforeach
                    
                    @if($actions['view'] || $actions['edit'] || $actions['delete'] || !empty($actions['custom']))
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="relative inline-block text-left">
                            <button 
                                @click="toggleActionMenu('{{ $item->id }}')"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 focus:outline-none"
                            >
                                <i class="fas fa-ellipsis"></i>
                            </button>

                            <div 
                                x-show="openActionMenu === '{{ $item->id }}'"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                                style="position: fixed;"
                            >
                                <div class="py-1 max-h-60 overflow-y-auto">
                                    @if($actions['view'])
                                    <a 
                                        href="{{ isset($actionUrls['view']) ? route($actionUrls['view'], $item->id) : '#' }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        <i class="fas fa-eye mr-3 text-gray-500"></i>
                                        Détails
                                    </a>
                                    @endif
                                    
                                    @if($actions['edit'])
                                    <a 
                                        href="{{ isset($actionUrls['edit']) ? route($actionUrls['edit'], $item->id) : '#' }}"
                                        class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    >
                                        <i class="fas fa-edit mr-3 text-gray-500"></i>
                                        Modifier
                                    </a>
                                    @endif
                                    
                                    @if($actions['delete'])
                                    <form method="POST" action="{{ isset($actionUrls['delete']) ? route($actionUrls['delete'], $item->id) : '#' }}">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')"
                                        >
                                            <i class="fas fa-trash mr-3 text-gray-500"></i>
                                            Supprimer
                                        </button>
                                    </form>
                                    @endif
                                    
                                    @foreach($actions['custom'] as $customAction)
                                    @if(($customAction['condition'] ?? true) && ($customAction['condition']($item) ?? true))
                                        @if($customAction['confirm'] ?? false)
                                            <div x-data="{ openConfirm: false }">
                                                <button 
                                                    @click="openConfirm = true"
                                                    class="flex items-center w-full px-4 mb-2 text-sm text-gray-700 hover:bg-gray-100"
                                                >
                                                    @if(isset($customAction['icon']))
                                                    <i class="{{ $customAction['icon'] }} mr-3"></i>
                                                    @endif
                                                    {{ $customAction['label'] }}
                                                </button>
                            
                                                <!-- Modal de confirmation -->
                                                <div 
                                                    x-show="openConfirm"
                                                    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50"
                                                >
                                                    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                                                        <h3 class="text-lg font-medium text-gray-900 mb-4">
                                                            Confirmation
                                                        </h3>
                                                        <p class="text-gray-700 mb-6">
                                                            {{ $customAction['confirm_message'] }}
                                                        </p>
                                                        <div class="flex justify-end space-x-4">
                                                            <button 
                                                                @click="openConfirm = false"
                                                                class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50"
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
                                                                    class="px-4 py-2 bg-[#2E7D32] text-white rounded-md hover:bg-[#1B5E20]"
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
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            >
                                                @if(isset($customAction['icon']))
                                                <i class="{{ $customAction['icon'] }} mr-3"></i>
                                                @endif
                                                {{ $customAction['label'] }}
                                            </a>
                                        @endif
                                    @endif
                                @endforeach
                                </div>
                            </div>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(method_exists($data, 'links'))
    <div class="mt-4">
        {{ $data->appends(['sort' => request('sort'), 'direction' => request('direction')])->links() }}
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