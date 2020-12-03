<?php


namespace App\Traits;

use App\Models\Model;

trait Translatable
{
    public function translator() {
        return $this->belongsTo(static::class, 'translation_id', 'id');
    }

    public function translations() {
        return $this->hasMany(static::class, 'translation_id', 'id');
    }

    public function translation($locale)
    {
        if ($this->language_lb === $locale) {
            return false;
        }
        return $this->translations->add($this->translator)->where('language_lb', $locale)->get(0);
    }

    public static function bootTranslatable() {
        static::created(function (Model $model) {
            if (empty($model->language_lb) || $model->language_lb == config('site.locale_default')) {
                $translate = $model->replicate()->fill([
                    'language_lb' => 'en',
                    'translation_id' => $model->id
                ]);
                if ($translate->save()){
                    $model->update(['translation_id' => $translate->id]);
                }
            }
        });
        static::deleted(function ($model) {
           if ($model->translator) {
               $model->translator->delete();
           }
        });
    }
}
