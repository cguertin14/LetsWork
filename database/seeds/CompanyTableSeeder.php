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
        foreach (range(0,10) as $index) {
            \App\Company::create([
                'name' => $faker->company,
                'description' => $faker->text(800),
                'telephone' => $faker->phoneNumber,
                'email' => $faker->email,
                'ville' => $faker->city,
                'adresse' => $faker->address,
                'zipcode' => $faker->postcode,
                'pays' => $faker->country,
                'slug' => $faker->slug(),
                'company_type_id' => \App\CompanyType::all()->random()->id,
                'user_id' => \App\User::all()->random()->id,
            ]);
        }
    }
}
