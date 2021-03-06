<?php

use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,20) as $index) {
            $employee = \App\Employee::all()->random();
            $company = \App\Company::create([
                'name' => $faker->unique()->company,
                'description' => $faker->text(800),
                'telephone' => $faker->unique()->phoneNumber,
                'email' => $faker->unique()->email,
                'ville' => $faker->city,
                'adresse' => $faker->address,
                'zipcode' => $faker->postcode,
                'pays' => $faker->country,
                'slug' => $faker->slug(),
                'company_type_id' => \App\CompanyType::all()->random()->id,
                'user_id' => $employee->user_id,
            ]);
            $company->employees()->attach($employee);
        }
        foreach (\App\Employee::all() as $employe) {
            $employe->companies()->attach(\App\Company::all()->random());
        }
    }
}
