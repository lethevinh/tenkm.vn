<?php


namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait Categorizable
{
    public static function getCategoryClassName(): string
    {
        $modelKey = class_basename(static::class);
        $class = Category::class;
        $modelTagClass = "App\\Models\\".$modelKey."Category";
        if (class_exists($modelTagClass)) {
            $class = $modelTagClass;
        }
        return $class;
    }

    public function categories(): MorphToMany
    {
        return $this->morphToMany(static::getCategoryClassName(), 'categorizable', 'categorizable','categorizable_id', 'category_id')
            ->withTimestamps();
    }

    public function categorize(...$categories): self
    {
        $this->categories()->attach($this->differenceBetweenExistences($this->normalize($categories)));
        return $this->load('categories');
    }

    public function uncategorize(...$categories): self
    {
        $this->categories()->detach($this->normalize($categories));
        return $this->load('categories');
    }

    public function decategorize(): self
    {
        $this->categories()->sync([]);
        return $this->load('categories');
    }
    public function recategorize(...$categories): self
    {
        $this->decategorize()->categorize(...$categories);
        return $this->load('categories');
    }

    public function scopeHasCategories(Builder $builder, ...$categories): Builder
    {
        return $builder->whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('category_id', collect($this->normalize($categories))->map(function ($category) {
                return Category::descendantsAndSelf($category);
            })->flatten()->pluck('id'));
        });
    }

    public function scopeHasStrictCategories(Builder $builder, ...$categories): Builder
    {
        return $builder->whereHas('categories', function (Builder $query) use ($categories) {
            $query->whereIn('category_id', $this->normalize($categories));
        });
    }
    /*
     * Convert everything to category ids
     */
    public function normalize(array $categories): array
    {
        $classCategory = static::getCategoryClassName();
        $ids = collect($categories)->map(function ($categories) {
            switch (true) {
                case is_integer($categories) || is_numeric($categories):
                    return $categories;
                case is_string($categories):
                    return Category::firstOrCreate(['name' => $categories])->id;
                case $categories instanceof Category:
                    return $categories->id;
                case is_array($categories):
                    return $this->normalize($categories);
            }
        })->flatten()->toArray();
        // reject ids not exist in database
        return Category::whereIn('id', $ids)->pluck('id')->toArray();
    }
    protected function differenceBetweenExistences(array $ids): array
    {
        return array_diff($ids, $this->categories->pluck('id')->toArray());
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
