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
        foreach (range(0,10) as $index) {
            \App\Skill::create([
               'name' => $faker->name,
               'description' => $faker->paragraph()
            ]);
        }
    }
}
