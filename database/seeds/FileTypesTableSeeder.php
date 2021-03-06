<?php

use Illuminate\Database\Seeder;

class FileTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $extensions = ['photo','.pdf'];
        foreach ($extensions as $extension) {
            \App\FileType::create([
                'content' => $extension
            ]);
        }
    }
}
