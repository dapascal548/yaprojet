<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use App\Models\Projet;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DepenseController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Projet $projet)
    {
        if (auth()->user()->isCollaborator()) {
            abort(403, "Action non autorisée. Les collaborateurs ont un accès en consultation uniquement.");
        }

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories_depense,id',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'required|string|max:1000',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $justificatifPath = null;
        if ($request->hasFile('justificatif')) {
            $justificatifPath = $request->file('justificatif')->store('justificatifs', 'public');
        }

        $depense = $projet->depenses()->create([
            'user_id' => auth()->id(),
            'categorie_id' => $validated['categorie_id'],
            'montant' => $validated['montant'],
            'date' => $validated['date'],
            'description' => $validated['description'],
            'justificatif' => $justificatifPath,
            'statut_validation' => 'en_attente',
        ]);

        ActionLog::log(
            'Création de dépense',
            "Dépense de {$validated['montant']} FCFA déclarée sur le projet '{$projet->nom}'.",
            $depense
        );

        return redirect()->back()->with('success', 'Dépense enregistrée en attente de validation.');
    }

    public function update(Request $request, Projet $projet, Depense $depense)
    {
        if (auth()->user()->isCollaborator()) {
            abort(403, "Action non autorisée. Les collaborateurs ont un accès en consultation uniquement.");
        }

        if ($depense->statut_validation === 'validee' && !auth()->user()->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'Impossible de modifier une dépense déjà validée.']);
        }

        $validated = $request->validate([
            'categorie_id' => 'required|exists:categories_depense,id',
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'required|string|max:1000',
            'justificatif' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        if ($request->hasFile('justificatif')) {
            $validated['justificatif'] = $request->file('justificatif')->store('justificatifs', 'public');
        }

        $depense->update($validated);

        ActionLog::log(
            'Modification de dépense',
            "Dépense #{$depense->id} modifiée sur le projet '{$projet->nom}'.",
            $depense
        );

        return redirect()->back()->with('success', 'Dépense mise à jour.');
    }

    public function destroy(Projet $projet, Depense $depense)
    {
        if (auth()->user()->isCollaborator()) {
            abort(403, "Action non autorisée. Les collaborateurs ont un accès en consultation uniquement.");
        }

        if ($depense->statut_validation === 'validee' && !auth()->user()->isAdmin()) {
            return redirect()->back()->withErrors(['error' => 'Impossible de supprimer une dépense déjà validée.']);
        }

        $depense->delete();

        ActionLog::log(
            'Suppression de dépense',
            "Dépense #{$depense->id} supprimée du projet '{$projet->nom}'.",
            $projet
        );

        return redirect()->back()->with('success', 'Dépense supprimée.');
    }

    public function validateDepense(Depense $depense)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isProjectManager()) {
            abort(403, "Action non autorisée.");
        }

        $depense->update(['statut_validation' => 'validee']);

        ActionLog::log(
            'Validation de dépense',
            "La dépense de {$depense->montant} FCFA sur le projet '{$depense->projet->nom}' a été validée.",
            $depense
        );

        return redirect()->back()->with('success', 'Dépense validée.');
    }

    public function rejectDepense(Depense $depense)
    {
        if (!auth()->user()->isAdmin() && !auth()->user()->isProjectManager()) {
            abort(403, "Action non autorisée.");
        }

        $depense->update(['statut_validation' => 'rejetee']);

        ActionLog::log(
            'Rejet de dépense',
            "La dépense #{$depense->id} sur le projet '{$depense->projet->nom}' a été rejetée.",
            $depense
        );

        return redirect()->back()->with('success', 'Dépense rejetée.');
    }
}
