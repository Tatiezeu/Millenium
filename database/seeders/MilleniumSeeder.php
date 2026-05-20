<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Table;
use App\Models\Gallery;
use Illuminate\Database\Seeder;

class MilleniumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Clean up existing data to ensure exactly the requested amounts are present
        Service::truncate();
        Table::truncate();
        Gallery::truncate();

        $this->command->info('Cleared existing services, tables, and gallery records.');

        // 2. Seed 20 Meals
        $meals = [
            [
                'name' => 'Le Ndolé Royal',
                'type' => 'meal',
                'category' => 'Main Course',
                'price' => 8500,
                'description' => 'Traditional Cameroonian dish prepared with fresh ndole leaves, shrimp, beef, and plantains.'
            ],
            [
                'name' => 'Poulet Directeur Général (DG)',
                'type' => 'meal',
                'category' => 'Lunch',
                'price' => 9000,
                'description' => 'A luxurious Cameroonian chicken stew sautéed with sweet plantains, bell peppers, onions, and carrots.'
            ],
            [
                'name' => 'Sauté de Koki de l\'Ouest',
                'type' => 'meal',
                'category' => 'Main Course',
                'price' => 6000,
                'description' => 'Steamed black-eyed pea cake seasoned with pure palm oil and cooked in fresh banana leaves, served with plantains.'
            ],
            [
                'name' => 'Eru de Limbé',
                'type' => 'meal',
                'category' => 'Dinner',
                'price' => 7500,
                'description' => 'Traditional Eru soup cooked with spinach, smoked fish, crayfish, cow skin, and red oil, served with soft water fufu.'
            ],
            [
                'name' => 'Carpe Braisée du Wouri',
                'type' => 'meal',
                'category' => 'Dinner',
                'price' => 10000,
                'description' => 'Freshly caught local carp fish grilled over charcoal with traditional spices, served with miondo and pepper sauce.'
            ],
            [
                'name' => 'Taro Sauce Jaune',
                'type' => 'meal',
                'category' => 'Lunch',
                'price' => 8000,
                'description' => 'Smooth, soft taro paste served with a rich yellow soup made from palm oil, secret spices, and dry beef.'
            ],
            [
                'name' => 'Achachu Soya Skewers',
                'type' => 'meal',
                'category' => 'Appetizer',
                'price' => 4500,
                'description' => 'Charcoal-grilled seasoned beef skewers dusted with spicy ground peanut kankan, a local delicacy refined.'
            ],
            [
                'name' => 'Millenium Ribeye Steak',
                'type' => 'meal',
                'category' => 'Main Course',
                'price' => 22000,
                'description' => 'Premium grain-fed ribeye beef cooked to perfection, served with garlic mashed potatoes and red wine reduction.'
            ],
            [
                'name' => 'Pan-Seared Sea Bass',
                'type' => 'meal',
                'category' => 'Dinner',
                'price' => 18000,
                'description' => 'Atlantic sea bass fillet over a bed of lemon-scented asparagus and creamy butter saffron sauce.'
            ],
            [
                'name' => 'Spaghetti au Crabe du Littoral',
                'type' => 'meal',
                'category' => 'Main Course',
                'price' => 12500,
                'description' => 'Fresh crab meat tossed with spaghetti in a rich cherry tomato, garlic, and white wine reduction sauce.'
            ],
            [
                'name' => 'Millenium Gourmet Burger',
                'type' => 'meal',
                'category' => 'Lunch',
                'price' => 9500,
                'description' => 'House-ground beef patty, aged cheddar, caramelized onions, and truffle aioli on a fresh brioche bun.'
            ],
            [
                'name' => 'Smoked Salmon Benedict',
                'type' => 'meal',
                'category' => 'Breakfast',
                'price' => 7000,
                'description' => 'Toasted English muffin topped with smoked salmon, poached eggs, and classic creamy Hollandaise sauce.'
            ],
            [
                'name' => 'Croissant Fourré au Chocolat',
                'type' => 'meal',
                'category' => 'Breakfast',
                'price' => 2500,
                'description' => 'Freshly baked flaky buttery croissant filled with premium melted Belgian dark chocolate.'
            ],
            [
                'name' => 'Avocado Toast Prestige',
                'type' => 'meal',
                'category' => 'Breakfast',
                'price' => 5500,
                'description' => 'Sourdough toast topped with mashed avocado, cherry tomatoes, feta cheese, pumpkin seeds, and a soft-boiled egg.'
            ],
            [
                'name' => 'Chèvre Chaud Salad',
                'type' => 'meal',
                'category' => 'Appetizer',
                'price' => 6500,
                'description' => 'Warm goat cheese crostini on mixed greens with walnuts, fresh seasonal figs, and honey mustard dressing.'
            ],
            [
                'name' => 'Truffle Fries with Parmesan',
                'type' => 'meal',
                'category' => 'Side Dish',
                'price' => 4000,
                'description' => 'Crispy hand-cut potatoes tossed in white truffle oil, grated parmesan cheese, and fresh parsley.'
            ],
            [
                'name' => 'Sautéed Wild Mushrooms',
                'type' => 'meal',
                'category' => 'Side Dish',
                'price' => 4500,
                'description' => 'Pan-sautéed seasonal wild mushrooms with garlic, fresh herbs, and a splash of white wine.'
            ],
            [
                'name' => 'Lava Cake au Chocolat Noir',
                'type' => 'meal',
                'category' => 'Dessert',
                'price' => 5000,
                'description' => 'Warm dark chocolate cake with a molten liquid center, served with vanilla bean ice cream.'
            ],
            [
                'name' => 'Classic Crème Brûlée',
                'type' => 'meal',
                'category' => 'Dessert',
                'price' => 4500,
                'description' => 'Rich vanilla custard base topped with a texturally contrasting layer of hardened caramelized sugar.'
            ],
            [
                'name' => 'Tarte Tatin aux Pommes',
                'type' => 'meal',
                'category' => 'Dessert',
                'price' => 5000,
                'description' => 'Caramelized apple tart baked pastry-side up, flipped before serving, topped with salted caramel.'
            ],
        ];

        foreach ($meals as $meal) {
            Service::create($meal);
        }
        $this->command->info('Successfully seeded 20 premium meals.');

        // 3. Seed 20 Drinks
        $drinks = [
            [
                'name' => 'Dom Pérignon Vintage',
                'type' => 'drink',
                'category' => 'Champagne',
                'price' => 280000,
                'description' => 'Prestigious French champagne with tasting notes of almond, cocoa, and white flowers.'
            ],
            [
                'name' => 'Moët & Chandon Brut',
                'type' => 'drink',
                'category' => 'Champagne',
                'price' => 85000,
                'description' => 'Vibrant, generous, and alluring champagne with bright fruitiness and an elegant maturity.'
            ],
            [
                'name' => 'Château Margaux 2015',
                'type' => 'drink',
                'category' => 'Wine',
                'price' => 150000,
                'description' => 'World-renowned premier grand cru classé Bordeaux red wine with unmatched complexity.'
            ],
            [
                'name' => 'Chablis Premier Cru',
                'type' => 'drink',
                'category' => 'Wine',
                'price' => 45000,
                'description' => 'Elegant Burgundy white wine featuring crisp mineral notes, green apple, and citrus aromas.'
            ],
            [
                'name' => 'Macallan 18 Years Sherry Oak',
                'type' => 'drink',
                'category' => 'Spirits',
                'price' => 25000,
                'description' => 'Premium single malt scotch whisky matured in hand-picked sherry seasoned oak casks.'
            ],
            [
                'name' => 'Hennessy XO Cognac',
                'type' => 'drink',
                'category' => 'Spirits',
                'price' => 18000,
                'description' => 'Rich, full-bodied cognac with complex flavors of candied fruit, spice, cacao, and warm leather.'
            ],
            [
                'name' => 'Classic Old Fashioned',
                'type' => 'drink',
                'category' => 'Alcoholic',
                'price' => 7500,
                'description' => 'Premium bourbon whiskey, Angostura bitters, sugar cube, and a twist of fresh orange peel.'
            ],
            [
                'name' => 'Millenium Royal Mojito',
                'type' => 'drink',
                'category' => 'Alcoholic',
                'price' => 8500,
                'description' => 'Fresh mint, lime juice, white rum, simple syrup, topped with premium sparkling champagne.'
            ],
            [
                'name' => 'Damas Sunset Cocktail',
                'type' => 'drink',
                'category' => 'Alcoholic',
                'price' => 6500,
                'description' => 'White rum blended with local passion fruit juice, hibiscus syrup, and a splash of lime.'
            ],
            [
                'name' => 'Kribi Beach Colada',
                'type' => 'drink',
                'category' => 'Alcoholic',
                'price' => 6000,
                'description' => 'Coconut cream, fresh pineapple juice, and aged dark rum, blended to perfection.'
            ],
            [
                'name' => 'Foléré Infusion Fizz',
                'type' => 'drink',
                'category' => 'Non-Alcoholic',
                'price' => 3500,
                'description' => 'Mocktail made with locally brewed hibiscus (foléré) flower tea, ginger beer, lime, and fresh mint.'
            ],
            [
                'name' => 'Virgin Passion Mojito',
                'type' => 'drink',
                'category' => 'Non-Alcoholic',
                'price' => 3500,
                'description' => 'Muddled fresh mint, lime, passion fruit purée, cane sugar, and sparkling water.'
            ],
            [
                'name' => 'Fresh Ginger & Pineapple Nectar',
                'type' => 'drink',
                'category' => 'Non-Alcoholic',
                'price' => 3000,
                'description' => 'Refreshing house-pressed juice combining sweet local pineapple with zesty ginger.'
            ],
            [
                'name' => 'Kadji Beer Premium',
                'type' => 'drink',
                'category' => 'Malt',
                'price' => 2500,
                'description' => 'Famous Cameroonian lager beer, crisp and deeply refreshing.'
            ],
            [
                'name' => 'Castel Beer Premium',
                'type' => 'drink',
                'category' => 'Malt',
                'price' => 2500,
                'description' => 'Prestigious local lager beer with a smooth finish.'
            ],
            [
                'name' => 'Guinness Stout Extra',
                'type' => 'drink',
                'category' => 'Malt',
                'price' => 3000,
                'description' => 'The iconic rich, dark stout with a creamy head.'
            ],
            [
                'name' => 'Double Espresso Barista',
                'type' => 'drink',
                'category' => 'Hot Beverage',
                'price' => 2000,
                'description' => 'Concentrated espresso brewed from premium local Foumban Arabica coffee beans.'
            ],
            [
                'name' => 'Vanilla Bean Latte',
                'type' => 'drink',
                'category' => 'Hot Beverage',
                'price' => 3000,
                'description' => 'Rich espresso combined with steamed milk and sweet vanilla bean syrup.'
            ],
            [
                'name' => 'Chamomile & Honey Tea',
                'type' => 'drink',
                'category' => 'Hot Beverage',
                'price' => 2500,
                'description' => 'Calming hot herbal tea served with local organic mountain honey.'
            ],
            [
                'name' => 'San Pellegrino Sparkling',
                'type' => 'drink',
                'category' => 'Cold Beverage',
                'price' => 3500,
                'description' => 'Naturally carbonated premium mineral water imported from Italy.'
            ],
        ];

        foreach ($drinks as $drink) {
            Service::create($drink);
        }
        $this->command->info('Successfully seeded 20 premium drinks.');

        // 4. Seed 30 Tables (10 Standard, 10 Medium, 10 First Class)
        // 10 Standard
        for ($i = 1; $i <= 10; $i++) {
            Table::create([
                'title' => 'T-' . str_pad($i, 2, '0', STR_PAD_LEFT),
                'seats' => 2,
                'category' => 'Standard',
                'price' => 25000,
                'area' => '15 m²',
                'status' => 'available'
            ]);
        }

        // 10 Medium
        for ($i = 11; $i <= 20; $i++) {
            Table::create([
                'title' => 'T-' . $i,
                'seats' => 4,
                'category' => 'Medium',
                'price' => 35000,
                'area' => '25 m²',
                'status' => 'available'
            ]);
        }

        // 10 First Class
        for ($i = 21; $i <= 30; $i++) {
            Table::create([
                'title' => 'T-' . $i,
                'seats' => 6,
                'category' => 'First Class',
                'price' => 50000,
                'area' => '40 m²',
                'status' => 'available'
            ]);
        }
        $this->command->info('Successfully seeded 30 restaurant tables (10 Standard, 10 Medium, 10 First Class).');

        // 5. Seed 10 Stunning Restaurant Views in Gallery
        $galleryImages = [
            [
                'title' => 'Grand Dining Hall',
                'image_path' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'Romantic Table Candlelight',
                'image_path' => 'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'Premium Lounge & Cocktail Bar',
                'image_path' => 'https://images.unsplash.com/photo-1514362545857-3bc16c4c7d1b?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'Exquisite Chef Selection',
                'image_path' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?q=80&w=1200',
                'category' => 'food'
            ],
            [
                'title' => 'La Terrasse de Millenium',
                'image_path' => 'https://images.unsplash.com/photo-1533777857889-4be7c70b33f7?q=80&w=1200',
                'category' => 'exterior'
            ],
            [
                'title' => 'The Master Kitchen',
                'image_path' => 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'Artisanal Dessert Corner',
                'image_path' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200',
                'category' => 'food'
            ],
            [
                'title' => 'Café Bar Lounge',
                'image_path' => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'The Millenium Wine Room',
                'image_path' => 'https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1200',
                'category' => 'interior'
            ],
            [
                'title' => 'Millenium Palace Facade',
                'image_path' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?q=80&w=1200',
                'category' => 'exterior'
            ],
        ];

        foreach ($galleryImages as $img) {
            Gallery::create($img);
        }
        $this->command->info('Successfully seeded 10 stunning gallery images.');
    }
}
