<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * set cities data
     *
     * @return void
     */
    public function run()
    {
        ini_set('memory_limit', '-1');

        $fileData = File::get(Config::get('openweather.cities_path'));
        $cities = json_decode($fileData);

        DB::table('cities')->truncate();

        $data = [];
        foreach ($cities as $index => $city) {
            $data[$index]['code'] = $city->id;
            $data[$index]['name'] = $city->name;
        }

        DB::table('cities')->insert($data);
    }
}
