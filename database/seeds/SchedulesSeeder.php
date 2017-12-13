<?php

use App\SpecialRole;
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
        $faker = \Faker\Factory::create();
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
            $dateBegin = \Carbon\Carbon::now();
            $dateEnd = Carbon::createFromFormat('Y-m-d H:i:s',$dateBegin)->addWeeks(1);

            $schedule = $company->schedules()->create([
                'name' => $scheduleNames[array_rand($scheduleNames)],
                'begin' => $dateBegin,
                'end' => $dateEnd
            ]);

            $min_epoch = strtotime($schedule->begin);
            $max_epoch = strtotime(Carbon::createFromFormat('Y-m-d H:i:s',$schedule->begin)->addDays(2));
            $rand_epoch = rand($min_epoch, $max_epoch);
            $begin = date('Y-m-d H:i:s', $rand_epoch);
            $end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $begin)->addDays(2);//addHours($faker->numberBetween(1, 8));

            $scheduleElement = $schedule->scheduleelements()->create([
                'begin' => $begin,
                'end' => $end,
                'name' => $faker->unique()->name,
                'description' => $faker->unique()->paragraph(),
                'slug' => $faker->slug()
            ]);

            /*$scheduleElementCopy = $schedule->scheduleelements()->create([
                'begin' => $begin,
                'end' => $end,
                'name' => $faker->unique()->name(),
                'description' => $faker->unique()->paragraph(),
                'slug' => $faker->slug()
            ]);

            $scheduleElementConflict2 = $schedule->scheduleelements()->create([
                'begin' => Carbon::createFromFormat('Y-m-d H:i:s',$begin)->addMinutes(45)->toDateString(),
                'end' => $end->addHour(1),
                'name' => $faker->unique()->name(),
                'description' => $faker->unique()->paragraph(),
                'slug' => $faker->slug()
            ]);*/

            $specialrole = SpecialRole::where('company_id',$company->id)->first();

            $scheduleElement->specialroles()->attach($specialrole);
            $scheduleElement->employees()->attach($specialrole->employees()->first());

            /*$scheduleElementCopy->specialroles()->attach($specialrole);
            $scheduleElementCopy->employees()->attach($specialrole->employees()->first());

            $scheduleElementConflict2->specialroles()->attach($specialrole);
            $scheduleElementConflict2->employees()->attach($specialrole->employees()->first());*/

            /*foreach (range(1, $dateEnd->daysInMonth) as $month) {
                $min_epoch = strtotime($schedule->begin);
                $max_epoch = strtotime(Carbon::createFromFormat('Y-m-d H:i:s',$schedule->begin)->addDays(2));
                $rand_epoch = rand($min_epoch, $max_epoch);
                $begin = date('Y-m-d H:i:s', $rand_epoch);
                $end = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $begin)->addHours($faker->numberBetween(1, 8));

                $scheduleElement = $schedule->scheduleelements()->create([
                    'begin' => $begin,
                    'end' => $end,
                    'name' => $faker->unique()->name,
                    'description' => $faker->unique()->paragraph(),
                    'slug' => $faker->slug()
                ]);
                $specialrole = \App\SpecialRole::all()->random();
                //$employee = $specialrole->employees()->whereIn('id', $company->employees)->get()->random();
                $scheduleElement->specialroles()->attach($specialrole);
                $scheduleElement->employees()->attach($company->employees()->get()->random());
            }*/
        }
    }
}
