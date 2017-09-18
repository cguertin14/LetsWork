<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $index) {
            \App\User::create([
                'name' => $faker->name,
                'phone_number' => $faker->phoneNumber,
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->safeEmail,
                'password' => bcrypt('letswork'),
                'remember_token' => str_random(10)
            ]);
        }
    }
}
