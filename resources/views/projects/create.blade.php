vite(['resources/css/app.css', 'resources/js/app.js'])

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

            <form action="{{ route('projets.store') }}" method="POST" enctype="multipart/form-data" x-data="{ activeTab: 'general' }">
                @csrf
                
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Left side - Form tabs -->
                    <div class="lg:w-2/3 space-y-6">
                        <!-- Tabs navigation -->
                        <div class="bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="flex border-b border-gray-200">
                                <button 
                                    type="button"
                                    @click="activeTab = 'general'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'general', 'border-transparent text-primary-gray-dark': activeTab !== 'general' }"
                                    class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    <i class="fas fa-info-circle mr-2"></i> Informations générales
                                </button>
                                <button 
                                    type="button"
                                    @click="activeTab = 'materials'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'materials', 'border-transparent text-primary-gray-dark': activeTab !== 'materials' }"
                                    class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    <i class="fas fa-tools mr-2"></i> Matériaux nécessaires
                                </button>
                                <button 
                                    type="button"
                                    @click="activeTab = 'volunteers'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'volunteers', 'border-transparent text-primary-gray-dark': activeTab !== 'volunteers' }"
                                    class="flex-1 py-3 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    <i class="fas fa-users mr-2"></i> Rôles bénévoles
                                </button>
                            </div>
                        </div>

                        <!-- General Information Tab -->
                        <div x-show="activeTab === 'general'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-6">Informations du projet</h3>
                            
                            <div class="space-y-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-primary-gray-dark mb-2">Nom du projet <span class="text-[var(--primary-red)]">*</span></label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    @error('name')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="short_description" class="block text-sm font-medium text-primary-gray-dark mb-2">Description courte <span class="text-[var(--primary-red)]">*</span></label>
                                    <input type="text" id="short_description" name="short_description" value="{{ old('short_description') }}" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    @error('short_description')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="description" class="block text-sm font-medium text-primary-gray-dark mb-2">Description détaillée <span class="text-[var(--primary-red)]">*</span></label>
                                    <textarea id="description" name="description" rows="6" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">{{ old('description') }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="start_date" class="block text-sm font-medium text-primary-gray-dark mb-2">Date de début <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('start_date')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="end_date" class="block text-sm font-medium text-primary-gray-dark mb-2">Date de fin <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('end_date')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="money_goal" class="block text-sm font-medium text-primary-gray-dark mb-2">Objectif financier (€) <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="number" id="money_goal" name="money_goal" value="{{ old('money_goal') }}" min="0" step="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('money_goal')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="volunteer_hour_goal" class="block text-sm font-medium text-primary-gray-dark mb-2">Objectif d'heures de bénévolat <span class="text-[var(--primary-red)]">*</span></label>
                                        <input type="number" id="volunteer_hour_goal" name="volunteer_hour_goal" value="{{ old('volunteer_hour_goal') }}" min="0" step="1" required
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        @error('volunteer_hour_goal')
                                            <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="status" class="block text-sm font-medium text-primary-gray-dark mb-2">Statut <span class="text-[var(--primary-red)]">*</span></label>
                                    <select id="status" name="status" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Brouillon</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>En attente de validation</option>
                                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Actif</option>
                                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Terminé</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="image" class="block text-sm font-medium text-primary-gray-dark mb-2">Image du projet</label>
                                    <input type="file" id="image" name="image" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]">
                                    <p class="mt-1 text-sm text-primary-gray">Format recommandé : JPG, PNG. Max 2MB.</p>
                                    @error('image')
                                        <p class="mt-1 text-sm text-[var(--primary-red)]">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Materials Tab -->
                        <div x-show="activeTab === 'materials'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-primary-black">Matériaux nécessaires</h3>
                                <button type="button" id="add-material" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary-green)]">
                                    <i class="fas fa-plus mr-2"></i> Ajouter
                                </button>
                            </div>
                            
                            <div id="materials-container" class="space-y-4">
                                <div class="material-item p-4 border rounded-lg">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-medium text-primary-black">Matériau #1</h4>
                                        <button type="button" class="remove-material text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Catégorie <span class="text-[var(--primary-red)]">*</span></label>
                                            <select name="materials[0][material_category_id]" required
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
                                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Informations supplémentaires</label>
                                            <input type="text" name="materials[0][additional]" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Précisions, quantité, etc.">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-sm text-primary-gray-dark">
                                <p><i class="fas fa-info-circle mr-1"></i> Ajoutez tous les matériaux dont vous aurez besoin pour ce projet.</p>
                            </div>
                        </div>

                        <!-- Volunteers Tab -->
                        <div x-show="activeTab === 'volunteers'" class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="text-xl font-semibold text-primary-black">Rôles bénévoles</h3>
                                <button type="button" id="add-role" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary-green)]">
                                    <i class="fas fa-plus mr-2"></i> Ajouter
                                </button>
                            </div>
                            
                            <div id="roles-container" class="space-y-4">
                                <div class="role-item p-4 border rounded-lg">
                                    <div class="flex justify-between items-center mb-3">
                                        <h4 class="font-medium text-primary-black">Rôle #1</h4>
                                        <button type="button" class="remove-role text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Nom du rôle <span class="text-[var(--primary-red)]">*</span></label>
                                            <input type="text" name="roles[0][name]" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Ex: Jardinier, Coordinateur, etc.">
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Description <span class="text-[var(--primary-red)]">*</span></label>
                                            <textarea name="roles[0][description]" rows="3" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Décrivez les responsabilités et compétences requises..."></textarea>
                                        </div>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Heures de bénévolat nécessaires <span class="text-[var(--primary-red)]">*</span></label>
                                            <input type="number" name="roles[0][volunteer_hours_needed]" min="1" required
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Nombre d'heures">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-4 text-sm text-primary-gray-dark">
                                <p><i class="fas fa-info-circle mr-1"></i> Définissez tous les rôles bénévoles nécessaires pour ce projet.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right side - Preview and actions -->
                    <div class="lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 sticky top-6">
                            <h3 class="text-xl font-semibold text-primary-black mb-4">Aperçu du projet</h3>
                            
                            <div class="space-y-4 mb-6">
                                <div class="aspect-video bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    <img id="image-preview" src="{{ isset($project->image) ? asset('images/' . $project->image) : asset('images/greenPot.png') }}" alt="Aperçu du projet" class="w-auto h-full object-center">                                
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-primary-black" id="preview-name">Nom du projet</h4>
                                    <p class="text-sm text-primary-gray-dark" id="preview-description">Description courte du projet...</p>
                                </div>
                                
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-primary-gray-dark">
                                        <i class="fas fa-calendar-alt mr-1"></i> <span id="preview-dates">00/00/0000 - 00/00/0000</span>
                                    </span>
                                    <span class="text-primary-gray-dark">
                                        <i class="fas fa-coins mr-1"></i> <span id="preview-goal">0 €</span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-medium text-primary-black mb-2">Progression</h4>
                                    <div class="flex items-center justify-between">
                                        <button type="button" @click="activeTab = 'general'" 
                                            class="text-sm text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] transition-colors">
                                            <i class="fas fa-check-circle mr-1"></i> Informations générales
                                        </button>
                                        <span class="text-xs text-primary-gray-dark" x-text="activeTab === 'general' ? 'En cours' : (activeTab === 'materials' || activeTab === 'volunteers' ? 'Complété' : 'À faire')">À faire</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <button type="button" @click="activeTab = 'materials'" 
                                            class="text-sm text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] transition-colors">
                                            <i class="fas fa-tools mr-1"></i> Matériaux nécessaires
                                        </button>
                                        <span class="text-xs text-primary-gray-dark" x-text="activeTab === 'materials' ? 'En cours' : (activeTab === 'volunteers' ? 'Complété' : 'À faire')">À faire</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <button type="button" @click="activeTab = 'volunteers'" 
                                            class="text-sm text-[var(--primary-green)] hover:text-[var(--primary-green-dark)] transition-colors">
                                            <i class="fas fa-users mr-1"></i> Rôles bénévoles
                                        </button>
                                        <span class="text-xs text-primary-gray-dark" x-text="activeTab === 'volunteers' ? 'En cours' : 'À faire'">À faire</span>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('image-preview');
            console.log(imagePreview.src);
            if (imagePreview.src.includes('placeholder-project.jpg')) {
                imagePreview.src = "{{ asset('images/greenPot.png') }}";
            }

           
            
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
            
            // Live preview updates
            const nameInput = document.getElementById('name');
            const shortDescInput = document.getElementById('short_description');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const moneyGoalInput = document.getElementById('money_goal');
            
            const previewName = document.getElementById('preview-name');
            const previewDescription = document.getElementById('preview-description');
            const previewDates = document.getElementById('preview-dates');
            const previewGoal = document.getElementById('preview-goal');
            
            nameInput.addEventListener('input', function() {
                previewName.textContent = this.value || 'Nom du projet';
            });
            
            shortDescInput.addEventListener('input', function() {
                previewDescription.textContent = this.value || 'Description courte du projet...';
            });
            
            function updateDates() {
                const startDate = startDateInput.value ? new Date(startDateInput.value) : null;
                const endDate = endDateInput.value ? new Date(endDateInput.value) : null;
                
                if (startDate && endDate) {
                    const formattedStart = startDate.toLocaleDateString('fr-FR');
                    const formattedEnd = endDate.toLocaleDateString('fr-FR');
                    previewDates.textContent = `${formattedStart} - ${formattedEnd}`;
                } else {
                    previewDates.textContent = '00/00/0000 - 00/00/0000';
                }
            }
            
            startDateInput.addEventListener('change', updateDates);
            endDateInput.addEventListener('change', updateDates);
            
            moneyGoalInput.addEventListener('input', function() {
                previewGoal.textContent = this.value ? `${this.value} €` : '0 €';
            });
            
            // Dynamic materials
            let materialCounter = 1;
            const materialsContainer = document.getElementById('materials-container');
            const addMaterialBtn = document.getElementById('add-material');
            
            addMaterialBtn.addEventListener('click', function() {
                materialCounter++;
                const newMaterial = document.createElement('div');
                newMaterial.className = 'material-item p-4 border rounded-lg';
                newMaterial.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-primary-black">Matériau #${materialCounter}</h4>
                        <button type="button" class="remove-material text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Catégorie <span class="text-[var(--primary-red)]">*</span></label>
                            <select name="materials[${materialCounter-1}][material_category_id]" required
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
                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Informations supplémentaires</label>
                            <input type="text" name="materials[${materialCounter-1}][additional]" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                placeholder="Précisions, quantité, etc.">
                        </div>
                    </div>
                `;
                materialsContainer.appendChild(newMaterial);
                
                // Add event listener to the new remove button
                const removeBtn = newMaterial.querySelector('.remove-material');
                removeBtn.addEventListener('click', function() {
                    newMaterial.remove();
                    updateMaterialIndexes();
                });
            });
            
            // Event delegation for remove material buttons
            materialsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-material')) {
                    const materialItem = e.target.closest('.material-item');
                    materialItem.remove();
                    updateMaterialIndexes();
                }
            });
            
            function updateMaterialIndexes() {
                const materialItems = document.querySelectorAll('.material-item');
                materialItems.forEach((item, index) => {
                    const heading = item.querySelector('h4');
                    heading.textContent = `Matériau #${index + 1}`;
                    
                    const categorySelect = item.querySelector('select');
                    categorySelect.name = `materials[${index}][material_category_id]`;
                    
                    const additionalInput = item.querySelector('input[type="text"]');
                    additionalInput.name = `materials[${index}][additional]`;
                });
            }
            
            // Dynamic volunteer roles
            let roleCounter = 1;
            const rolesContainer = document.getElementById('roles-container');
            const addRoleBtn = document.getElementById('add-role');
            
            addRoleBtn.addEventListener('click', function() {
                roleCounter++;
                const newRole = document.createElement('div');
                newRole.className = 'role-item p-4 border rounded-lg';
                newRole.innerHTML = `
                    <div class="flex justify-between items-center mb-3">
                        <h4 class="font-medium text-primary-black">Rôle #${roleCounter}</h4>
                        <button type="button" class="remove-role text-[var(--primary-red)] hover:text-[var(--primary-red-dark)]">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Nom du rôle <span class="text-[var(--primary-red)]">*</span></label>
                            <input type="text" name="roles[${roleCounter-1}][name]" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                placeholder="Ex: Jardinier, Coordinateur, etc.">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Description <span class="text-[var(--primary-red)]">*</span></label>
                            <textarea name="roles[${roleCounter-1}][description]" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                placeholder="Décrivez les responsabilités et compétences requises..."></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-primary-gray-dark mb-2">Heures de bénévolat nécessaires <span class="text-[var(--primary-red)]">*</span></label>
                            <input type="number" name="roles[${roleCounter-1}][volunteer_hours_needed]" min="1" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                placeholder="Nombre d'heures">
                        </div>
                    </div>
                `;
                rolesContainer.appendChild(newRole);
                
                // Add event listener to the new remove button
                const removeBtn = newRole.querySelector('.remove-role');
                removeBtn.addEventListener('click', function() {
                    newRole.remove();
                    updateRoleIndexes();
                });
            });
            
            // Event delegation for remove role buttons
            rolesContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-role')) {
                    const roleItem = e.target.closest('.role-item');
                    roleItem.remove();
                    updateRoleIndexes();
                }
            });
            
            function updateRoleIndexes() {
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
            }
            
            // Initial setup for remove buttons
            document.querySelectorAll('.remove-material').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.material-item').remove();
                    updateMaterialIndexes();
                });
            });
            
            document.querySelectorAll('.remove-role').forEach(btn => {
                btn.addEventListener('click', function() {
                    this.closest('.role-item').remove();
                    updateRoleIndexes();
                });
            });
        });
    </script>
</x-app-layout>