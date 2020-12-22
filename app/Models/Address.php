<?php

namespace App\Models;

use App\Traits\Linkable;
use App\Traits\Ownable;
use function Clue\StreamFilter\remove;

class Address extends Model
{
    use Linkable;
    protected $table = 'address';

    protected $fillable = [
        "provincial_id", "district_id", "ward_id", "street_id", "postal_code_nb", "address_lb", "location_lb", "lat_lb", "lng_lb"
    ];

    public function district()
    {
        return $this->belongsTo(Location::class, 'district_id');
    }

    public function ward()
    {
        return $this->belongsTo(Location::class, 'ward_id');
    }

    public function province()
    {
        return $this->belongsTo(Location::class, 'provincial_id');
    }

    public function street()
    {
        return $this->belongsTo(Location::class, 'street_id');
    }

    public function getDetailAttribute()
    {
        $address = '';
        if ($street = $this->street) {
            $address .= $street->prefix_lb.' '.$street->title_lb. ' ';
        }
        if ($ward = $this->ward) {
            $address .=  $ward->prefix_lb.' '.$ward->title_lb. ' ';
        }
        if ($district = $this->district) {
            $address .=  $district->prefix_lb.' '.$district->title_lb.' ';
        }
        if ($province = $this->province) {
            $address .=  $province->prefix_lb.' '.$province->title_lb;
        }
        return $address;
    }

    public function products() {
        return $this->hasMany(Product::class, 'address_id');
    }

    public function wards() {
        return $this->hasMany(Address::class, 'ward_id', 'ward_id');
    }
}
