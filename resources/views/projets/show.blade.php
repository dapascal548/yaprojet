@extends('layouts.app')

@section('header', 'Détails du Projet')

@section('content')
<div class="space-y-6">
    <!-- Notifications Flash -->
    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-sm font-semibold flex items-center justify-between shadow-sm">
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold space-y-1">
            @foreach($errors->all() as $error)
                <p>&bull; {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Header du Projet -->
    <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-black text-slate-900 dark:text-white font-display">{{ $projet->nom }}</h1>
                @if($projet->statut === 'en_cours')
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-blue-50 text-blue-600 border border-blue-200">En cours</span>
                @elseif($projet->statut === 'en_pause')
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-200">En pause</span>
                @else
                    <span class="px-3 py-1 text-xs font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">Terminé / Clôturé</span>
                @endif
            </div>
            <p class="text-xs text-slate-400 mt-1 font-medium">Créé par {{ $projet->user->name ?? 'Système' }} &bull; Du {{ $projet->date_debut }} au {{ $projet->date_fin_prevue }}</p>
        </div>

        <div class="flex items-center gap-2">
            @if($projet->statut !== 'termine' && (auth()->user()->isAdmin() || auth()->user()->isProjectManager()))
                <button onclick="document.getElementById('modal-close-projet').classList.remove('hidden')" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all">
                    Clôturer le Projet
                </button>
            @endif

            @if(auth()->user()->isAdmin() || auth()->user()->isProjectManager())
                <a href="{{ route('projets.edit', $projet) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all">
                    Modifier
                </a>
            @endif

            <a href="{{ route('projets.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all">
                &larr; Retour
            </a>
        </div>
    </div>

    <!-- Coordonnées Client -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Client -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Coordonnées du Client</h3>
            <div class="space-y-1">
                <p class="text-lg font-black text-slate-900 dark:text-white">{{ $projet->client }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-300 font-medium">Email: {{ $projet->client_email ?? 'Non renseigné' }}</p>
                <p class="text-xs text-slate-600 dark:text-slate-300 font-medium">Tél: {{ $projet->client_telephone ?? 'Non renseigné' }}</p>
            </div>
        </div>

        <!-- Card Devis Estimatif Total -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Devis Estimatif Initial (Revenus)</h3>
            <p class="text-2xl font-black text-blue-600 dark:text-blue-400 font-display">{{ number_format($projet->total_revenus, 0, ',', ' ') }} FCFA</p>
            <div class="text-[11px] text-slate-400 space-y-0.5">
                <p>MO: {{ number_format($projet->devis->main_oeuvre ?? 0, 0, ',', ' ') }} FCFA &bull; Matériel: {{ number_format($projet->devis->materiel ?? 0, 0, ',', ' ') }} FCFA</p>
                <p>Trans: {{ number_format($projet->devis->transport ?? 0, 0, ',', ' ') }} FCFA &bull; Divers: {{ number_format($projet->devis->autres_couts ?? 0, 0, ',', ' ') }} FCFA</p>
            </div>
        </div>

        <!-- Card Bilan Financier actuel -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold text-slate-400 uppercase tracking-wider">Marge Nette (Résultat)</h3>
            <p class="text-2xl font-black {{ $projet->resultat >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-display">
                {{ number_format($projet->resultat, 0, ',', ' ') }} FCFA
            </p>
            <p class="text-xs text-slate-400">Dépenses validées : {{ number_format($projet->total_depenses, 0, ',', ' ') }} FCFA</p>
        </div>
    </div>

    <!-- Section Dépenses -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Dépenses Opérationnelles de Terrain</h3>
                <p class="text-xs text-slate-400 mt-0.5">Déclarations soumises par les collaborateurs</p>
            </div>

            @if($projet->statut !== 'termine' && (auth()->user()->isAdmin() || auth()->user()->isProjectManager()))
                <button onclick="document.getElementById('modal-add-depense').classList.remove('hidden')" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-sm transition-all">
                    + Déclarer une Dépense
                </button>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Date</th>
                        <th class="px-6 py-3.5">Catégorie</th>
                        <th class="px-6 py-3.5">Déclaré par</th>
                        <th class="px-6 py-3.5">Description</th>
                        <th class="px-6 py-3.5">Justificatif</th>
                        <th class="px-6 py-3.5">Montant TTC</th>
                        <th class="px-6 py-3.5">Statut</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($projet->depenses as $depense)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4 text-xs font-bold text-slate-600 dark:text-slate-300">{{ $depense->date }}</td>
                        <td class="px-6 py-4 text-xs text-slate-700 dark:text-slate-300 font-bold">{{ $depense->categorie->nom ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $depense->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300">{{ $depense->description }}</td>
                        <td class="px-6 py-4 text-xs">
                            @if($depense->justificatif)
                                <a href="{{ asset('storage/' . $depense->justificatif) }}" target="_blank" class="text-blue-600 dark:text-blue-400 font-bold hover:underline flex items-center gap-1">
                                    Voir Fichier
                                </a>
                            @else
                                <span class="text-slate-400 italic">Aucun</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-black text-slate-900 dark:text-white">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">
                            @if($depense->statut_validation === 'validee')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">Validée</span>
                            @elseif($depense->statut_validation === 'rejetee')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-rose-50 text-rose-600 border border-rose-200">Rejetée</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-200">En attente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            @if($depense->statut_validation === 'en_attente' && (auth()->user()->isAdmin() || auth()->user()->isProjectManager()))
                                <form method="POST" action="{{ route('depenses.validate', $depense) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 bg-emerald-600 text-white font-bold text-[10px] rounded-lg hover:bg-emerald-700">
                                        Valider
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('depenses.reject', $depense) }}" class="inline">
                                    @csrf
                                    <button type="submit" class="px-2.5 py-1 bg-rose-600 text-white font-bold text-[10px] rounded-lg hover:bg-rose-700">
                                        Rejeter
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400 text-xs font-medium">
                            Aucune dépense enregistrée sur ce projet.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Déclaration de Dépense -->
<div id="modal-add-depense" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-lg w-full p-6 space-y-4 shadow-xl border border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Déclarer une Dépense</h3>
            <button onclick="document.getElementById('modal-add-depense').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('depenses.store', $projet) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="categorie_id" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Catégorie de Charge *</label>
                <select id="categorie_id" name="categorie_id" required class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium">
                    <option value="">Sélectionnez une catégorie...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="montant" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Montant TTC (FCFA) *</label>
                <input type="number" step="0.01" min="0" id="montant" name="montant" required placeholder="Ex: 50000" class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
            </div>

            <div>
                <label for="date" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Date de la dépense *</label>
                <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Motif / Description *</label>
                <textarea id="description" name="description" rows="2" required placeholder="Détails du motif..." class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium"></textarea>
            </div>

            <div>
                <label for="justificatif" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Fichier Justificatif (PDF, JPG, PNG)</label>
                <input type="file" id="justificatif" name="justificatif" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-depense').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Annuler</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl">Soumettre en attente</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Clôture de Projet -->
<div id="modal-close-projet" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl border border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Clôturer le Projet</h3>
            <button onclick="document.getElementById('modal-close-projet').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('projets.close', $projet) }}" class="space-y-4">
            @csrf

            <p class="text-xs text-slate-600 dark:text-slate-300">
                Vous êtes sur le point d'officialiser la livraison et l'achèvement de ce projet.
            </p>

            <div>
                <label for="date_fin_reelle" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Date de Fin Réelle *</label>
                <input type="date" id="date_fin_reelle" name="date_fin_reelle" value="{{ date('Y-m-d') }}" required class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-close-projet').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Annuler</button>
                <button type="submit" class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm">Confirmer la Clôture</button>
            </div>
        </form>
    </div>
</div>
@endsection
