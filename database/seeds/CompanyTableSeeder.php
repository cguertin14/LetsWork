<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        //$previous =
        foreach (range(1,10) as $index) {
            \App\Company::create([
                'name' => $faker->companySuffix,
                'description' => $faker->company,
                'company_type_id' => \App\CompanyType::all()->random()->id,
                'user_id' => \App\User::all()->random()->id,
            ]);
        }
    }
}
