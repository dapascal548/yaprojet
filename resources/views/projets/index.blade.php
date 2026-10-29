@extends('layouts.app')

@section('header', 'Gestion des Projets')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white font-display">Liste des Projets</h1>
            <p class="text-xs text-slate-400 mt-1">Consultez et suivez la rentabilité de tous les projets enregistrés</p>
        </div>

        @if(auth()->user()->isAdmin() || auth()->user()->isProjectManager())
            <a href="{{ route('projets.create') }}" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-500/20 transition-all">
                + Nouveau Projet
            </a>
        @endif
    </div>

    <!-- Filtres & Recherche -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm">
        <form method="GET" action="{{ route('projets.index') }}" class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher nom ou client..."
                       class="w-full px-4 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-xs font-medium" />
            </div>

            <div>
                <select name="statut" class="w-full px-4 py-2 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-xs font-medium">
                    <option value="">Tous les statuts</option>
                    <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="en_pause" {{ request('statut') === 'en_pause' ? 'selected' : '' }}>En pause</option>
                    <option value="termine" {{ request('statut') === 'termine' ? 'selected' : '' }}>Terminé</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="px-4 py-2 bg-slate-900 dark:bg-slate-700 text-white font-bold text-xs rounded-xl">
                    Filtrer
                </button>
                @if(request()->hasAny(['search', 'statut', 'annee']))
                    <a href="{{ route('projets.index') }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 font-bold text-xs rounded-xl">
                        Réinitialiser
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tableau des Projets -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Projet</th>
                        <th class="px-6 py-3.5">Client & Contact</th>
                        <th class="px-6 py-3.5">Devis Initial</th>
                        <th class="px-6 py-3.5">Dépenses Validées</th>
                        <th class="px-6 py-3.5">Marge Nette</th>
                        <th class="px-6 py-3.5">Statut</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($projets as $projet)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900 dark:text-white">{{ $projet->nom }}</p>
                            <p class="text-[10px] text-slate-400">Du {{ $projet->date_debut }} au {{ $projet->date_fin_prevue }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $projet->client }}</p>
                            @if($projet->client_email)
                                <p class="text-[11px] text-slate-400">Email: {{ $projet->client_email }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-blue-600 dark:text-blue-400">{{ number_format($projet->total_revenus, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4 font-bold text-rose-600 dark:text-rose-400">{{ number_format($projet->total_depenses, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4 font-bold {{ $projet->resultat >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ number_format($projet->resultat, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4">
                            @if($projet->statut === 'en_cours')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-50 text-blue-600 border border-blue-200">En cours</span>
                            @elseif($projet->statut === 'en_pause')
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-200">En pause</span>
                            @else
                                <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">Terminé</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('projets.show', $projet) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                Consulter &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400 text-xs font-medium">
                            Aucun projet correspondant à vos critères de recherche.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $projets->links() }}
        </div>
    </div>
</div>
@endsection
