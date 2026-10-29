@extends('layouts.app')

@section('header', 'Paramètres')

@section('content')
<div class="space-y-8">
    <!-- Header Vibrant / Titre Brillant -->
    <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 p-6 rounded-3xl border border-slate-700 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1 relative z-10">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-slate-700 text-slate-200 border border-slate-600">
                Configuration & Sauvegardes
            </span>
            <h1 class="text-3xl font-black font-display text-white tracking-tight">
                Paramètres <span class="text-transparent bg-clip-text bg-gradient-to-r from-slate-200 via-cyan-200 to-blue-400">Système</span>
            </h1>
            <p class="text-xs text-slate-300 font-medium">Gestion des sauvegardes de la base de données et paramétrage des catégories de charge</p>
        </div>

        <form method="POST" action="{{ route('settings.backup') }}" class="relative z-10">
            @csrf
            <button type="submit" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-500/20 transition-all">
                Générer une Sauvegarde
            </button>
        </form>
    </div>

    <!-- Section Sauvegardes et Catégories -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card Sauvegardes -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Fichiers de Sauvegarde</h3>
                <p class="text-xs text-slate-400">Archive des copies de sécurité de la base de données</p>
            </div>

            <div class="space-y-2">
                @forelse($backups as $backup)
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200/60 dark:border-slate-700/60">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $backup }}</span>
                    <a href="{{ route('settings.download-backup', $backup) }}" class="text-xs font-bold text-blue-600 dark:text-blue-400 hover:underline">
                        Télécharger
                    </a>
                </div>
                @empty
                <p class="text-xs text-slate-400 italic py-4">Aucune sauvegarde générée pour le moment.</p>
                @endforelse
            </div>
        </div>

        <!-- Card Catégories de Dépenses -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-4">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Catégories de Dépenses</h3>
                <p class="text-xs text-slate-400">Rubriques de charges enregistrées sur le système</p>
            </div>

            <div class="space-y-2">
                @foreach($categories as $cat)
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200/60 dark:border-slate-700/60">
                    <span class="text-xs font-bold text-slate-700 dark:text-slate-300">{{ $cat->nom }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
