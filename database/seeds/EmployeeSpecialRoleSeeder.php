<?php

use Illuminate\Database\Seeder;
use Symfony\Component\Console\Output\ConsoleOutput;

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
        foreach ($employees as $employee) {
            foreach ($employee->companies as $company) {
                $specialroles = \App\SpecialRole::where('company_id',$company->id)->get();
                if (!$specialroles->isEmpty())
                    $employee->specialroles()->attach($specialroles->random());
            }
        }
    }
}
