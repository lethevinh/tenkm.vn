<?php

namespace App\Models;

use App\Traits\Linkable;

class Address extends Model
{
    protected $table = 'address';

    use Linkable;

    protected $fillable = [
        "provincial_id", "district_id", "ward_id", "street_id", "show_in_parrent", "postal_code_nb", "address_lb", "type_lb", "status_lb", "location_lb", "lat_lb", "lng_lb"
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

    public function getTitleLbAttribute()
    {
        return $this->attributes['address_lb'];
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

    public function product() {
        return $this->hasOne(Product::class, 'address_id');
    }

    public function projects() {
        return $this->hasMany(Project::class, 'address_id');
    }

    public function districts() {
        return $this->hasMany(Address::class, 'district_id', 'district_id');
    }

    public function wards() {
        return $this->hasMany(Address::class, 'ward_id', 'ward_id');
    }

    public function productsInWard() {
        return $this->hasMany(Address::class, 'ward_id', 'ward_id')
            ->whereNotNull('street_id')->whereNull('status_lb');
    }
}
