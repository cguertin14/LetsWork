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
                'name' => $faker->name(),
                'begin' => $faker->dateTimeThisMonth('now'),
                'end' => $faker->dateTimeThisDecade($max = '+10 years'),
            ]);
            foreach (range(1, 365) as $day) {
                foreach (range(0, 2) as $chiffre) {
                    $begin = \Carbon\Carbon::create(2017, 1, $day, random_int(0, 12),0, 0);
                    $end = \Carbon\Carbon::create(2017, 1, $day, random_int(13, 23) ,0, 0);
                    $scheduleElement = $schedule->scheduleelements()->create([
                        'begin' => $begin,
                        'end' => $end
                    ]);
                    $specialrole = \App\SpecialRole::all()->random();
                    //$employee = $specialrole->employees()->whereIn('id', $company->employees)->get()->random();
                    $scheduleElement->specialroles()->attach($specialrole);
                    $scheduleElement->employees()->attach($company->employees()->get()->random()->id);
                }
            }
        }
    }
}
