<?php

use Illuminate\Database\Seeder;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (\App\Company::all() as $company) {
            \App\Skill::create([
               'name' => $faker->name,
               'description' => $faker->paragraph(),
                'company_id' => $company->id,
                'slug' => $faker->slug()
            ]);
        }
    }
}
