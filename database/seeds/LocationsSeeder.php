<?php

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\Storage;
use App\Models\Location;
class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws FileNotFoundException
     */
    public function run()
    {
       $locations = json_decode(Storage::disk('resource')->get('json/locations.json'), true);
       $provincials = [];
       foreach ($locations as $key => $location) {
           $provincial = $this->createLocation($location);
           if ($provincial) {
               $provincials[$key] = $provincial;
           }
       }
       foreach ($locations as $key => $location) {
           $provincial = $provincials[$key];
           foreach ($location['district'] as $district) {
               $this->createLocation($district, $provincial,'district');
           }
       }
    }

    function createLocation($location, $parent = null, $type = 'provincial') {
        switch ($type) {
            case 'provincial' :
                //provincial
                return Location::create([
                    'title_lb' => $location['name'],
                    'code_lb' => $location['code'],
                    'address_lb' => $location['name'],
                    'type_lb' => 'provincial',
                    'status_sl' => 'public'
                ]);
                break;
            case 'district' :
                //district
                $district = Location::create([
                    'title_lb' => $location['name'],
                    'prefix_lb' => $location['pre'],
                    'parent_id' => $parent->id,
                    'type_lb' => $type,
                    'status_sl' => 'public'
                ]);
                if ($district && !empty($location['project'])) {
                    foreach ($location['project'] as $project) {
                        $this->createLocation($project, $district, 'project');
                    }
                }
                if ($district && !empty($location['street'])) {
                    foreach ($location['street'] as $street) {
                        $this->createLocation($street, $district, 'street');
                    }
                }
                if ($district && !empty($location['ward'])) {
                    foreach ($location['ward'] as $ward) {
                        $this->createLocation($ward, $district, 'ward');
                    }
                }
                break;
            case 'project' :
                //project
                Location::create([
                    'title_lb' => $location['name'],
                    'location_lb' => $location['lat'].','.$location['lng'],
                    'parent_id' => $parent->id,
                    'type_lb' => $type,
                    'status_sl' => 'public'
                ]);
                break;
            case 'street' :
                //street
               Location::create([
                    'title_lb' => $location['name'],
                    'prefix_lb' => $location['pre'],
                    'parent_id' => $parent->id,
                    'type_lb' => $type,
                    'status_sl' => 'public'
                ]);
                break;
            case 'ward' :
                //ward
                Location::create([
                    'title_lb' => $location['name'],
                    'prefix_lb' => $location['pre'],
                    'parent_id' => $parent->id,
                    'type_lb' => $type,
                    'status_sl' => 'public'
                ]);
                break;
        }
    }
}
