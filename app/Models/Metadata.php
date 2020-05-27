<?php

namespace App\Models;

use App\Traits\Ownable;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static updateOrCreate(array $array, string[] $array1)
 */
class Metadata extends Model
{
    use Ownable;

    protected $table = 'metadata';

    protected $fillable = [
        'key_lb', 'value_lb', 'label_lb', 'status_sl', 'metadatable_id', 'metadatable_type'
    ];

}
