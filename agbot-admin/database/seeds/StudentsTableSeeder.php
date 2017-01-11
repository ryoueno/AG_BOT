<?php

use Illuminate\Database\Seeder;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatabaseSeeder::truncateTable('students');

        $students = [
            [
                'id'        => 18110000,
                'line_id'   => "fdsanjAAAAdasndkan",
                'name'      => "StudentA",
                'img'       => "http://k.yimg.jp/images/top/sp2/cmn/logo-ns-131205.png",
                'status'    => 1,
            ],
        ];

        foreach ($students as $student) {
            DB::table('students')->insert($student);
        }
    }
}
