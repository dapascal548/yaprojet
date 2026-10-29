@extends('layouts.app')

@section('header', 'Journal d\'audit')

@section('content')
<div class="space-y-8">
    <!-- Header Vibrant / Titre Brillant -->
    <div class="bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 p-6 rounded-3xl border border-emerald-900/40 shadow-xl relative overflow-hidden">
        <div class="space-y-1 relative z-10">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                Traçabilité & Sécurité
            </span>
            <h1 class="text-3xl font-black font-display text-white tracking-tight">
                Journal <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-cyan-300">d'Audit</span>
            </h1>
            <p class="text-xs text-slate-300 font-medium">Historique chronologique de toutes les actions et transactions enregistrées sur GESPRO</p>
        </div>
    </div>

    <!-- Tableau du Journal d'Audit -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Date & Heure</th>
                        <th class="px-6 py-3.5">Utilisateur</th>
                        <th class="px-6 py-3.5">Type d'Action</th>
                        <th class="px-6 py-3.5">Description de l'Événement</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($logs as $log)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4 text-xs font-bold text-slate-600 dark:text-slate-300">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-900 dark:text-white">{{ $log->user->name ?? 'Système' }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-full bg-blue-50 text-blue-700 dark:bg-blue-950/50 dark:text-blue-300 border border-blue-200">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300">{{ $log->details }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-slate-400 text-xs font-medium">
                            Aucun événement enregistré dans le journal d'audit.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection
