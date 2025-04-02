@vite(['resources/css/app.css', 'resources/js/app.js'])

<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between mb-12 px-6 py-4 bg-white rounded-lg shadow-sm border border-[var(--primary-gray-light)]">
                <!-- Bouton de retour avec icône flèche -->
                <a href="{{ route('projets') }}" class="flex items-center text-[var(--primary-black)] hover:text-[var(--primary-green)] transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span class="font-medium">Retour au projet</span>
                </a>
            
                <!-- Message central -->
                <div class="text-center flex-grow">
                    <h1 class="text-2xl md:text-3xl font-bold text-[var(--primary-green-dark)] mb-1">Contribuer au projet</h1>
                    <p class="text-[var(--primary-green)] text-sm md:text-base">Votre soutien fait la différence</p>
                </div>
            
                <!-- Espace vide pour équilibrer le layout -->
                <div class="w-24"></div>
            </div>

            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Left side - Project details -->
                <div class="lg:w-2/3 space-y-6">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/3">
                                <img class="w-full h-48 object-cover rounded-lg" src="{{ asset('images/' . $projet->image) }}" alt="{{ $projet->name }}">
                            </div>
                            <div class="md:w-2/3">
                                <h2 class="text-2xl font-bold text-primary-black mb-2">{{ $projet->name }}</h2>
                                <p class="text-primary-gray-dark mb-4">{{ $projet->description }}</p>
                                
                                <div class="mb-4">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full" 
                                             style="width: {{ min(100, ($projet->totalAmount / $projet->goal ) * 100) }}%;
                                             background-color: 
                                             @if(($projet->totalAmount / $projet->goal) * 100 < 25)
                                                 var(--primary-green-superlight)
                                             @elseif(($projet->totalAmount / $projet->goal) * 100 < 50)
                                                 var(--primary-green-light)
                                             @elseif(($projet->totalAmount / $projet->goal) * 100 < 75)
                                                 var(--primary-green)
                                             @else
                                                 var(--primary-green-dark)
                                             @endif">
                                        </div>
                                    </div>
                                    <div class="flex justify-between mt-2 text-sm text-primary-gray">
                                        <span>{{ number_format($projet->totalAmount, 0, ',', ' ') }} € collectés</span>
                                        <span>Objectif : {{ number_format($projet->goal, 0, ',', ' ') }} €</span>
                                    </div>
                                </div>
                                
                                <div class="flex flex-wrap items-center gap-4 text-sm text-primary-gray-dark">
                                    <span class="flex items-center"><i class="fas fa-calendar-alt mr-1"></i> {{ $projet->end_date->format('d/m/Y') }}</span>
                                    <span class="flex items-center"><i class="fas fa-users mr-1"></i> {{ $projet->contributions->count() }} contributeurs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6">
                        <h3 class="text-xl font-semibold text-primary-black mb-4">À propos du projet</h3>
                        <p class="text-primary-gray-dark whitespace-pre-line">{{ $projet->description }}</p>
                    </div>
                </div>

                <!-- Right side - Contribution form -->
                <div class="lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-md overflow-hidden p-6 sticky top-6">
                        <h3 class="text-xl font-semibold text-primary-black mb-4">Faire un don</h3>
                        <p class="text-primary-gray-dark mb-6">Choisissez comment vous souhaitez contribuer</p>
                        
                        <!-- Tabs for donation types -->
                        <div x-data="{ activeTab: 'financial' }" class="mb-6">
                            <div class="flex border-b border-gray-200">
                                <button 
                                    @click="activeTab = 'financial'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'financial', 'border-transparent text-primary-gray-dark': activeTab !== 'financial' }"
                                    class="flex-1 py-2 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    Financier
                                </button>
                                <button 
                                    @click="activeTab = 'material'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'material', 'border-transparent text-primary-gray-dark': activeTab !== 'material' }"
                                    class="flex-1 py-2 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    Matériel
                                </button>
                                <button 
                                    @click="activeTab = 'volunteer'" 
                                    :class="{ 'border-[var(--primary-green)] text-[var(--primary-green-dark)]': activeTab === 'volunteer', 'border-transparent text-primary-gray-dark': activeTab !== 'volunteer' }"
                                    class="flex-1 py-2 px-4 font-medium border-b-2 transition-colors focus:outline-none"
                                >
                                    Bénévolat
                                </button>
                            </div>
                            
                            <!-- Financial donation form -->
                            <div x-show="activeTab === 'financial'" class="mt-6">
                                <form action="{{ route('projets.contribute.submit', $projet->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="donation_type" value="financial">
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2" for="amount">
                                            Montant (€)
                                        </label>
                                        <div class="grid grid-cols-4 gap-2 mb-4">
                                            <button type="button" class="amount-btn py-2 px-4 bg-[var(--primary-green-superlight)] text-[var(--primary-green-dark)] rounded-lg hover:bg-[var(--primary-green-light)] transition">10€</button>
                                            <button type="button" class="amount-btn py-2 px-4 bg-[var(--primary-green-superlight)] text-[var(--primary-green-dark)] rounded-lg hover:bg-[var(--primary-green-light)] transition">25€</button>
                                            <button type="button" class="amount-btn py-2 px-4 bg-[var(--primary-green-superlight)] text-[var(--primary-green-dark)] rounded-lg hover:bg-[var(--primary-green-light)] transition">50€</button>
                                            <button type="button" class="amount-btn py-2 px-4 bg-[var(--primary-green-superlight)] text-[var(--primary-green-dark)] rounded-lg hover:bg-[var(--primary-green-light)] transition">100€</button>
                                        </div>
                                        <input type="number" id="amount" name="amount" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                            placeholder="Autre montant" min="1" required>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2" for="message">
                                            Message de soutien (optionnel)
                                        </label>
                                        <textarea id="message" name="message" rows="3" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Écrivez un message d'encouragement..."></textarea>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="flex items-center">
                                            <input type="checkbox" name="anonymous" class="rounded text-[var(--primary-green)] focus:ring-[var(--primary-green)]">
                                            <span class="ml-2 text-sm text-primary-gray-dark">Contribuer anonymement</span>
                                        </label>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-heart mr-2"></i> Contribuer maintenant
                                    </button>
                                    
                                    <div class="mt-6 text-center text-sm text-primary-gray">
                                        <p>100% sécurisé - Paiement par carte bancaire</p>
                                    </div>
                                </form>
                            </div>
                            
                            <!-- Material donation form -->
                            <div x-show="activeTab === 'material'" class="mt-6">
                                <form action="{{ route('projets.contribute.submit', $projet->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="donation_type" value="material">
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2">
                                            Matériel dont nous avons besoin
                                        </label>
                                        <div class="space-y-3 mb-4">
                                            @foreach($materiels ?? [
                                                ['id' => 1, 'name' => 'Outils de jardinage', 'description' => 'Pelles, râteaux, etc.'],
                                                ['id' => 2, 'name' => 'Matériaux de construction', 'description' => 'Bois, vis, clous'],
                                                ['id' => 3, 'name' => 'Plantes et arbustes', 'description' => 'Espèces locales adaptées'],
                                                ['id' => 4, 'name' => 'Peinture écologique', 'description' => 'Pour les structures']
                                            ] as $materiel)
                                                <div class="flex items-start space-x-3 p-3 rounded-lg border">
                                                    <input 
                                                        type="checkbox" 
                                                        id="materiel-{{ $materiel['id'] }}" 
                                                        name="materiels[]" 
                                                        value="{{ $materiel['id'] }}"
                                                        class="rounded text-[var(--primary-green)] focus:ring-[var(--primary-green)] mt-1"
                                                    >
                                                    <div>
                                                        <label for="materiel-{{ $materiel['id'] }}" class="font-medium text-primary-black">
                                                            {{ $materiel['name'] }}
                                                        </label>
                                                        <p class="text-sm text-primary-gray-dark">{{ $materiel['description'] }}</p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        
                                        <div>
                                            <label class="block text-primary-gray-dark text-sm font-medium mb-2" for="custom_material">
                                                Autre matériel (précisez)
                                            </label>
                                            <textarea 
                                                id="custom_material" 
                                                name="custom_material" 
                                                rows="3"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                                placeholder="Décrivez le matériel que vous souhaitez donner..."
                                            ></textarea>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2">
                                            Vos coordonnées
                                        </label>
                                        <div class="grid grid-cols-1 gap-4">
                                            <input 
                                                type="text" 
                                                name="name" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Nom complet" 
                                                required
                                            >
                                            <input 
                                                type="email" 
                                                name="email" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Email" 
                                                required
                                            >
                                            <input 
                                                type="tel" 
                                                name="phone" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Téléphone" 
                                                required
                                            >
                                        </div>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-heart mr-2"></i> Proposer un don matériel
                                    </button>
                                </form>
                            </div>
                            
                            <!-- Volunteer form -->
                            <div x-show="activeTab === 'volunteer'" class="mt-6">
                                <form action="{{ route('projets.contribute.submit', $projet->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="donation_type" value="volunteer">
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2" for="role">
                                            Rôle souhaité
                                        </label>
                                        <select 
                                            id="role" 
                                            name="role" 
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            required
                                        >
                                            <option value="" disabled selected>Sélectionnez un rôle</option>
                                            @foreach($roles ?? [
                                                ['id' => 1, 'name' => 'Jardinage', 'description' => 'Plantation et entretien des espaces verts'],
                                                ['id' => 2, 'name' => 'Construction', 'description' => 'Aide à l\'assemblage des structures'],
                                                ['id' => 3, 'name' => 'Coordination', 'description' => 'Organisation des équipes de bénévoles'],
                                                ['id' => 4, 'name' => 'Communication', 'description' => 'Promotion du projet sur les réseaux sociaux']
                                            ] as $role)
                                                <option value="{{ $role['id'] }}">{{ $role['name'] }} - {{ $role['description'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2">
                                            Disponibilité
                                        </label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div class="space-y-2">
                                                <p class="text-sm font-medium">Jours</p>
                                                <div class="space-y-2">
                                                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                                                        <div class="flex items-center space-x-2">
                                                            <input 
                                                                type="checkbox" 
                                                                id="day-{{ $day }}" 
                                                                name="days[]" 
                                                                value="{{ $day }}"
                                                                class="rounded text-[var(--primary-green)] focus:ring-[var(--primary-green)]"
                                                            >
                                                            <label for="day-{{ $day }}" class="text-sm text-primary-gray-dark">{{ $day }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-sm font-medium">Périodes</p>
                                                <div class="space-y-2">
                                                    @foreach(['Matin', 'Après-midi', 'Soirée'] as $period)
                                                        <div class="flex items-center space-x-2">
                                                            <input 
                                                                type="checkbox" 
                                                                id="period-{{ $period }}" 
                                                                name="periods[]" 
                                                                value="{{ $period }}"
                                                                class="rounded text-[var(--primary-green)] focus:ring-[var(--primary-green)]"
                                                            >
                                                            <label for="period-{{ $period }}" class="text-sm text-primary-gray-dark">{{ $period }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2" for="skills">
                                            Compétences et expérience
                                        </label>
                                        <textarea 
                                            id="skills" 
                                            name="skills" 
                                            rows="3"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]"
                                            placeholder="Décrivez vos compétences et expériences pertinentes..."
                                        ></textarea>
                                    </div>
                                    
                                    <div class="mb-6">
                                        <label class="block text-primary-gray-dark text-sm font-medium mb-2">
                                            Vos coordonnées
                                        </label>
                                        <div class="grid grid-cols-1 gap-4">
                                            <input 
                                                type="text" 
                                                name="name" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Nom complet" 
                                                required
                                            >
                                            <input 
                                                type="email" 
                                                name="email" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Email" 
                                                required
                                            >
                                            <input 
                                                type="tel" 
                                                name="phone" 
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-[var(--primary-green)] focus:border-[var(--primary-green)]" 
                                                placeholder="Téléphone" 
                                                required
                                            >
                                        </div>
                                    </div>
                                    
                                    <button type="submit" 
                                            class="w-full bg-[var(--primary-green)] hover:bg-[var(--primary-green-dark)] text-white font-medium py-3 px-4 rounded-lg transition duration-300 flex items-center justify-center">
                                        <i class="fas fa-heart mr-2"></i> Proposer mon aide
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Amount buttons functionality
            const amountInput = document.getElementById('amount');
            const amountButtons = document.querySelectorAll('.amount-btn');
            
            amountButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    amountButtons.forEach(btn => {
                        btn.classList.remove('bg-[var(--primary-green)]', 'text-white');
                        btn.classList.add('bg-[var(--primary-green-superlight)]', 'text-[var(--primary-green-dark)]');
                    });
                    
                    // Add active class to clicked button
                    this.classList.remove('bg-[var(--primary-green-superlight)]', 'text-[var(--primary-green-dark)]');
                    this.classList.add('bg-[var(--primary-green)]', 'text-white');
                    
                    // Set amount value
                    const amount = this.textContent.replace('€', '').trim();
                    amountInput.value = amount;
                });
            });
        });
    </script>
</x-app-layout>