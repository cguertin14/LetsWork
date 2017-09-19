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
        $users = \App\User::all();
        foreach ($users as $user1) {
            foreach ($users as $user2) {
                \App\Message::create([
                    'sender_id' => $user1->id,
                    'receiver_id' => $user2->id,
                    'content' => $faker->text()
                ]);
            }
        }
    }
}
