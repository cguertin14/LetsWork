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
        foreach (\App\Company::all() as $company) {
            foreach (\App\Skill::all() as $skill) {
                $specialRole = \App\SpecialRole::create([
                    'company_id' => $company->id,
                    'name' => $faker->unique()->name,
                    'description'=>$faker->unique()->sentence(),
                    'slug' => $faker->slug()
                ]);
                $specialRole->roles()->attach(\App\Role::all()->random());
                $specialRole->skills()->attach($skill);
            }
        }
    }
}
