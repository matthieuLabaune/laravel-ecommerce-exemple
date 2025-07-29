<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Récupérer les IDs des catégories
        $categories = Category::all();

        if ($categories->isEmpty()) {
            $this->command->info('Aucune catégorie trouvée. Veuillez exécuter CategorySeeder d\'abord.');
            return;
        }

        // Produits de test
        $products = [
            [
                'name' => 'Ordinateur Portable Pro',
                'description' => 'Ordinateur portable haut de gamme avec processeur rapide et écran haute résolution.',
                'price' => 1299.99,
                'stock' => 50,
                'active' => true,
                'category_id' => $categories->where('name', 'Informatique')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Smartphone X2000',
                'description' => 'Smartphone dernier cri avec appareil photo 108MP et écran AMOLED.',
                'price' => 899.99,
                'stock' => 100,
                'active' => true,
                'category_id' => $categories->where('name', 'Électronique')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Casque Audio Sans Fil',
                'description' => 'Casque bluetooth avec réduction de bruit active et autonomie de 30 heures.',
                'price' => 249.99,
                'stock' => 75,
                'active' => true,
                'category_id' => $categories->where('name', 'Audio')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Tablette Graphique Pro',
                'description' => 'Tablette graphique pour artistes et designers professionnels.',
                'price' => 349.99,
                'stock' => 30,
                'active' => true,
                'category_id' => $categories->where('name', 'Électronique')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Clavier Mécanique Gamer',
                'description' => 'Clavier mécanique RGB pour joueurs avec switches Cherry MX.',
                'price' => 129.99,
                'stock' => 60,
                'active' => true,
                'category_id' => $categories->where('name', 'Accessoires')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Écran 4K UltraWide',
                'description' => 'Écran incurvé 4K UltraWide 38 pouces pour une expérience immersive.',
                'price' => 799.99,
                'stock' => 25,
                'active' => true,
                'category_id' => $categories->where('name', 'Informatique')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Souris Ergonomique',
                'description' => 'Souris ergonomique sans fil pour réduire la fatigue lors d\'une utilisation prolongée.',
                'price' => 59.99,
                'stock' => 85,
                'active' => true,
                'category_id' => $categories->where('name', 'Accessoires')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Disque SSD 2TB',
                'description' => 'Disque SSD haute performance de 2TB avec interface NVMe.',
                'price' => 199.99,
                'stock' => 40,
                'active' => true,
                'category_id' => $categories->where('name', 'Informatique')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Webcam HD Pro',
                'description' => 'Webcam HD 1080p avec microphone intégré pour des visioconférences de qualité.',
                'price' => 79.99,
                'stock' => 55,
                'active' => true,
                'category_id' => $categories->where('name', 'Accessoires')->first()->id ?? $categories->random()->id,
            ],
            [
                'name' => 'Enceintes Bluetooth',
                'description' => 'Enceintes Bluetooth portables avec son stéréo et autonomie de 12 heures.',
                'price' => 89.99,
                'stock' => 0, // Produit en rupture de stock
                'active' => false, // Produit inactif
                'category_id' => $categories->where('name', 'Audio')->first()->id ?? $categories->random()->id,
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }
    }
}
