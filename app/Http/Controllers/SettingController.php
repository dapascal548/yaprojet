<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\CategorieDepense;

class SettingController extends Controller
{
    public function index()
    {
        $backups = Storage::disk('local')->files('backups');
        $categories = CategorieDepense::all();
        return view('settings.index', compact('backups', 'categories'));
    }

    public function createBackup()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $filename = 'backup-' . now()->format('Y-m-d-H-i-s') . '.sqlite';
        $sqlitePath = database_path('database.sqlite');

        if (file_exists($sqlitePath)) {
            Storage::disk('local')->put('backups/' . $filename, file_get_contents($sqlitePath));
            return redirect()->back()->with('success', 'Sauvegarde créée avec succès : ' . $filename);
        }

        return redirect()->back()->withErrors(['error' => 'Fichier de base de données introuvable.']);
    }

    public function downloadBackup(string $filename)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $path = 'backups/' . $filename;
        if (Storage::disk('local')->exists($path)) {
            return Storage::disk('local')->download($path);
        }

        return redirect()->back()->withErrors(['error' => 'Fichier de sauvegarde introuvable.']);
    }
}
