<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Storage;
use \App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
        $amenities = json_decode(Storage::disk('resource')->get('json/amenities.json'), true);
        foreach ($amenities as $key => $amenity) {
            Amenity::create([
                'title_lb'=> $amenity['name'],
                'type_lb'=>'amenity'
            ]);
        }
        $devices = json_decode(Storage::disk('resource')->get('json/devices.json'), true);
        foreach ($devices as $key => $device) {
            Amenity::create([
                'title_lb'=> $device['name'],
                'type_lb'=>'device'
            ]);
        }
        $furnitures = json_decode(Storage::disk('resource')->get('json/furnitures.json'), true);
        foreach ($furnitures as $key => $furniture) {
            Amenity::create([
                'title_lb'=> $furniture['name'],
                'type_lb'=>'furniture'
            ]);
        }
        $directions = json_decode(Storage::disk('resource')->get('json/directions.json'), true);
        foreach ($directions as $key => $direction) {
            Amenity::create([
                'title_lb'=> $direction['name'],
                'type_lb'=>'direction'
            ]);
        }
    }
}
