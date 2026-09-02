<?php

namespace App\Http\Controllers;

use App\Models\CategorieDepense;
use Illuminate\Http\Request;

class CategorieDepenseController extends Controller
{
    public function index()
    {
        return CategorieDepense::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100|unique:categories_depense,nom',
        ]);

        $categorie = CategorieDepense::create($validated);

        return redirect()->back()->with('success', 'Catégorie créée.');
    }

    public function destroy(CategorieDepense $categorie)
    {
        $categorie->delete();

        return redirect()->back()->with('success', 'Catégorie supprimée.');
    }
}
