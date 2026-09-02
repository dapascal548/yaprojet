<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@gespro.com'],
            [
                'name' => 'Administrateur GESPRO',
                'password' => bcrypt('password'),
                'role' => 'administrateur',
            ]
        );

        User::firstOrCreate(
            ['email' => 'chef@gespro.com'],
            [
                'name' => 'Chef de Projet',
                'password' => bcrypt('password'),
                'role' => 'chef_de_projet',
            ]
        );

        User::firstOrCreate(
            ['email' => 'colla@gespro.com'],
            [
                'name' => 'Collaborateur',
                'password' => bcrypt('password'),
                'role' => 'collaborateur',
            ]
        );

        $this->call(CategorieDepenseSeeder::class);
    }
}
