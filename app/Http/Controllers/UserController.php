<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActionLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:administrateur,chef_de_projet,collaborateur',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        ActionLog::log(
            'Création utilisateur',
            "Utilisateur {$user->name} ({$user->email}) créé avec le rôle {$user->role}.",
            $user
        );

        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateRole(Request $request, User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'role' => 'required|in:administrateur,chef_de_projet,collaborateur',
        ]);

        $ancienRole = $user->role;
        $user->update(['role' => $validated['role']]);

        ActionLog::log(
            'Modification de rôle',
            "Le rôle de {$user->name} a été modifié de '{$ancienRole}' à '{$user->role}'.",
            $user
        );

        return redirect()->route('users.index')->with('success', 'Rôle mis à jour.');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return redirect()->back()->withErrors(['error' => 'Vous ne pouvez pas supprimer votre propre compte.']);
        }

        $nom = $user->name;
        $user->delete();

        ActionLog::log(
            'Suppression utilisateur',
            "L'utilisateur '{$nom}' a été supprimé.",
            null
        );

        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé.');
    }
}
