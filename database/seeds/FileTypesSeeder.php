<?php

use Illuminate\Database\Seeder;

class FileTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $extensions = ['.jpg','.png','.pdf'];
        foreach ($extensions as $extension) {
            \App\FileType::create([
                'content' => $extension
            ]);
        }
    }
}
