<?php

namespace App\Models;


use App\Traits\Ownable;
use Illuminate\Support\Str;
use Webpatser\Uuid\Uuid;

class Order extends Model
{
    use Ownable;
    public $incrementing = false;

    protected $keyType = 'string';

    const PAYMENT_COMPLETED = 1;
    const PAYMENT_PENDING = 0;

    /**
     * @var string
     */
    protected $table = 'orders';

    /**
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'transaction_id',
        'orderable_id',
        'orderable_type',
        'title_lb', 'amount', 'payment_status' , 'user_id', 'content_lb',
        'created_by', 'created_by'];


    public function user() {
        return $this->belongsTo(User::class);
    }

    protected static function boot()
    {
        parent::boot();

        User::creating(function ($model) {
            $model->setId();
        });
    }

    public function setId()
    {
        $this->attributes['id'] = Str::uuid();
    }
}
