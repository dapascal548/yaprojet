<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Depense;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        $prevStartDate = Carbon::parse($month)->subMonth()->startOfMonth();
        $prevEndDate = Carbon::parse($month)->subMonth()->endOfMonth();

        $depensesMois = Depense::with(['projet', 'categorie', 'user'])
            ->where('statut_validation', 'validee')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $totalDepensesMois = $depensesMois->sum('montant');

        $depensesMoisPrecedent = Depense::where('statut_validation', 'validee')
            ->whereBetween('date', [$prevStartDate, $prevEndDate])
            ->get();

        $totalDepensesMoisPrecedent = $depensesMoisPrecedent->sum('montant');

        $evolutionDepenses = $totalDepensesMoisPrecedent > 0
            ? (($totalDepensesMois - $totalDepensesMoisPrecedent) / $totalDepensesMoisPrecedent) * 100
            : 0;

        $projetsActifs = Projet::with('devis')
            ->where('statut', 'en_cours')
            ->get();

        return view('reports.index', compact(
            'month',
            'depensesMois',
            'totalDepensesMois',
            'totalDepensesMoisPrecedent',
            'evolutionDepenses',
            'projetsActifs'
        ));
    }
}
