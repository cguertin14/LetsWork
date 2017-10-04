<?php

use Illuminate\Database\Seeder;

class EmployeeSpecialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employees = \App\Employee::all();
        $specialroles=\App\SpecialRole::all();
        foreach ($employees as $employee) {
            $employee->specialroles()->attach($specialroles->random()->id);
        }
    }
}
