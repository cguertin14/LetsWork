<?php

use Illuminate\Database\Seeder;

class FilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1,10) as $file) {
            $user = \App\User::all()->random();
            \App\File::create([
                'user_id' => $user->id,
                'file_type_id' => 2,
                'content' => 'http://www.stm.info/sites/default/files/pictures/a-plan_metro_blanc_2016.pdf'
            ]);
        }
    }
}
