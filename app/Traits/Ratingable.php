<?php
namespace App\Traits;

use App\Models\Rating;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Mix;

trait Ratingable
{
    /**
     * @return MorphMany
     */
    public function ratings():MorphMany
    {
        return $this->morphMany(Rating::class, 'ratingable');
    }

    /**
     *
     * @return mix
     */
    public function avgRating()
    {
        return $this->ratings()->avg('rating_nb');
    }
    /**
     *
     * @return mix
     */
    public function sumRating()
    {
        return $this->ratings()->sum('rating_nb');
    }

    /**
     * @param int $max
     *
     * @return float|int
     */
    public function ratingPercent($max = 5)
    {
        $quantity = $this->ratings()->count();
        $total = $this->sumRating();
        return ($quantity * $max) > 0 ? $total / (($quantity * $max) / 100) : 0;
    }

    /**
     *
     * @return int
     */
    public function countPositive()
    {
        return $this->ratings()->where('rating_nb', '>', '0')->count();
    }
    /**
     *
     * @return string
     */
    public function countNegative()
    {
        $quantity = $this->ratings()->where('rating_nb', '<', '0')->count();
        return ("-$quantity");
    }

    /**
     * @param $data
     * @return BaseModel
     */
    public function rating($data)
    {
        return $this->ratings()->firstOrCreate($data);
    }

    /**
     * @param $data
     * @param BaseModel $author
     * @param BaseModel $parent
     *
     * @return Rating|array
     */
    public function ratingUnique($data, BaseModel $author, BaseModel $parent = null)
    {
        return (new Rating())->createUniqueRating($this, $data, $author);
    }

    /**
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateRating($id, $data)
    {
        return $this->ratings()->find($id)->update($data);
    }

    /**
     * @param $id
     *
     * @return mixed
     * @throws \Exception
     */
    public function deleteRating($id)
    {
        return $this->ratings()->find($id)->delete();
    }
    public function getAvgRatingAttribute()
    {
        return $this->avgRating();
    }
    public function getratingPercentAttribute()
    {
        return $this->ratingPercent();
    }
    public function getSumRatingAttribute()
    {
        return $this->sumRating();
    }
    public function getCountPositiveAttribute()
    {
        return $this->countPositive();
    }
    public function getCountNegativeAttribute()
    {
        return $this->countNegative();
    }

    public static function bootRatingable() {
        static::deleted(function ($model) {
            $model->ratings()->delete();
        });
    }
}
