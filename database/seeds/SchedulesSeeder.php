<?php

use Illuminate\Database\Seeder;

class SchedulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        foreach (\App\Company::all() as $company) {
            $schedule = $company->schedules()->create([
                "name" => $faker->name()
            ]);
            foreach (range(365, 365) as $day) {
                foreach (range(0, 2) as $chiffre) {
                    $begin = \Carbon\Carbon::create(2017, 1, $day, random_int(0, 12), 0, 0)->format("H:i:s");
                    $end = \Carbon\Carbon::create(2017, 1, $day, random_int(13, 23), 0, 0)->format("H:i:s");
                    $element = $schedule->scheduleelements()->create([
                        "begin" => $begin,
                        "end" => $end
                    ]);
                    $specialrole = \App\SpecialRole::all()->random();
                    $element->specialrole()->attach($specialrole);
                    $employe = $specialrole->employees()->whereIn("id", $company->employees)->get()->random();
                    $element->employees()->attach($employe);
                }
            }
        }
    }
}
