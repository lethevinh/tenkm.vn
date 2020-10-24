<?php


namespace App\Traits;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait Amenitable
{
    public static function getAmenityClassName(): string
    {
        return Amenity::class;
    }

    public function amenities(): HasMany
    {
        return $this->morphToMany(static::getAmenityClassName(), 'amenitable', 'amenitable')
            ->where('type_lb', 'amenity')
            ->withTimestamps();
    }

    public function devices(): MorphToMany
    {
        return $this->morphToMany(static::getAmenityClassName(), 'amenitable', 'amenitable')
            ->where('type_lb', 'device')
            ->withTimestamps();
    }
    public function direction(): MorphToMany
    {
        return $this->morphToMany(static::getAmenityClassName(), 'amenitable', 'amenitable')
            ->where('type_lb', 'direction')
            ->withTimestamps();
    }

    public function furnitures(): MorphToMany
    {
        return $this->morphToMany(static::getAmenityClassName(), 'amenitable', 'amenitable')
            ->where('type_lb', 'furniture')
            ->withTimestamps();
    }

    public function amenite(...$amenities): self
    {
        $this->amenities()->attach($this->differenceAmenityBetweenExistences($this->normalizeAmenity($amenities)));
        return $this->load('amenities');
    }

    public function unamenite(...$amenities): self
    {
        $this->amenities()->detach($this->normalizeAmenity($amenities));
        return $this->load('amenities');
    }

    public function deamenite(): self
    {
        $this->amenities()->sync([]);
        return $this->load('amenities');
    }
    public function reamenite(...$amenities): self
    {
        $this->deamenite()->amenite(...$amenities);
        return $this->load('amenities');
    }

    public function scopeHasAmenities(Builder $builder, ...$amenities): Builder
    {
        return $builder->whereHas('amenities', function (Builder $query) use ($amenities) {
            $query->whereIn('amenity_id', collect($this->normalizeAmenity($amenities))->map(function ($amenity) {
                return Amenity::descendantsAndSelf($amenity);
            })->flatten()->pluck('id'));
        });
    }

    public function scopeHasStrictAmenities(Builder $builder, ...$amenities): Builder
    {
        return $builder->whereHas('amenities', function (Builder $query) use ($amenities) {
            $query->whereIn('amenity_id', $this->normalizeAmenity($amenities));
        });
    }
    /*
     * Convert everything to amenity ids
     */
    public function normalizeAmenity(array $amenities): array
    {
        $classAmenity = static::getAmenityClassName();
        $ids = collect($amenities)->map(function ($amenities) {
            switch (true) {
                case is_integer($amenities) || is_numeric($amenities):
                    return $amenities;
                case is_string($amenities):
                    return Amenity::firstOrCreate(['name' => $amenities])->id;
                case $amenities instanceof Amenity:
                    return $amenities->id;
                case is_array($amenities):
                    return $this->normalizeAmenity($amenities);
            }
        })->flatten()->toArray();
        // reject ids not exist in database
        return Amenity::whereIn('id', $ids)->pluck('id')->toArray();
    }
    protected function differenceAmenityBetweenExistences(array $ids): array
    {
        return array_diff($ids, $this->amenities->pluck('id')->toArray());
    }
    abstract public function morphToMany(
        $related,
        $name,
        $table = null,
        $foreignPivotKey = null,
        $relatedPivotKey = null,
        $parentKey = null,
        $relatedKey = null,
        $inverse = false
    );
    abstract public function load($relations);
}
