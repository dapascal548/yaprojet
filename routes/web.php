<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjetController;
use App\Http\Controllers\DepenseController;
use App\Http\Controllers\DevisController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActionLogController;
use App\Models\Projet;
use App\Models\Depense;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $projetsActifs = Projet::where('statut', 'en_cours')->count();
        $projetsPause = Projet::where('statut', 'en_pause')->count();
        $projetsTermines = Projet::where('statut', 'termine')->count();
        $totalDepensesValidees = Depense::where('statut_validation', 'validee')->get()->sum('montant');
        $totalDepensesEnAttente = Depense::where('statut_validation', 'en_attente')->get()->sum('montant');

        $projetsRecents = Projet::with(['devis', 'depenses'])->latest()->take(5)->get();

        // Données pour le graphique comparatif des projets (Bar Chart)
        $tousLesProjets = Projet::with(['devis', 'depenses'])->latest()->take(8)->get();
        $chartProjetsNoms = $tousLesProjets->pluck('nom');
        $chartDevisData = $tousLesProjets->map(fn($p) => $p->total_revenus);
        $chartDepensesData = $tousLesProjets->map(fn($p) => $p->total_depenses);
        $chartResultatsData = $tousLesProjets->map(fn($p) => $p->resultat);

        // Données pour la répartition par catégorie (Doughnut Chart)
        $categoriesStats = \App\Models\CategorieDepense::with(['depenses' => function($q) {
            $q->where('statut_validation', 'validee');
        }])->get();

        $chartCategorieLabels = $categoriesStats->pluck('nom');
        $chartCategorieValues = $categoriesStats->map(fn($c) => $c->depenses->sum('montant'));

        return view('dashboard', compact(
            'projetsActifs',
            'projetsPause',
            'projetsTermines',
            'totalDepensesValidees',
            'totalDepensesEnAttente',
            'projetsRecents',
            'chartProjetsNoms',
            'chartDevisData',
            'chartDepensesData',
            'chartResultatsData',
            'chartCategorieLabels',
            'chartCategorieValues'
        ));
    })->name('dashboard');

    Route::resource('projets', ProjetController::class);
    Route::post('/projets/{projet}/close', [ProjetController::class, 'close'])->name('projets.close');

    Route::post('/projets/{projet}/devis', [DevisController::class, 'store'])->name('devis.store');
    Route::delete('/projets/{projet}/devis', [DevisController::class, 'destroy'])->name('devis.destroy');

    Route::post('/projets/{projet}/depenses', [DepenseController::class, 'store'])->name('depenses.store');
    Route::put('/projets/{projet}/depenses/{depense}', [DepenseController::class, 'update'])->name('depenses.update');
    Route::delete('/projets/{projet}/depenses/{depense}', [DepenseController::class, 'destroy'])->name('depenses.destroy');

    Route::post('/depenses/{depense}/validate', [DepenseController::class, 'validateDepense'])->name('depenses.validate');
    Route::post('/depenses/{depense}/reject', [DepenseController::class, 'rejectDepense'])->name('depenses.reject');

    Route::get('/statistiques', [StatistiqueController::class, 'index'])->name('statistiques.index');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    Route::get('/reports/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/backup', [SettingController::class, 'createBackup'])->name('settings.backup');
    Route::get('/settings/backup/{filename}', [SettingController::class, 'downloadBackup'])->name('settings.download-backup');

    Route::resource('users', UserController::class)->only(['index', 'store', 'destroy']);
    Route::put('/users/{user}/role', [UserController::class, 'updateRole'])->name('users.update-role');

    Route::get('/action-logs', [ActionLogController::class, 'index'])->name('action-logs.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
