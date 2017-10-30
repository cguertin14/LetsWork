<?php

use Illuminate\Database\Seeder;

class CompanyTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companyTypes = [
            'Informatique',
            'Électronique',
            'Automobile',
            'Construction',
            'Manufactures',
            'Vêtements',
            'Chaussures',
            'Animaux',
            'Sports',
            'Nourriture',
            'Photographie',
            'Autres'
        ];
        foreach ($companyTypes as $companyType) {
            \App\CompanyType::create([
               'content' => $companyType
            ]);
        }
    }
}
