<?php

use Illuminate\Database\Seeder;

class BeaconsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DatabaseSeeder::truncateTable('beacons');

        $beacons = [
            [
                'id'      => 'ABCD1234EFGH6789',
                'room_id' => 'B801',
            ],
        ];

        foreach ($beacons as $beacon) {
            DB::table('beacons')->insert($beacon);
        }
    }
}
