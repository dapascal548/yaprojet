@extends('layouts.guest')

@section('content')
<!-- Logo et Titre -->
<div class="flex flex-col items-center justify-center mb-6">
    <div class="w-20 h-20 bg-slate-50 border border-slate-100 rounded-2xl p-1 shadow-sm flex items-center justify-center mb-3">
        <img src="/logo.jpg" alt="GESPRO Logo" class="w-full h-full object-contain rounded-xl" />
    </div>
    <h2 class="text-3xl font-black text-slate-900 tracking-tight font-display">GESPRO</h2>
    <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-1">Solution de gestion de projets</p>
</div>

<!-- Message de bienvenue -->
<div class="text-center mb-6 border-t border-slate-100 pt-5">
    <h1 class="text-sm font-bold text-slate-600 tracking-tight">Connexion à votre espace</h1>
    <p class="text-xs text-slate-400 mt-1">Sélectionnez votre statut pour charger les identifiants</p>
</div>

<!-- Notification d'erreur globale -->
@if ($errors->any())
    <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 rounded-2xl text-sm font-semibold flex flex-col gap-1">
        @foreach ($errors->all() as $error)
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span>{{ $error }}</span>
            </div>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}" id="login-form">
    @csrf

    <!-- Rôle de connexion -->
    <input type="hidden" name="role" id="hidden-role" value="administrateur">

    <!-- Étape 1 : Choix du statut -->
    <div class="mb-6">
        <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-3">
            1. Choisissez votre statut de connexion :
        </span>
        <div class="grid grid-cols-1 gap-2.5">
            <!-- Administrateur -->
            <button
                type="button"
                id="btn-admin"
                onclick="selectRole('administrateur', 'admin@gespro.com')"
                class="w-full flex items-center justify-between p-3.5 border rounded-xl transition-all text-left font-bold text-sm bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-100"
            >
                <span>Administrateur</span>
                <span id="badge-admin" class="text-xs text-blue-100 font-medium">Sélectionné</span>
            </button>

            <!-- Chef de projet -->
            <button
                type="button"
                id="btn-chef"
                onclick="selectRole('chef_de_projet', 'chef@gespro.com')"
                class="w-full flex items-center justify-between p-3.5 border border-slate-200 text-slate-800 bg-white hover:bg-slate-50 rounded-xl transition-all text-left font-bold text-sm"
            >
                <span>Chef de Projet</span>
                <span id="badge-chef" class="text-xs text-blue-100 font-medium hidden">Sélectionné</span>
            </button>

            <!-- Collaborateur -->
            <button
                type="button"
                id="btn-collab"
                onclick="selectRole('collaborateur', 'colla@gespro.com')"
                class="w-full flex items-center justify-between p-3.5 border border-slate-200 text-slate-800 bg-white hover:bg-slate-50 rounded-xl transition-all text-left font-bold text-sm"
            >
                <span>Collaborateur</span>
                <span id="badge-collab" class="text-xs text-blue-100 font-medium hidden">Sélectionné</span>
            </button>
        </div>
    </div>

    <!-- Étape 2 : Identifiants -->
    <div class="space-y-4 border-t border-slate-100 pt-5">
        <span class="block text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
            2. Informations d'authentification :
        </span>

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-slate-600 text-xs font-bold mb-1.5">Adresse Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="admin@gespro.com"
                required
                autofocus
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm text-slate-700 font-medium"
            />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-slate-600 text-xs font-bold mb-1.5">Mot de passe</label>
            <input
                id="password"
                type="password"
                name="password"
                value="password"
                required
                autocomplete="current-password"
                class="w-full px-4 py-2.5 border border-slate-200 rounded-xl focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all text-sm text-slate-700 font-medium"
            />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <input
                id="remember_me"
                type="checkbox"
                name="remember"
                class="rounded border-slate-300 text-blue-600 shadow-sm focus:ring-blue-500/20"
            />
            <label for="remember_me" class="ml-2 text-xs text-slate-400 font-medium">Se souvenir de moi</label>
        </div>

        <!-- Action Submit -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-blue-100 hover:shadow-blue-200 transition-all transform active:scale-95"
            >
                Se connecter
            </button>
        </div>
    </div>
</form>

<script>
    function selectRole(role, email) {
        // Enregistrer le rôle dans l'input masqué
        document.getElementById('hidden-role').value = role;

        // Pré-remplir l'email et le mot de passe
        document.getElementById('email').value = email;
        document.getElementById('password').value = 'password';

        // Gérer le style des boutons
        const btns = {
            'administrateur': { btn: 'btn-admin', badge: 'badge-admin' },
            'chef_de_projet': { btn: 'btn-chef', badge: 'badge-chef' },
            'collaborateur': { btn: 'btn-collab', badge: 'badge-collab' }
        };

        for (const [r, els] of Object.entries(btns)) {
            const btnEl = document.getElementById(els.btn);
            const badgeEl = document.getElementById(els.badge);

            if (r === role) {
                btnEl.className = "w-full flex items-center justify-between p-3.5 border rounded-xl transition-all text-left font-bold text-sm bg-blue-600 text-white border-blue-600 shadow-md shadow-blue-100";
                badgeEl.classList.remove('hidden');
            } else {
                btnEl.className = "w-full flex items-center justify-between p-3.5 border border-slate-200 text-slate-800 bg-white hover:bg-slate-50 rounded-xl transition-all text-left font-bold text-sm";
                badgeEl.classList.add('hidden');
            }
        }
    }
</script>
@endsection
