<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Leverancier;
use App\Models\Product;

class LeverancierSeeder extends Seeder
{
    public function run(): void
    {
        $leveranciers = [
            [
                'naam' => 'Tech Solutions BV',
                'contactpersoon' => 'Jan de Vries',
                'telefoon' => '010-1234567',
                'email' => 'info@techsolutions.nl',
                'adres' => 'Hoofdstraat 12',
                'postcode' => '3011AA',
                'plaats' => 'Rotterdam',
            ],
            [
                'naam' => 'Gadget World',
                'contactpersoon' => 'Anna Jansen',
                'telefoon' => '020-7654321',
                'email' => 'contact@gadgetworld.nl',
                'adres' => 'Marktplein 5',
                'postcode' => '1012AB',
                'plaats' => 'Amsterdam',
            ],
        ];

        foreach ($leveranciers as $data) {
            $leverancier = Leverancier::create($data);

            // Match producten aan de leverancier
            if ($leverancier->naam === 'Tech Solutions BV') {
                Product::whereIn('naam', ['Laptop Dell XPS 13', 'iPhone 15 Pro'])->update(['leverancier_id' => $leverancier->id]);
            } elseif ($leverancier->naam === 'Gadget World') {
                Product::whereIn('naam', ['PlayStation 5', 'Samsung Monitor 27"'])->update(['leverancier_id' => $leverancier->id]);
            }
        }
    }
}
