<?php

namespace Database\Seeders;

use App\Models\CategorieDepense;
use Illuminate\Database\Seeder;

class CategorieDepenseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Achat matériel',
            'Sous-traitance',
            'Déplacement',
            'Communication',
            'Impôts et taxes',
            'Divers',
        ];

        foreach ($categories as $nom) {
            CategorieDepense::firstOrCreate(['nom' => $nom]);
        }
    }
}
