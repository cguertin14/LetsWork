<?php

use Illuminate\Database\Seeder;

class SpecialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(20,35) as $item) {
            \App\SpecialRole::create([
                'company_id' => \App\Company::all()->random()->id,
                'name' => $faker->name,
                'description'=>$faker->sentence()
            ]);
        }
    }
}
