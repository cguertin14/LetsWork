<?php

use Illuminate\Database\Seeder;

class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $user=\App\User::create([
            'name' => "AdminTest",
            'phone_number' => $faker->unique()->phoneNumber,
            'first_name' => "Test",
            'last_name' => "Test",
            'email' => "Admin.Test@Admin.Test",
            'slug' => $faker->slug(),
            'password' => bcrypt('test'),
            'remember_token' => str_random(10)
        ]);
        $company=\App\Company::create([
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
            'user_id' => $user->id,
        ]);
        $employee=\App\Employee::create(['user_id' => $user->id]);
        $company->employees()->attach($employee);
        $user1=\App\User::create([
            'name' => "UserTest",
            'phone_number' => $faker->unique()->phoneNumber,
            'first_name' => "Test",
            'last_name' => "Test",
            'email' => "User.Test@User.Test",
            'slug' => $faker->slug(),
            'password' => bcrypt('test'),
            'remember_token' => str_random(10)
        ]);
        $employee1=\App\Employee::create(['user_id' => $user1->id]);
        $company->employees()->attach($employee1);
    }
}
