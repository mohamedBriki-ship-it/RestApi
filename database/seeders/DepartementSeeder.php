<?php

namespace Database\Seeders;

use App\Models\Departement;
use Illuminate\Database\Seeder;

class DepartementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departements = [
            [
                'nom' => 'Informatique',
                'description' => 'Département responsable du développement et de la maintenance des systèmes informatiques',
            ],
            [
                'nom' => 'Ressources Humaines',
                'description' => 'Département de gestion du personnel et des ressources humaines',
            ],
            [
                'nom' => 'Finance',
                'description' => 'Département de gestion financière et comptabilité',
            ],
            [
                'nom' => 'Marketing',
                'description' => 'Département de marketing et communication',
            ],
            [
                'nom' => 'Ventes',
                'description' => 'Département commercial et gestion des ventes',
            ],
        ];

        foreach ($departements as $departement) {
            Departement::create($departement);
        }
    }
}
