@extends('layouts.app')

@section('header', 'Rapports mensuels')

@section('content')
<div class="space-y-8">
    <!-- Header Vibrant / Titre Brillant -->
    <div class="bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 p-6 rounded-3xl border border-purple-900/40 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1 relative z-10">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-purple-500/20 text-purple-300 border border-purple-400/30">
                Édition Mensuelle
            </span>
            <h1 class="text-3xl font-black font-display text-white tracking-tight">
                Rapports <span class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 via-pink-300 to-amber-300">Mensuels</span>
            </h1>
            <p class="text-xs text-slate-300 font-medium">Bilan comptable et suivi de l'évolution mensuelle des dépenses</p>
        </div>

        <div class="relative z-10 flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('reports.index') }}" class="flex items-center gap-2">
                <input type="month" name="month" value="{{ $month }}" class="px-4 py-2 border border-slate-700 bg-slate-800 text-white rounded-xl text-xs font-bold" />
                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-xl transition-all">
                    Changer de mois
                </button>
            </form>

            <div class="flex items-center gap-3 border-l border-purple-800/60 pl-3">
                <!-- Bouton PDF en ROUGE -->
                <a href="{{ route('reports.pdf', ['month' => $month]) }}" target="_blank" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-rose-500/20 transition-all flex items-center gap-1.5">
                    Export PDF
                </a>

                <!-- Bouton Excel en VERT -->
                <a href="{{ route('reports.excel', ['month' => $month]) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-emerald-500/20 transition-all flex items-center gap-1.5">
                    Export Excel
                </a>
            </div>
        </div>
    </div>

    <!-- Indicateurs du mois -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Dépenses (Mois sélectionné)</span>
            <p class="text-3xl font-black text-purple-600 dark:text-purple-400 font-display">
                {{ number_format($totalDepensesMois, 0, ',', ' ') }} <span class="text-xs font-bold text-slate-400">FCFA</span>
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Mois Précédent</span>
            <p class="text-3xl font-black text-slate-600 dark:text-slate-300 font-display">
                {{ number_format($totalDepensesMoisPrecedent, 0, ',', ' ') }} <span class="text-xs font-bold text-slate-400">FCFA</span>
            </p>
        </div>

        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Évolution par rapport au mois M-1</span>
            <p class="text-3xl font-black {{ $evolutionDepenses <= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-display">
                {{ $evolutionDepenses > 0 ? '+' : '' }}{{ number_format($evolutionDepenses, 1) }} %
            </p>
        </div>
    </div>

    <!-- Tableau des Dépenses du mois -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden space-y-4">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Détail des Dépenses Validées du Mois</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Date</th>
                        <th class="px-6 py-3.5">Projet</th>
                        <th class="px-6 py-3.5">Catégorie</th>
                        <th class="px-6 py-3.5">Description</th>
                        <th class="px-6 py-3.5">Déclaré par</th>
                        <th class="px-6 py-3.5 text-right">Montant</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($depensesMois as $depense)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4 text-xs font-bold text-slate-600 dark:text-slate-300">{{ $depense->date }}</td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-900 dark:text-white">{{ $depense->projet->nom ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300">{{ $depense->categorie->nom ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $depense->description }}</td>
                        <td class="px-6 py-4 text-xs text-slate-500 dark:text-slate-400">{{ $depense->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-right font-black text-slate-900 dark:text-white">{{ number_format($depense->montant, 0, ',', ' ') }} FCFA</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-xs font-medium">
                            Aucune dépense validée enregistrée pour ce mois.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
