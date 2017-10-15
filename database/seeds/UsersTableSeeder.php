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
        foreach (range(1,150) as $index) {
            $firstname = $faker->firstName;
            $lastname = $faker->lastName;
            $fullname = $firstname . " " . $lastname;
            \App\User::create([
                'name' => $fullname,
                'phone_number' => $faker->phoneNumber,
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $faker->safeEmail,
                'slug' => $faker->slug(),
                'password' => bcrypt('letswork'),
                'remember_token' => str_random(10)
            ]);
        }
    }
}
