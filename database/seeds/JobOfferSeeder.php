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
        foreach (\App\SpecialRole::all() as $specialRole) {

            \App\JobOffer::create([
                'name' => $faker->name(),
                'description'=>$faker->text(250),
                'job_count'=>$faker->randomNumber(2),
                'company_id'=>$specialRole->company_id,
                'special_role_id'=>$specialRole->id,
                'slug' => $faker->slug()
            ]);
        }
    }
}
