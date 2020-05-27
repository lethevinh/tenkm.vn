<?php


namespace App\Traits;

use App\Observers\OwnableObserver;

trait Ownable
{
    public static function bootOwnable()
    {
        static::observe(app(OwnableObserver::class));
    }

    /**
     * Get the user that created the model.
     */
    public function creator()
    {
        $adminModel = config('admin.database.users_model');
        return $this->belongsTo($adminModel, 'created_by');
    }
    /**
     * Get the user that edited the model.
     */
    public function editor()
    {
        $adminModel = config('admin.database.users_model');
        return $this->belongsTo($adminModel, 'updated_by');
    }
}
