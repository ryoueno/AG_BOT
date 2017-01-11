<?php

use Illuminate\Database\Seeder;

class AttendancesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatabaseSeeder::truncateTable('attendances');

        $attendances = [
            [
                'id'         => 1,
                'lecture_id' => 1,
                'student_id' => 18114035,
                'is_active' => 1,
            ],            [
                'id'         => 2,
                'lecture_id' => 1,
                'student_id' => 18114034,
                'is_active' => 0,
            ],            [
                'id'         => 3,
                'lecture_id' => 1,
                'student_id' => 18114033,
                'is_active' => 0,
            ],
        ];

        foreach ($attendances as $attendance) {
            DB::table('attendances')->insert($attendance);
        }
    }
}
