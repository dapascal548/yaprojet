<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - GESPRO</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:300,400,500,600,700,800|outfit:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                        display: ['Outfit', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="font-sans antialiased text-slate-600 bg-slate-50">
    <div class="min-h-screen flex flex-col lg:flex-row bg-slate-50 font-sans antialiased">
        
        <!-- Colonne Gauche : Section Illustrative & Marketing (Masquée sur Mobile) — 40% de largeur -->
        <div class="hidden lg:flex lg:w-[40%] relative overflow-hidden bg-gradient-to-br from-slate-950 via-slate-900 to-indigo-950 p-12 flex-col justify-between">
            
            <!-- Blobs lumineux animés et floutés d'ambiance en arrière-plan -->
            <div class="absolute top-[-20%] left-[-20%] w-[350px] h-[350px] rounded-full bg-blue-600/20 blur-[100px] pointer-events-none"></div>
            <div class="absolute bottom-[-15%] right-[-15%] w-[350px] h-[350px] rounded-full bg-emerald-500/10 blur-[100px] pointer-events-none"></div>

            <!-- Conteneur regroupant le Logo et le Texte marketing pour les rapprocher -->
            <div class="relative z-10 flex flex-col gap-12">
                <!-- Logo & Identité Visuelle -->
                <div class="flex items-center gap-3.5">
                    <div class="p-1.5 bg-white/10 rounded-2xl border border-white/15 shadow-inner backdrop-blur-md">
                        <img src="/logo.jpg" alt="GESPRO Logo" class="h-10 w-auto object-contain rounded-xl" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-2xl font-black text-white tracking-tight font-display leading-none">GESPRO</span>
                        <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">Plateforme Analytique</span>
                    </div>
                </div>

                <!-- Slogan & Carte Interactive Premium -->
                <div class="max-w-sm space-y-8">
                    <!-- Titre accrocheur et descriptif -->
                    <div class="text-left space-y-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-300 text-[10px] font-bold uppercase tracking-wider">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400 animate-pulse"></span>
                            Version 1.2 Stable
                        </span>
                        <h2 class="text-3xl font-black text-white leading-tight tracking-tight font-display">
                            Pilotez la rentabilité de vos projets.
                        </h2>
                        <p class="text-slate-300 text-xs md:text-sm font-normal leading-relaxed">
                            Suivez les devis initiaux, enregistrez chaque dépense et analysez les bénéfices de vos projets en temps réel.
                        </p>
                    </div>

                    <!-- Maquette Interactive de Carte de Projet (Design premium verre dépoli) -->
                    <div class="bg-white/[0.04] backdrop-blur-xl border border-white/10 rounded-3xl p-6 shadow-2xl relative overflow-hidden transition-all duration-500 hover:scale-[1.02] hover:bg-white/[0.06] hover:border-white/15">
                        <!-- Ligne lumineuse supérieure -->
                        <div class="absolute top-0 left-0 right-0 h-[1.5px] bg-gradient-to-r from-transparent via-blue-500/50 to-transparent"></div>
                        
                        <div class="flex justify-between items-start mb-4">
                            <div>
                               <span class="text-[9px] text-indigo-400 font-extrabold uppercase tracking-widest block mb-1">PROJET ACTIF</span>
                               <h3 class="font-bold text-white text-base font-display">Siège Social Yaconsulting</h3>
                            </div>
                            <span class="px-2.5 py-0.5 text-[9px] font-bold rounded-full bg-emerald-500/15 text-emerald-400 border border-emerald-500/20 shadow-sm">
                                En cours
                            </span>
                        </div>

                        <!-- Grille Financière -->
                        <div class="grid grid-cols-2 gap-4 mb-4 text-[11px]">
                            <div>
                                <span class="text-slate-400 text-[9px] font-bold uppercase tracking-wider block mb-0.5">DEVIS ESTIMATIF</span>
                                <span class="font-bold text-white text-sm">45 000 000 FCFA</span>
                            </div>
                            <div>
                                <span class="text-slate-400 text-[9px] font-bold uppercase tracking-wider block mb-0.5">DÉPENSES RÉELLES</span>
                                <span class="font-bold text-rose-400 text-sm">18 250 000 FCFA</span>
                            </div>
                        </div>

                        <!-- Barre de progression de budget -->
                        <div class="space-y-1">
                            <div class="flex justify-between text-[10px] text-slate-300">
                                <span>Consommation budget</span>
                                <span class="font-bold text-white">40.5%</span>
                            </div>
                            <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-blue-500 via-indigo-500 to-emerald-400 h-full rounded-full transition-all duration-1000" style="width: 40.5%"></div>
                            </div>
                        </div>

                        <!-- Marge financière nette -->
                        <div class="mt-4 pt-3 border-t border-white/5 flex justify-between items-center text-xs">
                            <span class="text-slate-400 font-medium">Marge prévisionnelle</span>
                            <span class="text-emerald-400 font-black text-sm tracking-tight font-display">+26 750 000 FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Signature -->
            <div class="relative z-10 text-[10px] text-slate-500 font-semibold tracking-wide mt-8">
                &copy; 2026 GESPRO. Développé par Yaconsulting. Tous droits réservés.
            </div>
        </div>

        <!-- Colonne Droite : Formulaire (Prend toute la largeur sur mobile) — 60% de largeur -->
        <div class="w-full lg:w-[60%] flex flex-col justify-between p-6 sm:p-12 md:p-16 bg-white relative shadow-2xl z-10">
            <div></div>

            <div class="w-full max-w-sm mx-auto">
                @yield('content')
            </div>

            <div class="text-center text-xs text-slate-400 mt-8">
                &copy; 2026 GESPRO. Développé par Yaconsulting. Tous droits réservés.
            </div>
        </div>

    </div>
</body>
</html>
