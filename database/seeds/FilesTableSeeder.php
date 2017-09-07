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
            $filetype = \App\FileType::all()->random();
            \App\File::create([
                'user_id' => $user->id,
                'file_type_id' => $filetype->id,
                'content' => $filetype->content === '.jpg' || $filetype->content === '.png' ? $faker->imageUrl() : $faker->file('')
            ]);
        }
    }
}
