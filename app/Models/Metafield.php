<?php

namespace App\Models;

use App\Traits\Ownable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array, string[] $array1)
 */
class Metafield extends Model
{
    use Ownable;

    protected $table = 'fieldable';

    protected $fillable = [
        'name_lb', 'default_lb', 'label_lb', 'order_nb', 'status_sl', 'fieldable_id', 'fieldable_type', 'type_lb'
    ];

}
