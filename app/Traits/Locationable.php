<?php


namespace App\Traits;
use App\Models\Location;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait Locationable
{
    public function locations(): MorphToMany
    {
        return $this->morphToMany(Location::class, 'locationable', 'locationable')
            ->withTimestamps();
    }

    public function location(...$locations): self
    {
        $this->locations()->attach($this->differenceLocationBetweenExistences($this->normalizeLocation($locations)));
        return $this->load('locations');
    }

    public function unlocation(...$locations): self
    {
        $this->locations()->detach($this->normalizeLocation($locations));
        return $this->load('locations');
    }

    public function delocation(): self
    {
        $this->locations()->sync([]);
        return $this->load('locations');
    }
    public function relocation(...$locations): self
    {
        $this->delocation()->location(...$locations);
        return $this->load('locations');
    }

    public function scopeHasLocations(Builder $builder, ...$locations): Builder
    {
        return $builder->whereHas('locations', function (Builder $query) use ($locations) {
            $query->whereIn('category_id', collect($this->normalizeLocation($locations))->map(function ($category) {
                return Location::descendantsAndSelf($category);
            })->flatten()->pluck('id'));
        });
    }

    public function scopeHasStrictLocations(Builder $builder, ...$locations): Builder
    {
        return $builder->whereHas('locations', function (Builder $query) use ($locations) {
            $query->whereIn('category_id', $this->normalizeLocation($locations));
        });
    }
    /*
     * Convert everything to category ids
     */
    public function normalizeLocation(array $locations): array
    {
        $ids = collect($locations)->map(function ($locations) {
            switch (true) {
                case is_integer($locations) || is_numeric($locations):
                    return $locations;
                case is_string($locations):
                    return Location::firstOrCreate(['name' => $locations])->id;
                case $locations instanceof Location:
                    return $locations->id;
                case is_array($locations):
                    return $this->normalizeLocation($locations);
            }
        })->flatten()->toArray();
        // reject ids not exist in database
        return Location::whereIn('id', $ids)->pluck('id')->toArray();
    }
    protected function differenceLocationBetweenExistences(array $ids): array
    {
        return array_diff($ids, $this->locations->pluck('id')->toArray());
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
