<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Projet;
use App\Models\ActionLog;
use Illuminate\Http\Request;

class DevisController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        if ($projet->depenses()->where('statut_validation', 'validee')->exists()) {
            return redirect()->back()->withErrors(['error' => 'Impossible de modifier le devis : des dépenses validées existent.']);
        }

        $validated = $request->validate([
            'main_oeuvre' => 'required|numeric|min:0',
            'materiel' => 'required|numeric|min:0',
            'transport' => 'required|numeric|min:0',
            'autres_couts' => 'required|numeric|min:0',
        ]);

        $devis = $projet->devis()->updateOrCreate(
            ['projet_id' => $projet->id],
            $validated
        );

        ActionLog::log(
            'Mise à jour du devis',
            "Le devis du projet '{$projet->nom}' a été mis à jour pour un total de {$devis->montant_total} FCFA.",
            $devis
        );

        return redirect()->back()->with('success', 'Devis enregistré avec succès.');
    }

    public function destroy(Projet $projet)
    {
        if ($projet->depenses()->where('statut_validation', 'validee')->exists()) {
            return redirect()->back()->withErrors(['error' => 'Impossible de supprimer le devis : des dépenses validées existent.']);
        }

        if ($projet->devis) {
            $projet->devis->delete();
        }

        ActionLog::log(
            'Suppression du devis',
            "Le devis du projet '{$projet->nom}' a été supprimé.",
            $projet
        );

        return redirect()->back()->with('success', 'Devis supprimé.');
    }
}
