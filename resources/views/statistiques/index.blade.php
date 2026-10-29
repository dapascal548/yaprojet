@extends('layouts.app')

@section('header', 'Statistiques')

@section('content')
<div class="space-y-8">
    <!-- Header Vibrant / Titre Brillant -->
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-6 rounded-3xl border border-indigo-900/40 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="space-y-1 relative z-10">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-indigo-500/20 text-indigo-300 border border-indigo-400/30">
                Analytics & Consolidation
            </span>
            <h1 class="text-3xl font-black font-display text-white tracking-tight">
                Statistiques <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-cyan-300 to-emerald-400">Financières</span>
            </h1>
            <p class="text-xs text-slate-300 font-medium">Bilan global cumulé des budgets et répartition des dépenses par poste</p>
        </div>
    </div>

    <!-- Synthèse Globale (KPIs Brillants) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Devis Global -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Devis Global Portefeuille</span>
            <p class="text-3xl font-black text-blue-600 dark:text-blue-400 font-display">
                {{ number_format($totalDevisGlobal, 0, ',', ' ') }} <span class="text-xs font-bold text-slate-400">FCFA</span>
            </p>
            <p class="text-xs text-slate-400">Somme de tous les devis estimatifs d'ouverture</p>
        </div>

        <!-- Card Dépenses Globales -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Total Dépenses Validées</span>
            <p class="text-3xl font-black text-rose-600 dark:text-rose-400 font-display">
                {{ number_format($totalDepensesGlobal, 0, ',', ' ') }} <span class="text-xs font-bold text-slate-400">FCFA</span>
            </p>
            <p class="text-xs text-slate-400">Total des charges opérationnelles approuvées</p>
        </div>

        <!-- Card Marge Nette Globale -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2">
            <span class="text-xs font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Résultat / Marge Nette Globale</span>
            <p class="text-3xl font-black {{ $margeNetteGlobale >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }} font-display">
                {{ number_format($margeNetteGlobale, 0, ',', ' ') }} <span class="text-xs font-bold text-slate-400">FCFA</span>
            </p>
            <p class="text-xs text-slate-400">Bénéfice net consolidé du portefeuille</p>
        </div>
    </div>

    <!-- Ventilation des Dépenses par Catégorie -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden p-6 space-y-6">
        <div>
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Ventilation par Catégorie de Charge</h3>
            <p class="text-xs text-slate-400">Répartition des coûts par rubrique opérationnelle de terrain</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($depensesParCategorie as $cat)
            @php
                $percentage = $totalDepensesGlobal > 0 ? round(($cat['total'] / $totalDepensesGlobal) * 100, 1) : 0;
            @endphp
            <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-xl border border-slate-200/60 dark:border-slate-700/60 space-y-2">
                <div class="flex items-center justify-between text-xs font-bold">
                    <span class="text-slate-900 dark:text-white">{{ $cat['nom'] }}</span>
                    <span class="text-blue-600 dark:text-blue-400">{{ number_format($cat['total'], 0, ',', ' ') }} FCFA ({{ $percentage }}%)</span>
                </div>
                <div class="w-full h-2 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                    <div class="h-full bg-gradient-to-r from-blue-600 to-indigo-500 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
