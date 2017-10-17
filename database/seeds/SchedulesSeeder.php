<?php

use Carbon\Carbon;
use Faker\Factory;
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
        $faker = Factory::create();
        $scheduleNames = [
            'Été',
            'Hiver',
            'Noel',
            'Printemps',
            'Paques',
            'Saint-Jean',
            'Vacances'
        ];
        foreach (\App\Company::all() as $company) {
            $schedule = $company->schedules()->create([
                'name' => $scheduleNames[array_rand($scheduleNames)],
                'begin' => Carbon::today(),
                'end' => $faker->dateTimeBetween($startDate = 'now', $endDate = '+1 month'),
            ]);
            foreach (range(1, 30) as $month) {
                $begin = Carbon::createFromTimestamp($faker->dateTimeBetween($startDate = 'now', $endDate = '+2 months')->getTimeStamp());
                $end = Carbon::createFromFormat('Y-m-d H:i:s', $begin)->addHours($faker->numberBetween(1, 8));

                $scheduleElement = $schedule->scheduleelements()->create([
                    'begin' => $begin,
                    'end' => $end
                ]);
                $specialrole = \App\SpecialRole::all()->random();
                //$employee = $specialrole->employees()->whereIn('id', $company->employees)->get()->random();
                $scheduleElement->specialroles()->attach($specialrole);
                $scheduleElement->employees()->attach($company->employees()->get()->random());
            }
        }
    }
}
