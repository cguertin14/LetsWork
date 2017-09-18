<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();
        DB::table('file_types')->truncate();
        DB::table('employees')->truncate();
        DB::table('messages')->truncate();
        DB::table('company_types')->truncate();
        DB::table('files')->truncate();
        DB::table('roles')->truncate();
        DB::table('message_files')->truncate();
        DB::table('companies')->truncate();
        DB::table('photos')->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(FileTypesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(CompanyTypesTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        //$this->call(MessageFilesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(SpecialRoleSeeder::class);
        $this->call(JobOfferSeeder::class);
    }
}
