@extends('layouts.app')

@section('header', 'Gestion des Utilisateurs')

@section('content')
<div class="space-y-8">
    <!-- Header Vibrant / Titre Brillant -->
    <div class="bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-6 rounded-3xl border border-blue-900/40 shadow-xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div class="space-y-1 relative z-10">
            <span class="px-3 py-1 rounded-full text-[10px] font-extrabold uppercase tracking-widest bg-blue-500/20 text-blue-300 border border-blue-400/30">
                Administration & Contrôle d'Accès (RBAC)
            </span>
            <h1 class="text-3xl font-black font-display text-white tracking-tight">
                Gestion des <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-indigo-300">Utilisateurs</span>
            </h1>
            <p class="text-xs text-slate-300 font-medium">Gestion des comptes, attribution des privilèges et des rôles système</p>
        </div>

        <button onclick="document.getElementById('modal-add-user').classList.remove('hidden')" class="relative z-10 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs rounded-xl shadow-lg shadow-blue-500/20 transition-all">
            + Nouvel Utilisateur
        </button>
    </div>

    <!-- Tableau des Utilisateurs -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-6 py-3.5">Nom Complet</th>
                        <th class="px-6 py-3.5">Adresse Email</th>
                        <th class="px-6 py-3.5">Rôle Système</th>
                        <th class="px-6 py-3.5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-xs text-slate-600 dark:text-slate-300">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->isAdmin())
                                <span class="px-3 py-1 text-[10px] font-extrabold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200">Administrateur</span>
                            @elseif($user->isProjectManager())
                                <span class="px-3 py-1 text-[10px] font-extrabold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300 border border-purple-200">Chef de Projet</span>
                            @else
                                <span class="px-3 py-1 text-[10px] font-extrabold rounded-full bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 border border-slate-200">Collaborateur</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('Confirmer la suppression de cet utilisateur ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:text-rose-800 font-bold">Supprimer</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Nouvel Utilisateur -->
<div id="modal-add-user" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-50 flex items-center justify-center hidden">
    <div class="bg-white dark:bg-slate-800 rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl border border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
            <h3 class="text-base font-extrabold text-slate-900 dark:text-white font-display">Créer un Utilisateur</h3>
            <button onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="text-slate-400 font-bold">&times;</button>
        </div>

        <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Nom Complet *</label>
                <input type="text" name="name" required class="w-full px-4 py-2 border rounded-xl text-sm font-medium dark:bg-slate-900 dark:text-white" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Adresse Email *</label>
                <input type="email" name="email" required class="w-full px-4 py-2 border rounded-xl text-sm font-medium dark:bg-slate-900 dark:text-white" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Mot de Passe *</label>
                <input type="password" name="password" required class="w-full px-4 py-2 border rounded-xl text-sm font-medium dark:bg-slate-900 dark:text-white" />
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">Rôle Système *</label>
                <select name="role" required class="w-full px-4 py-2 border rounded-xl text-sm font-medium dark:bg-slate-900 dark:text-white">
                    <option value="collaborateur">Collaborateur</option>
                    <option value="chef_de_projet">Chef de Projet</option>
                    <option value="administrateur">Administrateur</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <button type="button" onclick="document.getElementById('modal-add-user').classList.add('hidden')" class="px-4 py-2 bg-slate-100 text-slate-700 font-bold text-xs rounded-xl">Annuler</button>
                <button type="submit" class="px-5 py-2 bg-blue-600 text-white font-bold text-xs rounded-xl">Créer le Compte</button>
            </div>
        </form>
    </div>
</div>
@endsection
