<?php

use Illuminate\Database\Seeder;

class MessageFilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $messages = \App\Message::all();
        foreach ($messages as $message) {
            $file = \App\File::all()->random();
            \App\MessageFile::create([
               'message_id' => $message->id,
               'file_id'    => $file->id
            ]);
        }
    }
}
