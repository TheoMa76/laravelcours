@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-12 px-6 py-4 bg-white rounded-lg shadow-sm border border-[var(--primary-gray-light)]">
                <!-- Bouton de retour avec icône flèche -->
                <a href="{{ route('projets') }}" class="flex items-center text-[var(--primary-black)] hover:text-[var(--primary-green)] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Retour aux projets</span>
                </a>
            
                <!-- Message central -->
                <div class="text-center flex-grow">
                    <h1 class="text-2xl md:text-3xl font-bold text-[var(--primary-green-dark)] mb-1">Créer un nouveau projet</h1>
                    <p class="text-[var(--primary-green)] text-sm md:text-base">Lancez votre initiative solidaire</p>
                </div>
            
                <!-- Espace vide pour équilibrer le layout -->
                <div class="w-24"></div>
            </div>

            <form action="{{ $edit ? route('projets.update',$projet->id) : route('projets.store') }}" method="POST" enctype="multipart/form-data" 
            x-data="projectForm" 
            @needs-materials-changed.window="needsMaterials = $event.detail; if($event.detail) materialsTabShown = false"
            @needs-volunteers-changed.window="needsVolunteers = $event.detail; if($event.detail) volunteersTabShown = false">
                @csrf
                @if ($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left side - Form tabs -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Tabs navigation -->
                        <div class="bg-white sticky top-0 rounded-xl shadow-md overflow-hidden drop-shadow-lg z-50">
                            <div class="flex">
                                <button 
                                    type="button"
                                    @click="activeTab = 'general'" 
                                    :class="{ 
                                        'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'general', 
                                        'border-transparent text-primary-gray-dark': activeTab !== 'general' 
                                    }"
                                    class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none relative"
                                >
                                    <i class="fas fa-info-circle mr-2"></i> Informations générales
                                </button>
                                
                                <template x-if="needsMaterials">
                                    <button 
                                        type="button"
                                        @click="activeTab = 'materials'; materialsTabShown = true" 
                                        :class="{ 
                                            'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'materials', 
                                            'border-transparent text-primary-gray-dark': activeTab !== 'materials'
                                        }"
                                        class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none relative overflow-hidden"
                                        x-init="setTimeout(() => materialsTabShown = true, 2000)"
                                    >
                                        <span x-show="!materialsTabShown" 
                                              class="absolute inset-0 bg-primary-green-light bg-opacity-30 animate-pulse-slow"></span>
                                        <span class="relative z-20">
                                            <i class="fas fa-tools mr-2"></i> Matériaux nécessaires
                                        </span>
                                    </button>
                                </template>
                                
                                <template x-if="needsVolunteers">
                                    <button 
                                        type="button"
                                        @click="activeTab = 'volunteers'; volunteersTabShown = true" 
                                        :class="{ 
                                            'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'volunteers', 
                                            'border-transparent text-primary-gray-dark': activeTab !== 'volunteers'
                                        }"
                                        class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none relative overflow-hidden"
                                        x-init="setTimeout(() => volunteersTabShown = true, 2000)"
                                    >
                                        <span x-show="!volunteersTabShown" 
                                              class="absolute inset-0 bg-primary-green-light bg-opacity-30 animate-pulse-slow"></span>
                                        <span class="relative z-20">
                                            <i class="fas fa-users mr-2"></i> Bénévoles nécessaires
                                        </span>
                                    </button>
                                </template>
                            </div>
                        </div>

                        <!-- General Information Tab -->
                        <div x-show="activeTab === 'general'" class="bg-white border-2 border-[var(--primary-green-light)] rounded-xl drop-shadow-lg shadow-md overflow-hidden p-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-6">Informations du projet</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="text-sm font-medium text-primary-gray-dark mb-2">Nom du projet <span class="text-[var(--primary-red)]">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $projet->name ?? '') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    @error('name')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('name') }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="short_description" class="text-sm font-medium text-primary-gray-dark mb-2">Description courte <span class="text-[var(--primary-red)]">*</span></label>
                                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description'),$projet->short_description ?? '' }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    @error('short_description')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('short_description') }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="image" class="text-sm font-medium text-primary-gray-dark mb-2">Image du projet</label>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    <p class="mt-1 text-sm text-primary-gray">Format recommandé : JPG, PNG. Max 2MB.</p>
                                    @error('image')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('image') }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="description" class="text-sm font-medium text-primary-gray-dark mb-2">Description détaillée <span class="text-[var(--primary-red)]">*</span></label>
                                    <textarea id="description" name="description" rows="6" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">{{ old('description'), $projet->description ?? '' }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('description') }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="start_date" class="text-sm font-medium text-primary-gray-dark mb-2">Date de début <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date'), \Carbon\Carbon::parse($projet->start_date)->format('Y-m-d') ?? '' }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('start_date') }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="end_date" class="text-sm font-medium text-primary-gray-dark mb-2">Date de fin <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date'), \Carbon\Carbon::parse($projet->end_date)->format('Y-m-d') ?? '' }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('end_date') }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" x-model="needsMaterials" 
                                                   @change="$dispatch('needs-materials-changed', $event.target.checked)"
                                                   class="rounded border-gray-300 text-[var(--primary-green)] focus:ring-[var(--primary-green)]">
                                            <span class="ml-2 text-lg text-primary-gray-dark">Ce projet nécessite des matériaux</span>
                                        </label>
                                    </div>
                                    
                                    <div>
                                        <label class="inline-flex items-center">
                                            <input type="checkbox" x-model="needsVolunteers" 
                                                   @change="$dispatch('needs-volunteers-changed', $event.target.checked)"
                                                   class="rounded border-gray-300 text-[var(--primary-green)] focus:ring-[var(--primary-green)]">
                                            <span class="ml-2 text-lg text-primary-gray-dark">Ce projet nécessite des bénévoles</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="money_goal" class="text-sm font-medium text-primary-gray-dark mb-2">Objectif financier (€) <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="number" id="money_goal" name="money_goal" value="{{ old('money_goal'), $projet->money_goal ?? '' }}" min="0" step="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('money_goal')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('money_goal') }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Materials Tab -->
                        <div x-show="activeTab === 'materials' && needsMaterials" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-primary-black">Matériaux nécessaires</h3>
                                <button type="button" id="add-material" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary-green)]">
                                    <i class="fas fa-plus mr-2"></i> Ajouter
                                </button>
                            </div>
                            
                            <div id="materials-container" class="space-y-4">

                            </div>
                            
                            <div class="mt-4 text-sm text-primary-gray-dark">
                                <p><i class="fas fa-info-circle mr-1"></i> Ajoutez tous les matériaux dont vous aurez besoin pour ce projet.</p>
                            </div>
                        </div>

                        <!-- Volunteers Tab -->
                        <div x-show="activeTab === 'volunteers' && needsVolunteers" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-primary-black">Rôles bénévoles</h3>
                                <button type="button" id="add-role" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary-green)]">
                                    <i class="fas fa-plus mr-2"></i> Ajouter
                                </button>
                            </div>

                            <div class="mb-6">
                                <label for="volunteer_hour_goal" class=" text-sm font-medium text-primary-gray-dark mb-2">
                                    Objectif global d'heures de bénévolat <span class="text-[var(--primary-red)]">*</span>
                                </label>
                                <input type="number" id="volunteer_hour_goal" name="volunteer_hour_goal" 
                                    value="{{ old('volunteer_hour_goal'), $projet->volunteer_hour_goal ?? '' }}" min="0" step="1"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                    x-bind:required="needsVolunteers">
                                @error('volunteer_hour_goal')
                                    <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $errors->first('volunteer_hour_goal') }}</p>
                                @enderror
                                <p class="mt-1 text-sm text-primary-gray">Définissez le nombre total d'heures de bénévolat nécessaires pour ce projet.</p>
                            </div>
                            
                            <div id="roles-container" class="space-y-4">
                                <!-- Role items will be added here dynamically -->
                            </div>
                            
                            <div class="mt-4 text-sm text-primary-gray-dark">
                                <p><i class="fas fa-info-circle mr-1"></i> Définissez tous les rôles bénévoles nécessaires pour ce projet.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Preview and actions -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-[var(--primary-green-light)] p-6 sticky top-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-4">Aperçu du projet</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="aspect-video bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img id="image-preview" src="{{ $projet->image ?? asset('images/greenPot.png') }}" alt="Aperçu du projet" class="w-auto h-full object-center">                                
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-primary-black" id="preview-name">Nom du projet</h4>
                                    <p class="text-sm text-primary-gray-dark" id="preview-description">Description courte du projet...</p>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-primary-gray-dark">
                                        <i class="fas fa-calendar-alt mr-1"></i> <span id="preview-dates">{{ $projet->start_date ?? '00/00/0000' }} - {{$projet->end_date ?? '00/00/0000'}}</span>
                                    </span>
                                    <span class="text-primary-gray-dark">
                                        <i class="fas fa-coins mr-1"></i> <span id="preview-goal">{{ $projet->money_goal ?? "0 €" }}</span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-medium text-primary-black mb-2">Progression</h4>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-[var(--primary-green)] h-2.5 rounded-full transition-all duration-500 ease-out" x-bind:style="'width: ' + calculateGlobalCompletion() + '%'"></div>
                                    </div>
                                    
                                    <div class="mt-4 space-y-2">
                                        <button type="button" @click="activeTab = 'general'" 
                                            class="text-sm text-[var(--primary-black)] hover:text-[var(--primary-green-dark)] transition-colors">
                                            <i class="fas fa-check-circle mr-1"></i> Informations générales
                                        </button>
                                        
                                        <template x-if="needsMaterials">
                                            <div>
                                                <button type="button" @click="activeTab = 'materials'" 
                                                    class="text-sm text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] transition-colors">
                                                    <i class="fas fa-tools mr-1"></i> Matériaux nécessaires
                                                </button>
                                            </div>
                                        </template>
                                        
                                        <template x-if="needsVolunteers">
                                            <div>
                                                <button type="button" @click="activeTab = 'volunteers'" 
                                                    class="text-sm text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] transition-colors">
                                                    <i class="fas fa-users mr-1"></i> Bénévoles nécessaires
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                                
                                <div class="pt-4 border-t">
                                    <div class="flex flex-col space-y-3">
                                        <button type="submit" 
                                            class="w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                            <i class="fas fa-save mr-2"></i> Enregistrer le projet
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            window.Alpine.data('projectForm', () => ({
                activeTab: 'general',
                needsMaterials: false,
                needsVolunteers: false,
                materialsTabShown: false,
                volunteersTabShown: false,
                materialCounter: 0,
                roleCounter: 0,
                progressVersion: 0,
        
                init() {
                    this.setupImagePreview();
                    this.setupLivePreview();
                    this.setupDynamicMaterials();
                    this.setupDynamicRoles();
                    this.setupProgressTracking();
                },
        
                setupImagePreview() {
                    const imageInput = document.getElementById('image');
                    const imagePreview = document.getElementById('image-preview');
                    
                    if (imageInput) {
                        imageInput.addEventListener('change', function() {
                            if (this.files && this.files[0]) {
                                const reader = new FileReader();
                                reader.onload = (e) => {
                                    imagePreview.src = e.target.result;
                                };
                                reader.readAsDataURL(this.files[0]);
                            }
                        });
                    }
                },
        
                setupLivePreview() {
                    const nameInput = document.getElementById('name');
                    const shortDescInput = document.getElementById('short_description');
                    const startDateInput = document.getElementById('start_date');
                    const endDateInput = document.getElementById('end_date');
                    const moneyGoalInput = document.getElementById('money_goal');
                    
                    const previewName = document.getElementById('preview-name');
                    const previewDescription = document.getElementById('preview-description');
                    const previewDates = document.getElementById('preview-dates');
                    const previewGoal = document.getElementById('preview-goal');
                    
                    if (nameInput) {
                        nameInput.addEventListener('input', function() {
                            previewName.textContent = this.value || 'Nom du projet';
                        });
                    }
                    
                    if (shortDescInput) {
                        shortDescInput.addEventListener('input', function() {
                            previewDescription.textContent = this.value || 'Description courte du projet...';
                        });
                    }
                    
                    const updateDates = () => {
                        const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                        const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                        
                        if (startDate && endDate) {
                            const formattedStart = startDate.toLocaleDateString('fr-FR');
                            const formattedEnd = endDate.toLocaleDateString('fr-FR');
                            previewDates.textContent = `${formattedStart} - ${formattedEnd}`;
                        } else {
                            previewDates.textContent = '00/00/0000 - 00/00/0000';
                        }
                    };
                    
                    if (startDateInput) startDateInput.addEventListener('change', updateDates);
                    if (endDateInput) endDateInput.addEventListener('change', updateDates);
                    
                    if (moneyGoalInput) {
                        moneyGoalInput.addEventListener('input', function() {
                            previewGoal.textContent = this.value ? `${this.value} €` : '0 €';
                        });
                    }
                },
        
                setupDynamicMaterials() {
                    const materialsContainer = document.getElementById('materials-container');
                    const addMaterialBtn = document.getElementById('add-material');
                    
                    if (addMaterialBtn) {
                        addMaterialBtn.addEventListener('click', () => {
                            this.materialCounter++;
                            const newMaterial = document.createElement('div');
                            newMaterial.className = 'material-item p-4 border rounded-lg';
                            newMaterial.innerHTML = `
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-primary-black">Matériau #${this.materialCounter}</h4>
                                    <button type="button" class="remove-material text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class=" text-sm font-medium text-primary-gray-dark mb-2">Catégorie <span class="text-[var(--primary-red)]">*</span></label>
                                        <select name="materials[${this.materialCounter-1}][material_category_id]" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                            <option value="" disabled selected>Sélectionnez une catégorie</option>
                                            @foreach($materialCategories ?? [
                                                ['id' => 1, 'name' => 'Outils'],
                                                ['id' => 2, 'name' => 'Matériaux de construction'],
                                                ['id' => 3, 'name' => 'Plantes et végétaux'],
                                                ['id' => 4, 'name' => 'Peinture et décoration'],
                                                ['id' => 5, 'name' => 'Équipement électrique'],
                                            ] as $category)
                                                <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class=" text-sm font-medium text-primary-gray-dark mb-2">Informations supplémentaires</label>
                                        <input type="text" name="materials[${this.materialCounter-1}][additional]" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            placeholder="Précisions, quantité, etc.">
                                    </div>
                                </div>
                            `;
                            materialsContainer.appendChild(newMaterial);
                            
                            const removeBtn = newMaterial.querySelector('.remove-material');
                            removeBtn.addEventListener('click', () => {
                                newMaterial.remove();
                                this.updateMaterialIndexes();
                            });
                        });
                    }
                    
                    if (materialsContainer) {
                        materialsContainer.addEventListener('click', (e) => {
                            if (e.target.closest('.remove-material')) {
                                const materialItem = e.target.closest('.material-item');
                                materialItem.remove();
                                this.updateMaterialIndexes();
                            }
                        });
                    }
                },
        
                setupDynamicRoles() {
                    const rolesContainer = document.getElementById('roles-container');
                    const addRoleBtn = document.getElementById('add-role');
                    
                    if (addRoleBtn) {
                        addRoleBtn.addEventListener('click', () => {
                            this.roleCounter++;
                            const newRole = document.createElement('div');
                            newRole.className = 'role-item p-4 border rounded-lg';
                            newRole.innerHTML = `
                                <div class="flex justify-between items-center mb-3">
                                    <h4 class="font-medium text-primary-black">Rôle #${this.roleCounter}</h4>
                                    <button type="button" class="remove-role text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class=" text-sm font-medium text-primary-gray-dark mb-2">Nom du rôle <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="text" name="roles[${this.roleCounter-1}][name]" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            placeholder="Ex: Jardinier, Coordinateur, etc.">
                                    </div>
                                    
                                    <div>
                                        <label class=" text-sm font-medium text-primary-gray-dark mb-2">Description <span class="text-[var(--primary-red)]">*</span></label>
                                        <textarea name="roles[${this.roleCounter-1}][description]" rows="3" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            placeholder="Décrivez les responsabilités et compétences requises..."></textarea>
                                    </div>
                                    
                                    <div>
                                        <label class=" text-sm font-medium text-primary-gray-dark mb-2">Heures de bénévolat nécessaires <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="number" name="roles[${this.roleCounter-1}][volunteer_hours_needed]" min="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            placeholder="Nombre d'heures">
                                    </div>
                                </div>
                            `;
                            rolesContainer.appendChild(newRole);
                            
                            const removeBtn = newRole.querySelector('.remove-role');
                            removeBtn.addEventListener('click', () => {
                                newRole.remove();
                                this.updateRoleIndexes();
                            });
                        });
                    }
                    
                    if (rolesContainer) {
                        rolesContainer.addEventListener('click', (e) => {
                            if (e.target.closest('.remove-role')) {
                                const roleItem = e.target.closest('.role-item');
                                roleItem.remove();
                                this.updateRoleIndexes();
                            }
                        });
                    }
                },
        
                updateMaterialIndexes() {
                    const materialItems = document.querySelectorAll('.material-item');
                    materialItems.forEach((item, index) => {
                        const heading = item.querySelector('h4');
                        heading.textContent = `Matériau #${index + 1}`;
                        
                        const categorySelect = item.querySelector('select');
                        categorySelect.name = `materials[${index}][material_category_id]`;
                        
                        const additionalInput = item.querySelector('input[type="text"]');
                        additionalInput.name = `materials[${index}][additional]`;
                    });
                },
        
                updateRoleIndexes() {
                    const roleItems = document.querySelectorAll('.role-item');
                    roleItems.forEach((item, index) => {
                        const heading = item.querySelector('h4');
                        heading.textContent = `Rôle #${index + 1}`;
                        
                        const nameInput = item.querySelector('input[type="text"]');
                        nameInput.name = `roles[${index}][name]`;
                        
                        const descriptionTextarea = item.querySelector('textarea');
                        descriptionTextarea.name = `roles[${index}][description]`;
                        
                        const hoursInput = item.querySelector('input[type="number"]');
                        hoursInput.name = `roles[${index}][volunteer_hours_needed]`;
                    });
                },
                
                calculateGlobalCompletion() {
                    // This line ensures the function is re-evaluated when progressVersion changes
                    const version = this.progressVersion;
                    
                    let totalFields = 0;
                    let filledFields = 0;

                    const isFilled = (el) => {
                        if (!el) return false;
                        if (el.type === 'checkbox' || el.type === 'radio') {
                            return el.checked;
                        }
                        // For selects, check if a non-default option is selected
                        if (el.tagName === 'SELECT') {
                            return el.selectedIndex > 0;
                        }
                        return el.value && el.value.trim() !== '';
                    };

                    // Count general fields
                    const generalFieldIds = [
                        'name', 'short_description', 'description',
                        'start_date', 'end_date', 'money_goal', 'status'
                    ];

                    generalFieldIds.forEach(id => {
                        const field = document.getElementById(id);
                        if (field) {
                            totalFields++;
                            if (isFilled(field)) filledFields++;
                        }
                    });
                    
                    // Count volunteer_hour_goal only if needsVolunteers is checked
                    if (this.needsVolunteers) {
                        const volunteerHourGoal = document.getElementById('volunteer_hour_goal');
                        if (volunteerHourGoal) {
                            totalFields++;
                            if (isFilled(volunteerHourGoal)) filledFields++;
                        }
                    }

                    // Count materials fields if needsMaterials is checked
                    if (this.needsMaterials) {
                        const materialItems = document.querySelectorAll('.material-item');
                        materialItems.forEach(item => {
                            const category = item.querySelector('select');
                            if (category) {
                                totalFields++;
                                if (isFilled(category)) filledFields++;
                            }
                        });
                    }

                    // Count volunteers fields if needsVolunteers is checked
                    if (this.needsVolunteers) {
                        const roleItems = document.querySelectorAll('.role-item');
                        roleItems.forEach(item => {
                            const name = item.querySelector('input[type="text"]');
                            const description = item.querySelector('textarea');
                            const hours = item.querySelector('input[type="number"]');

                            if (name) {
                                totalFields++;
                                if (isFilled(name)) filledFields++;
                            }
                            if (description) {
                                totalFields++;
                                if (isFilled(description)) filledFields++;
                            }
                            if (hours) {
                                totalFields++;
                                if (isFilled(hours)) filledFields++;
                            }
                        });
                    }

                    return totalFields > 0 ? Math.round((filledFields / totalFields) * 100) : 0;
                },

                setupProgressTracking() {
                    // Create a reactive property to force updates
                    this.progressVersion = 0;
                    
                    // Function to trigger progress update
                    const updateProgress = () => {
                        // Increment the version to force Alpine to re-evaluate
                        this.progressVersion++;
                    };
                    
                    // Add input event listeners to all form fields
                    const addFieldListeners = (parent = document) => {
                        parent.querySelectorAll('input, select, textarea').forEach(field => {
                            field.addEventListener('input', updateProgress);
                            field.addEventListener('change', updateProgress);
                            // For checkboxes and radios
                            if (field.type === 'checkbox' || field.type === 'radio') {
                                field.addEventListener('click', updateProgress);
                            }
                        });
                    };
                    
                    // Initial setup for existing fields
                    addFieldListeners();
                    
                    // Setup observers for dynamically added content
                    const setupContainerObserver = (containerId, fieldSelector) => {
                        const container = document.getElementById(containerId);
                        if (!container) return;
                        
                        // Observer for when items are added/removed
                        const observer = new MutationObserver((mutations) => {
                            mutations.forEach(mutation => {
                                if (mutation.type === 'childList') {
                                    // New nodes were added or removed
                                    updateProgress();
                                    
                                    // Add listeners to any new fields
                                    mutation.addedNodes.forEach(node => {
                                        if (node.nodeType === 1) { // Element node
                                            addFieldListeners(node);
                                        }
                                    });
                                }
                            });
                        });
                        
                        // Start observing
                        observer.observe(container, { 
                            childList: true,
                            subtree: true
                        });
                        
                        // Add event delegation for dynamically added fields
                        container.addEventListener('input', updateProgress, true);
                        container.addEventListener('change', updateProgress, true);
                        container.addEventListener('click', (e) => {
                            if (e.target.closest(fieldSelector)) {
                                updateProgress();
                            }
                        }, true);
                    };
                    
                    // Setup observers for materials and roles containers
                    setupContainerObserver('materials-container', '.material-item');
                    setupContainerObserver('roles-container', '.role-item');
                    
                    // Force update when tabs change
                    this.$watch('activeTab', () => updateProgress());
                    this.$watch('needsMaterials', () => updateProgress());
                    this.$watch('needsVolunteers', () => updateProgress());
                },

        }));
    });
</script>
</x-app-layout>

