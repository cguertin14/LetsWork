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
        foreach (\App\Skill::all() as $skill) {
            $specialRole = \App\SpecialRole::create([
                'company_id' => \App\Company::all()->random()->id,
                'name' => $faker->name,
                'description'=>$faker->sentence(),
                'slug' => $faker->slug()
            ]);
            $specialRole->roles()->attach(\App\Role::all()->random());
            $specialRole->skills()->attach($skill);
        }
    }
}
