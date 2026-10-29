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

    public function exportPdf(Request $request)
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

        // Si la classe DomPDF de Laravel est installée et disponible
        if (class_exists('\Barryvdh\DomPDF\Facade\Pdf')) {
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reports.pdf', compact(
                'month',
                'depensesMois',
                'totalDepensesMois',
                'totalDepensesMoisPrecedent',
                'evolutionDepenses',
                'projetsActifs'
            ));
            return $pdf->download("Rapport_Mensuel_{$month}.pdf");
        }

        // Vue imprimable optimisée PDF avec déclencheur automatique de sauvegarde PDF navigateur
        return view('reports.pdf', compact(
            'month',
            'depensesMois',
            'totalDepensesMois',
            'totalDepensesMoisPrecedent',
            'evolutionDepenses',
            'projetsActifs'
        ));
    }

    public function exportExcel(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));
        $startDate = Carbon::parse($month)->startOfMonth();
        $endDate = Carbon::parse($month)->endOfMonth();

        $depensesMois = Depense::with(['projet', 'categorie', 'user'])
            ->where('statut_validation', 'validee')
            ->whereBetween('date', [$startDate, $endDate])
            ->get();

        $filename = "Rapport_Mensuel_{$month}.csv";

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($depensesMois, $month) {
            $file = fopen('php://output', 'w');
            // Inclusion du BOM UTF-8 pour une ouverture directe parfaite dans Microsoft Excel avec accents
            fputs($file, "\xEF\xBB\xBF");

            // Lignes d'en-tête du document Excel
            fputcsv($file, ['GESPRO - RAPPORT FINANCIAL MENSUEL', "Mois: {$month}"], ';');
            fputcsv($file, [], ';');
            fputcsv($file, ['Date', 'Projet', 'Client', 'Catégorie de Charge', 'Description / Motif', 'Déclaré par', 'Montant TTC (FCFA)'], ';');

            $total = 0;
            foreach ($depensesMois as $depense) {
                $total += $depense->montant;
                fputcsv($file, [
                    $depense->date,
                    $depense->projet->nom ?? 'N/A',
                    $depense->projet->client ?? 'N/A',
                    $depense->categorie->nom ?? 'N/A',
                    $depense->description,
                    $depense->user->name ?? 'N/A',
                    number_format($depense->montant, 0, ',', ' '),
                ], ';');
            }

            fputcsv($file, [], ';');
            fputcsv($file, ['TOTAL CUMULÉ DU MOIS', '', '', '', '', '', number_format($total, 0, ',', ' ') . ' FCFA'], ';');

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
