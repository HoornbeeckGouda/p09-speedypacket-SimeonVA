<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Leverancier;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Eerst leveranciers aanmaken
        $techSolutions = Leverancier::firstOrCreate(
            ['naam' => 'Tech Solutions BV'],
            [
                'contactpersoon' => 'Jan de Vries',
                'telefoon' => '010-1234567',
                'email' => 'info@techsolutions.nl',
                'adres' => 'Hoofdstraat 12',
                'postcode' => '3011AA',
                'plaats' => 'Rotterdam',
            ]
        );

        $gadgetWorld = Leverancier::firstOrCreate(
            ['naam' => 'Gadget World'],
            [
                'contactpersoon' => 'Anna Jansen',
                'telefoon' => '020-7654321',
                'email' => 'contact@gadgetworld.nl',
                'adres' => 'Marktplein 5',
                'postcode' => '1012AB',
                'plaats' => 'Amsterdam',
            ]
        );

        // Productenlijst
        $producten = [
            ['naam' => 'Laptop Dell XPS 13', 'beschrijving' => 'Krachtige ultrabook', 'prijs' => 1299.99, 'categorie' => 'Elektronica', 'leverancier_id' => $techSolutions->id],
            ['naam' => 'iPhone 15 Pro', 'beschrijving' => 'Nieuwste iPhone model', 'prijs' => 1199.00, 'categorie' => 'Elektronica', 'leverancier_id' => $techSolutions->id],
            ['naam' => 'Nike Sportschoenen', 'beschrijving' => 'Running shoes maat 42', 'prijs' => 129.99, 'categorie' => 'Kleding', 'leverancier_id' => $gadgetWorld->id],
            ['naam' => 'Samsung Monitor 27"', 'beschrijving' => '4K UHD display', 'prijs' => 399.00, 'categorie' => 'Elektronica', 'leverancier_id' => $gadgetWorld->id],
            ['naam' => 'Ergonomische Bureaustoel', 'beschrijving' => 'Met lendestoel', 'prijs' => 249.99, 'categorie' => 'Meubels', 'leverancier_id' => $techSolutions->id],
            ['naam' => 'Koffiemachine DeLonghi', 'beschrijving' => 'Espresso automaat', 'prijs' => 299.00, 'categorie' => 'Huishouden', 'leverancier_id' => $techSolutions->id],
            ['naam' => 'Boek: Laravel voor Beginners', 'beschrijving' => 'Programmeergids', 'prijs' => 39.99, 'categorie' => 'Boeken', 'leverancier_id' => $gadgetWorld->id],
            ['naam' => 'PlayStation 5', 'beschrijving' => 'Gaming console', 'prijs' => 549.99, 'categorie' => 'Gaming', 'leverancier_id' => $gadgetWorld->id],
        ];

        foreach ($producten as $product) {
            Product::updateOrCreate(
                ['naam' => $product['naam']],
                $product
            );
        }
    }
}
