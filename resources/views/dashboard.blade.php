@extends('layouts.app')

@section('header', 'Tableau de bord')

@section('content')
<div class="space-y-5">
    <!-- Header Compact Vibrant / Titre Brillant -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-4 sm:p-5 rounded-2xl border border-blue-900/40 shadow-md relative overflow-hidden">
        <div class="absolute -right-8 -bottom-8 w-36 h-36 bg-blue-500/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="space-y-0.5 relative z-10">
            <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase tracking-widest bg-blue-500/20 text-blue-300 border border-blue-400/30">
                    Aperçu Temps Réel
                </span>
            </div>
            <h1 class="text-xl sm:text-2xl font-black font-display text-white tracking-tight">
                Tableau de Bord <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-300 to-emerald-400">GESPRO</span>
            </h1>
            <p class="text-[11px] text-slate-300 font-medium">Pilotage analytique et contrôle financier en temps réel</p>
        </div>

        <div class="flex items-center gap-2 relative z-10">
            <a href="{{ route('projets.create') }}" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold text-xs rounded-xl shadow-md shadow-blue-500/20 transition-all transform hover:scale-105">
                + Nouveau Projet
            </a>
        </div>
    </div>

    <!-- Stat Cards Header Compacts (KPIs Brillants avec Effets Hover) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Card 1: Projets Actifs -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 relative overflow-hidden group hover:border-blue-500/60 hover:shadow-blue-500/10 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Projets Actifs</span>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 dark:text-white font-display">{{ $projetsActifs }}</span>
                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                    En cours
                </span>
            </div>
            <div class="w-full h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-blue-500 to-cyan-400" style="width: 75%"></div>
            </div>
        </div>

        <!-- Card 2: Projets Clôturés -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 relative overflow-hidden group hover:border-emerald-500/60 hover:shadow-emerald-500/10 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Projets Clôturés</span>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-2xl font-black text-slate-900 dark:text-white font-display">{{ $projetsTermines }}</span>
                <span class="px-2 py-0.5 text-[10px] font-extrabold rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
                    Livrés
                </span>
            </div>
            <div class="w-full h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-400" style="width: 100%"></div>
            </div>
        </div>

        <!-- Card 3: Dépenses Validées -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 relative overflow-hidden group hover:border-rose-500/60 hover:shadow-rose-500/10 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">Dépenses Validées</span>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-r from-rose-600 to-orange-500 dark:from-rose-400 dark:to-orange-400 font-display">
                    {{ number_format($totalDepensesValidees, 0, ',', ' ') }} <span class="text-[10px] font-bold text-slate-400">FCFA</span>
                </span>
            </div>
            <div class="w-full h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-rose-500 to-orange-400" style="width: 65%"></div>
            </div>
        </div>

        <!-- Card 4: Dépenses En Attente -->
        <div class="bg-white dark:bg-slate-800 p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-2 relative overflow-hidden group hover:border-amber-500/60 hover:shadow-amber-500/10 hover:shadow-lg transition-all transform hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-[11px] font-bold text-slate-400 dark:text-slate-400 uppercase tracking-wider">En Attente de Contrôle</span>
            </div>
            <div class="flex items-baseline justify-between">
                <span class="text-xl font-black text-amber-500 font-display">
                    {{ number_format($totalDepensesEnAttente, 0, ',', ' ') }} <span class="text-[10px] font-bold text-slate-400">FCFA</span>
                </span>
            </div>
            <div class="w-full h-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-amber-400 to-yellow-500" style="width: 35%"></div>
            </div>
        </div>
    </div>

    <!-- Section Graphiques d'Analyse Financière Compacts & Interactifs -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
        <!-- Graphique 1 : Comparatif du Bilan par Projet (Bar Chart sur 2 colonnes) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-800 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2 border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white font-display">Analyse Comparative des Projets</h3>
                    <p class="text-[11px] text-slate-400">Devis Initial vs Dépenses Validées vs Marge Nette (FCFA)</p>
                </div>

                <!-- Boutons d'interactivité dynamique (Filtre des séries du graphique) -->
                <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-900 p-1 rounded-xl">
                    <button onclick="filterChart('all')" id="btn-chart-all" class="px-2.5 py-1 text-[10px] font-extrabold rounded-lg bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-xs transition-all">Tout</button>
                    <button onclick="filterChart('devis')" id="btn-chart-devis" class="px-2.5 py-1 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all">Devis</button>
                    <button onclick="filterChart('depenses')" id="btn-chart-depenses" class="px-2.5 py-1 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all">Dépenses</button>
                    <button onclick="filterChart('marge')" id="btn-chart-marge" class="px-2.5 py-1 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all">Marge</button>
                </div>
            </div>

            <div class="h-60 relative">
                <canvas id="chartBilanProjets"></canvas>
            </div>
        </div>

        <!-- Graphique 2 : Répartition des Dépenses par Catégorie (Doughnut Chart) -->
        <div class="bg-white dark:bg-slate-800 p-4 sm:p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-900 dark:text-white font-display">Répartition des Charges</h3>
                    <p class="text-[11px] text-slate-400">Ventilation par catégorie</p>
                </div>
            </div>

            <div class="h-60 relative flex items-center justify-center">
                <canvas id="chartCategories"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau des Projets Récents avec Filtrage en Direct (Recherche Interactive) -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm space-y-3">
        <div class="p-4 sm:p-5 border-b border-slate-100 dark:border-slate-700 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white font-display">Projets Récents</h3>
                <p class="text-[11px] text-slate-400">Activités & bilan de rentabilité</p>
            </div>

            <div class="flex items-center gap-2 w-full sm:w-auto">
                <!-- Champ de recherche interactive instantanée -->
                <input type="text" id="table-search" onkeyup="filterTable()" placeholder="Filtrer instantanément..."
                       class="px-3 py-1.5 border border-slate-200 dark:border-slate-700 dark:bg-slate-900 dark:text-white rounded-xl text-xs font-medium w-full sm:w-48 focus:ring-2 focus:ring-blue-500/20" />

                <a href="{{ route('projets.index') }}" class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs rounded-xl transition-all whitespace-nowrap">
                    Tous les projets &rarr;
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs" id="projets-table">
                <thead class="bg-slate-50 dark:bg-slate-900/50 text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Projet</th>
                        <th class="px-5 py-3">Client & Contact</th>
                        <th class="px-5 py-3">Devis Initial</th>
                        <th class="px-5 py-3">Dépenses Validées</th>
                        <th class="px-5 py-3">Marge Nette (Résultat)</th>
                        <th class="px-5 py-3">Statut</th>
                        <th class="px-5 py-3 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($projetsRecents as $projet)
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-all project-row">
                        <td class="px-5 py-3 font-bold text-slate-900 dark:text-white project-name">{{ $projet->nom }}</td>
                        <td class="px-5 py-3 project-client">
                            <p class="text-slate-700 dark:text-slate-300 font-bold">{{ $projet->client }}</p>
                            @if($projet->client_email)
                                <p class="text-[10px] text-slate-400">Email: {{ $projet->client_email }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3 font-black text-blue-600 dark:text-blue-400">{{ number_format($projet->total_revenus, 0, ',', ' ') }} FCFA</td>
                        <td class="px-5 py-3 font-black text-rose-600 dark:text-rose-400">{{ number_format($projet->total_depenses, 0, ',', ' ') }} FCFA</td>
                        <td class="px-5 py-3 font-black {{ $projet->resultat >= 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-rose-600 dark:text-rose-400' }}">
                            {{ number_format($projet->resultat, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-5 py-3">
                            @if($projet->statut === 'en_cours')
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-blue-50 text-blue-600 border border-blue-200">En cours</span>
                            @elseif($projet->statut === 'en_pause')
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-amber-50 text-amber-600 border border-amber-200">En pause</span>
                            @else
                                <span class="px-2 py-0.5 text-[9px] font-bold rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">Terminé</span>
                            @endif
                        </td>
                        <td class="px-5 py-3 text-right">
                            <a href="{{ route('projets.show', $projet) }}" class="text-xs font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400">
                                Consulter &rarr;
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-6 text-center text-slate-400 text-xs font-medium">
                            Aucun projet enregistré pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Initialisation des Graphiques & Interactivité JS -->
<script>
let chartBilan = null;

document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const textColor = isDark ? '#94a3b8' : '#64748b';
    const gridColor = isDark ? 'rgba(51, 65, 85, 0.4)' : 'rgba(226, 232, 240, 0.6)';

    const projetsNoms = {!! json_encode($chartProjetsNoms) !!};
    const devisData = {!! json_encode($chartDevisData) !!};
    const depensesData = {!! json_encode($chartDepensesData) !!};
    const resultatsData = {!! json_encode($chartResultatsData) !!};

    const categorieLabels = {!! json_encode($chartCategorieLabels) !!};
    const categorieValues = {!! json_encode($chartCategorieValues) !!};

    // 1. Graphique Bar Chart Comparatif des Projets
    const ctxBar = document.getElementById('chartBilanProjets').getContext('2d');
    chartBilan = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: projetsNoms.length > 0 ? projetsNoms : ['Aucun projet'],
            datasets: [
                {
                    label: 'Devis Initial (FCFA)',
                    data: devisData.length > 0 ? devisData : [0],
                    backgroundColor: '#2563eb',
                    borderRadius: 5,
                },
                {
                    label: 'Dépenses Validées (FCFA)',
                    data: depensesData.length > 0 ? depensesData : [0],
                    backgroundColor: '#e11d48',
                    borderRadius: 5,
                },
                {
                    label: 'Marge Nette (FCFA)',
                    data: resultatsData.length > 0 ? resultatsData : [0],
                    backgroundColor: '#10b981',
                    borderRadius: 5,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { duration: 750, easing: 'easeInOutQuart' },
            plugins: {
                legend: {
                    position: 'top',
                    labels: { color: textColor, font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 } }
                }
            },
            scales: {
                x: {
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 9 } },
                    grid: { color: 'transparent' }
                },
                y: {
                    ticks: { color: textColor, font: { family: 'Plus Jakarta Sans', size: 9 } },
                    grid: { color: gridColor }
                }
            }
        }
    });

    // 2. Graphique Doughnut Répartition par Catégorie
    const ctxDoughnut = document.getElementById('chartCategories').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: categorieLabels.length > 0 ? categorieLabels : ['Aucune dépense'],
            datasets: [{
                data: categorieValues.length > 0 ? categorieValues : [1],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'],
                borderWidth: 2,
                borderColor: isDark ? '#1e293b' : '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: { animateRotate: true, animateScale: true },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { color: textColor, font: { family: 'Plus Jakarta Sans', weight: 'bold', size: 10 } }
                }
            },
            cutout: '68%'
        }
    });
});

// Interactivité 1 : Filtrage des Séries sur le Bar Chart
function filterChart(type) {
    if (!chartBilan) return;

    const btns = ['all', 'devis', 'depenses', 'marge'];
    btns.forEach(b => {
        const btn = document.getElementById(`btn-chart-${b}`);
        if (btn) {
            if (b === type) {
                btn.className = "px-2.5 py-1 text-[10px] font-extrabold rounded-lg bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 shadow-xs transition-all";
            } else {
                btn.className = "px-2.5 py-1 text-[10px] font-extrabold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-all";
            }
        }
    });

    chartBilan.data.datasets.forEach((ds, idx) => {
        if (type === 'all') {
            ds.hidden = false;
        } else if (type === 'devis') {
            ds.hidden = (idx !== 0);
        } else if (type === 'depenses') {
            ds.hidden = (idx !== 1);
        } else if (type === 'marge') {
            ds.hidden = (idx !== 2);
        }
    });
    chartBilan.update();
}

// Interactivité 2 : Recherche & Filtrage instantané dans le tableau
function filterTable() {
    const input = document.getElementById('table-search');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('.project-row');

    rows.forEach(row => {
        const text = row.innerText.toLowerCase();
        if (text.includes(filter)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection
