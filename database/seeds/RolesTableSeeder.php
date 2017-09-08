<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $roles = [
            'Administrator',
            'Owner',
            'Manager'
        ];
        foreach ($roles as $role) {
            \App\Role::create([
               'content' => $role
            ]);
        }
    }
}
