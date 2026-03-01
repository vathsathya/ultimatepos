<?php

namespace Database\Seeders;

use App\Currency;
use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => '1',
                'country' => 'Cambodia',
                'currency' => 'Riels',
                'code' => 'KHR',
                'symbol' => '៛',
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_at' => null,
                'updated_at' => null,
            ],
            [
                'id' => '2',
                'country' => 'United State of America',
                'currency' => 'Dollars',
                'code' => 'USD',
                'symbol' => '$',
                'thousand_separator' => ',',
                'decimal_separator' => '.',
                'created_at' => null,
                'updated_at' => null,
            ]

        ];

        Currency::insert($data);
    }
}
