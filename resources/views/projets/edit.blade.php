@extends('layouts.app')

@section('header', 'Modifier le Projet')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white font-display">Modifier le Projet</h1>
            <p class="text-xs text-slate-400 mt-1">Mise à jour des informations et du devis estimatif initial</p>
        </div>
        <a href="{{ route('projets.show', $projet) }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs rounded-xl transition-all">
            &larr; Annuler
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold space-y-1">
            @foreach ($errors->all() as $error)
                <p>&bull; {{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('projets.update', $projet) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Section 1 : Informations Générales & Client -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <h2 class="text-sm font-extrabold text-blue-600 dark:text-blue-400 uppercase tracking-wider">1. Informations Générales & Coordonnées Client</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="nom" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Nom du Projet *</label>
                    <input type="text" id="nom" name="nom" value="{{ old('nom', $projet->nom) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600" />
                </div>

                <div>
                    <label for="client" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Nom du Client *</label>
                    <input type="text" id="client" name="client" value="{{ old('client', $projet->client) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600" />
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-200/60 dark:border-slate-700/60">
                <div>
                    <label for="client_email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Adresse Email du Client</label>
                    <input type="email" id="client_email" name="client_email" value="{{ old('client_email', $projet->client_email) }}" placeholder="ex: client@entreprise.com"
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600" />
                </div>

                <div>
                    <label for="client_telephone" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Téléphone / WhatsApp du Client</label>
                    <input type="text" id="client_telephone" name="client_telephone" value="{{ old('client_telephone', $projet->client_telephone) }}" placeholder="ex: +225 07 00 00 00 00"
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600" />
                </div>
            </div>

            <div>
                <label for="description" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Description / Objectifs</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium focus:ring-2 focus:ring-blue-500/20 focus:border-blue-600">{{ old('description', $projet->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="date_debut" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Date de Début *</label>
                    <input type="date" id="date_debut" name="date_debut" value="{{ old('date_debut', $projet->date_debut) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>

                <div>
                    <label for="date_fin_prevue" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Date de Fin Prévisionnelle *</label>
                    <input type="date" id="date_fin_prevue" name="date_fin_prevue" value="{{ old('date_fin_prevue', $projet->date_fin_prevue) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>

                <div>
                    <label for="statut" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Statut du Projet *</label>
                    <select id="statut" name="statut" required class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium">
                        <option value="en_cours" {{ old('statut', $projet->statut) === 'en_cours' ? 'selected' : '' }}>En cours</option>
                        <option value="en_pause" {{ old('statut', $projet->statut) === 'en_pause' ? 'selected' : '' }}>En pause</option>
                        <option value="termine" {{ old('statut', $projet->statut) === 'termine' ? 'selected' : '' }}>Terminé / Clôturé</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Section 2 : Devis Estimatif Initial -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <h2 class="text-sm font-extrabold text-blue-600 dark:text-blue-400 uppercase tracking-wider">2. Devis Estimatif Initial (FCFA)</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="main_oeuvre" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Main d'œuvre (FCFA) *</label>
                    <input type="number" step="0.01" min="0" id="main_oeuvre" name="main_oeuvre" value="{{ old('main_oeuvre', $projet->devis->main_oeuvre ?? 0) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>

                <div>
                    <label for="materiel" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Matériel & Équipements (FCFA) *</label>
                    <input type="number" step="0.01" min="0" id="materiel" name="materiel" value="{{ old('materiel', $projet->devis->materiel ?? 0) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>

                <div>
                    <label for="transport" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Transport & Logistique (FCFA) *</label>
                    <input type="number" step="0.01" min="0" id="transport" name="transport" value="{{ old('transport', $projet->devis->transport ?? 0) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>

                <div>
                    <label for="autres_couts" class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Autres Coûts / Divers (FCFA) *</label>
                    <input type="number" step="0.01" min="0" id="autres_couts" name="autres_couts" value="{{ old('autres_couts', $projet->devis->autres_couts ?? 0) }}" required
                           class="w-full px-4 py-2.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-sm font-medium" />
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('projets.show', $projet) }}" class="px-5 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-300 font-bold text-sm rounded-xl transition-all">
                Annuler
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-500/20 transition-all">
                Enregistrer les Modifications
            </button>
        </div>
    </form>
</div>
@endsection
