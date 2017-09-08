<?php

use App\User;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $users = User::all();
        foreach ($users as $user) {
            \App\Employee::create([
                'user_id' => $user->id
            ]);
        }
    }
}
