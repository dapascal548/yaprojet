<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\ActionLog;
use App\Models\CategorieDepense;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjetController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $query = Projet::with(['devis', 'depenses', 'user']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('client', 'like', "%{$search}%");
            });
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->filled('annee')) {
            $query->whereYear('date_debut', $request->annee);
        }

        $projets = $query->latest()->paginate(10);
        $annees = Projet::selectRaw('YEAR(date_debut) as annee')->distinct()->pluck('annee')->filter()->values();

        return view('projets.index', compact('projets', 'annees'));
    }

    public function create()
    {
        return view('projets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:150',
            'client' => 'required|string|max:150',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after_or_equal:date_debut',
            'main_oeuvre' => 'required|numeric|min:0',
            'materiel' => 'required|numeric|min:0',
            'transport' => 'required|numeric|min:0',
            'autres_couts' => 'required|numeric|min:0',
        ]);

        $projet = Projet::create([
            'user_id' => auth()->id(),
            'nom' => $validated['nom'],
            'client' => $validated['client'],
            'description' => $validated['description'],
            'date_debut' => $validated['date_debut'],
            'date_fin_prevue' => $validated['date_fin_prevue'],
            'statut' => 'en_cours',
        ]);

        $projet->devis()->create([
            'main_oeuvre' => $validated['main_oeuvre'],
            'materiel' => $validated['materiel'],
            'transport' => $validated['transport'],
            'autres_couts' => $validated['autres_couts'],
        ]);

        ActionLog::log(
            'Création de projet',
            "Le projet '{$projet->nom}' a été créé avec son devis estimatif.",
            $projet
        );

        return redirect()->route('projets.show', $projet)->with('success', 'Projet créé avec succès.');
    }

    public function show(Projet $projet)
    {
        $projet->load(['devis', 'depenses.categorie', 'depenses.user', 'user']);
        $categories = CategorieDepense::all();

        return view('projets.show', compact('projet', 'categories'));
    }

    public function edit(Projet $projet)
    {
        if ($projet->depenses()->where('statut_validation', 'validee')->exists()) {
            return redirect()->route('projets.show', $projet)->withErrors(['error' => 'Impossible de modifier ce projet car des dépenses ont déjà été validées.']);
        }

        $projet->load('devis');
        return view('projets.edit', compact('projet'));
    }

    public function update(Request $request, Projet $projet)
    {
        if ($projet->depenses()->where('statut_validation', 'validee')->exists()) {
            return redirect()->route('projets.show', $projet)->withErrors(['error' => 'Impossible de modifier ce projet car des dépenses ont déjà été validées.']);
        }

        $validated = $request->validate([
            'nom' => 'required|string|max:150',
            'client' => 'required|string|max:150',
            'description' => 'nullable|string',
            'date_debut' => 'required|date',
            'date_fin_prevue' => 'required|date|after_or_equal:date_debut',
            'statut' => 'required|in:en_cours,en_pause,termine',
            'date_fin_reelle' => 'nullable|date|after_or_equal:date_debut',
            'main_oeuvre' => 'required|numeric|min:0',
            'materiel' => 'required|numeric|min:0',
            'transport' => 'required|numeric|min:0',
            'autres_couts' => 'required|numeric|min:0',
        ]);

        $projet->update([
            'nom' => $validated['nom'],
            'client' => $validated['client'],
            'description' => $validated['description'],
            'date_debut' => $validated['date_debut'],
            'date_fin_prevue' => $validated['date_fin_prevue'],
            'date_fin_reelle' => $validated['date_fin_reelle'] ?? $projet->date_fin_reelle,
            'statut' => $validated['statut'],
        ]);

        if ($projet->devis) {
            $projet->devis->update([
                'main_oeuvre' => $validated['main_oeuvre'],
                'materiel' => $validated['materiel'],
                'transport' => $validated['transport'],
                'autres_couts' => $validated['autres_couts'],
            ]);
        }

        ActionLog::log(
            'Modification de projet',
            "Le projet '{$projet->nom}' a été mis à jour.",
            $projet
        );

        return redirect()->route('projets.show', $projet)->with('success', 'Projet mis à jour avec succès.');
    }

    public function destroy(Projet $projet)
    {
        if ($projet->depenses()->where('statut_validation', 'validee')->exists()) {
            return redirect()->route('projets.show', $projet)->withErrors(['error' => 'Impossible de supprimer ce projet car des dépenses ont déjà été validées.']);
        }

        $nom = $projet->nom;
        $projet->delete();

        ActionLog::log(
            'Suppression de projet',
            "Le projet '{$nom}' a été supprimé.",
            null
        );

        return redirect()->route('projets.index')->with('success', 'Projet supprimé.');
    }

    public function close(Request $request, Projet $projet)
    {
        $validated = $request->validate([
            'date_fin_reelle' => 'required|date|after_or_equal:date_debut',
        ]);

        $projet->update([
            'statut' => 'termine',
            'date_fin_reelle' => $validated['date_fin_reelle'],
        ]);

        ActionLog::log(
            'Clôture de projet',
            "Le projet '{$projet->nom}' a été clôturé à la date du {$validated['date_fin_reelle']}.",
            $projet
        );

        return redirect()->route('projets.show', $projet)->with('success', 'Projet clôturé avec succès.');
    }
}
