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
        DB::table('company_employee')->truncate();
        DB::table('skills')->truncate();
        DB::table('special_roles')->truncate();
        DB::table('skill_special_role')->truncate();
        DB::table('role_special_role')->truncate();
        DB::table('job_offers')->truncate();
        DB::table('job_offer_user')->truncate();
        DB::table('employee_special_role')->truncate();
        DB::table('schedules')->truncate();
        DB::table('schedule_elements')->truncate();
        DB::table('employee_schedule_element')->truncate();
        DB::table('schedule_element_special_role')->truncate();

        $this->call(UsersTableSeeder::class);
        $this->call(FileTypesTableSeeder::class);
        $this->call(EmployeesTableSeeder::class);
        $this->call(CompanyTypesTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        //$this->call(MessagesTableSeeder::class);
        $this->call(FilesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(SkillTableSeeder::class);
        $this->call(SpecialRoleSeeder::class);
        $this->call(JobOfferSeeder::class);
        $this->call(EmployeeSpecialRoleSeeder::class);
        $this->call(SchedulesSeeder::class);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}