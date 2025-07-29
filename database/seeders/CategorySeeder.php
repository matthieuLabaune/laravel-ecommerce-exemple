<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Catégories de test
        $categories = [
            [
                'name' => 'Ordinateurs',
                'description' => 'Tous types d\'ordinateurs et accessoires informatiques',
                'active' => true,
            ],
            [
                'name' => 'Smartphones',
                'description' => 'Téléphones mobiles et accessoires',
                'active' => true,
            ],
            [
                'name' => 'Audio',
                'description' => 'Casques, écouteurs et enceintes',
                'active' => true,
            ],
            [
                'name' => 'Périphériques',
                'description' => 'Claviers, souris et autres périphériques',
                'active' => true,
            ],
            [
                'name' => 'Stockage',
                'description' => 'Solutions de stockage de données',
                'active' => true,
            ],
            [
                'name' => 'Accessoires',
                'description' => 'Divers accessoires électroniques',
                'active' => false, // Catégorie inactive pour exemple
            ],
        ];

        foreach ($categories as $categoryData) {
            // Générer automatiquement le slug à partir du nom
            $categoryData['slug'] = Str::slug($categoryData['name']);

            Category::create($categoryData);
        }
    }
}
