<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Depense;
use App\Models\CategorieDepense;
use Illuminate\Http\Request;

class StatistiqueController extends Controller
{
    public function index()
    {
        $projets = Projet::with(['devis', 'depenses'])->get();
        $categories = CategorieDepense::with('depenses')->get();

        $depensesParCategorie = $categories->map(function ($cat) {
            $total = $cat->depenses->where('statut_validation', 'validee')->sum('montant');
            return [
                'nom' => $cat->nom,
                'total' => $total,
            ];
        });

        $totalDevisGlobal = $projets->sum('total_revenus');
        $totalDepensesGlobal = $projets->sum('total_depenses');
        $margeNetteGlobale = $totalDevisGlobal - $totalDepensesGlobal;

        return view('statistiques.index', compact(
            'projets',
            'depensesParCategorie',
            'totalDevisGlobal',
            'totalDepensesGlobal',
            'margeNetteGlobale'
        ));
    }
}
