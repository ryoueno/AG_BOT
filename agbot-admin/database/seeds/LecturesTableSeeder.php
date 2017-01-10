<?php

use Illuminate\Database\Seeder;

class LecturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatabaseSeeder::truncateTable('lectures');

        $lectures = [
            [
                'id'      => 1,
                'user_id' => 1,
                'name'    => 'インターネット入門',
                'room_id' => 'B801',
            ],
            [
                'id'      => 2,
                'user_id' => 1,
                'name'    => 'インターネット基礎',
                'room_id' => 'B802',
            ],
            [
                'id'      => 3,
                'user_id' => 1,
                'name'    => 'インターネット応用',
                'room_id' => 'B803',
            ],
        ];

        foreach ($lectures as $lecture) {
            DB::table('lectures')->insert($lecture);
        }
    }
}
