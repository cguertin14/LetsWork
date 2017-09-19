<?php

use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
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
            \App\JobOffer::create([
                'name' => $faker->name(),
                'description'=>$faker->text(250),
                'job_count'=>$faker->randomNumber(2),
                'company_id'=>\App\Company::all()->random()->id,
                'special_role_id'=>\App\SpecialRole::all()->random()->id
            ]);
        }
    }
}
