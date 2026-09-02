@extends('layouts.app')

@section('header', 'Tableau de bord')

@section('content')
<div class="space-y-8">
    <!-- Stat Cards Header -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Card 1: Projets Actifs -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Projets Actifs</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-black text-slate-900 dark:text-white font-display">{{ $projetsActifs }}</span>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-blue-50 text-blue-600 dark:bg-blue-950/50 dark:text-blue-400">En cours</span>
            </div>
        </div>

        <!-- Card 2: Projets Terminés -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Projets Terminés</span>
            <div class="flex items-baseline justify-between">
                <span class="text-3xl font-black text-slate-900 dark:text-white font-display">{{ $projetsTermines }}</span>
                <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-emerald-50 text-emerald-600 dark:bg-emerald-950/50 dark:text-emerald-400">Clôturés</span>
            </div>
        </div>

        <!-- Card 3: Dépenses Validées -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Dépenses Validées</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-rose-600 dark:text-rose-400 font-display">{{ number_format($totalDepensesValidees, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>

        <!-- Card 4: Dépenses En Attente -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider">Dépenses En Attente</span>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-amber-500 font-display">{{ number_format($totalDepensesEnAttente, 0, ',', ' ') }} FCFA</span>
            </div>
        </div>
    </div>

    <!-- Recent Projects Table -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Projets Récents</h3>
                <p class="text-xs text-slate-400 mt-0.5">Dernières activités enregistrées sur la plateforme</p>
            </div>
            <a href="{{ route('projets.index') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all">
                Voir tous les projets
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Nom du Projet</th>
                        <th class="px-6 py-3.5">Client</th>
                        <th class="px-6 py-3.5">Devis Estimatif</th>
                        <th class="px-6 py-3.5">Dépenses Validées</th>
                        <th class="px-6 py-3.5">Marge Nette</th>
                        <th class="px-6 py-3.5">Statut</th>
                        <th class="px-6 py-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($projetsRecents as $projet)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $projet->nom }}</td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400">{{ $projet->client }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300">{{ number_format($projet->total_revenus, 0, ',', ' ') }} FCFA</td>
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
                                Consulter
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-slate-400 text-xs font-medium">
                            Aucun projet enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
