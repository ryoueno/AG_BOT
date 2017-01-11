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
                'id'      => '00000000-48A4-1001-B000-001C4D175E4E',
                'room_id' => 'B801',
            ],
        ];

        foreach ($beacons as $beacon) {
            DB::table('beacons')->insert($beacon);
        }
    }
}
