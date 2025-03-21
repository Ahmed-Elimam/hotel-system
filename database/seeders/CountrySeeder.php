<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $countries = [
            'United States', 'France', 'Spain', 'Italy', 'China', 'Germany',
            'Mexico', 'Thailand', 'United Kingdom', 'Japan', 'Australia', 'India',
            'Turkey', 'Brazil', 'South Korea', 'Indonesia', 'United Arab Emirates', 'Egypt',
            'Russia', 'Greece', 'Switzerland', 'Netherlands', 'South Africa', 'Malaysia',
            'Singapore', 'Argentina', 'Morocco', 'Palestine', 'Portugal', 'Vietnam',
            'New Zealand', 'Sweden', 'Belgium', 'Austria', 'Czech Republic', 'Poland',
            'Hungary', 'Finland', 'Denmark', 'Norway', 'Ireland', 'Canada',
            'Croatia', 'Chile', 'Peru', 'Kenya', 'Tunisia', 'Jordan',
            'Bali'
        ];

        sort($countries);

        foreach ($countries as $country) {
            if (!Country::where('name', $country)->exists()) {
                Country::create(['name' => $country]);
            }
        }
    }
}
