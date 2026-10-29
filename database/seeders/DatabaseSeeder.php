<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gespro.com'],
            [
                'name'     => 'Administrateur GESPRO',
                'password' => bcrypt('matricule'),
                'role'     => 'administrateur',
            ]
        );

        User::updateOrCreate(
            ['email' => 'chef@gespro.com'],
            [
                'name'     => 'Chef de Projet',
                'password' => bcrypt('majuscule'),
                'role'     => 'chef_de_projet',
            ]
        );

        User::updateOrCreate(
            ['email' => 'colla@gespro.com'],
            [
                'name'     => 'Collaborateur',
                'password' => bcrypt('miniscule'),
                'role'     => 'collaborateur',
            ]
        );

        $this->call(CategorieDepenseSeeder::class);
    }
}
