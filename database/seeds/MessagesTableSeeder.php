<?php

use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 10) as $index) {
            foreach (range(1,10) as $index2)
            {
                \App\Employee::create([
                    'sender_id' => $index,
                    'receiver_id' => $index2,
                    'content' => $faker->text()
                ]);
            }
        }
    }
}
