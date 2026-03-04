<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FanzineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fanzines = [
            ['name' => 'Les Murmures du Manoir', 'number' => 1, 'description' => 'Premier numéro sur les maisons hantées.', 'price' => 5.99],
            ['name' => 'L\'Orc : Origines', 'number' => 2, 'description' => 'Spécial web-série Evil Ed et bande dessinée.', 'price' => 4.50],
            ['name' => 'Riflesso di un Coltello', 'number' => 3, 'description' => 'Focus sur le cinéma d\'horreur italien.', 'price' => 6.00],
            ['name' => 'Brume Émeraude', 'number' => 4, 'description' => 'Le guide officiel du Petit Festival de l\'Épouvante.', 'price' => 5.90],
            [
                'name' => 'Les Griffes du Giallo',
                'number' => 5,
                'price' => 12,
                'description' => 'Un voyage sanglant à travers le cinéma de Mario Bava et Dario Argento.',
            ],
            [
                'name' => 'Manoirs Hantés',
                'number' => 6,
                'price' => 10,
                'description' => 'Étude architecturale des demeures les plus terrifiantes du septième art.',
            ],
            [
                'name' => 'Technicolor Macabre',
                'number' => 7,
                'price' => 15,
                'description' => 'L\'esthétique de la Hammer et l\'usage de la couleur dans l\'épouvante britannique.',
            ],
            [
                'name' => 'Grimoires Oubliés',
                'number' => 8,
                'price' => 12,
                'description' => 'Focus sur la littérature fantastique du XIXème siècle et ses adaptations.',
            ],
        ];

        foreach ($fanzines as $f) {
            \App\Models\Fanzine::create($f);
        }
    }
}
