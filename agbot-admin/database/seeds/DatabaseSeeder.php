<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(LecturesTableSeeder::class);
        $this->call(AttendancesTableSeeder::class);
        $this->call(BeaconsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
    }

    public static function truncateTable($table)
    {
        DB::table($table)->truncate();
    }
}
