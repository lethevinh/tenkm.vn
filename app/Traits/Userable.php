<?php


namespace App\Traits;
use App\Models\User;
use App\Models\Skill;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


trait Userable
{

    public function users(): MorphToMany
    {
        return $this->morphToMany(User::class, 'userable', 'userable')
            ->withPivot([
                'type_lb',
                'published_at'
            ])
            ->withTimestamps();
    }

    public function teachers(): MorphToMany
    {
        return $this->morphToMany(User::class, 'userable', 'userable')
            ->wherePivot('type_lb', 'teacher')
            ->withPivot([
                'type_lb',
                'published_at'
            ])
            ->withTimestamps();
    }

    public function attachUser($users,$type = 'teacher'): self
    {
        if (!is_array($users)) {
            $users = [$users];
        }
        $diffUsers = $this->differenceBetweenExistencesUser($this->normalizeUser($users));
        foreach ($diffUsers as $user) {
            $this->users()->attach($user, ['type_lb' => $type]);
        }
        return $this->load('users');
    }

    public function detachUser(...$users): self
    {
        $this->users()->detach($this->normalizeUser($users));
        return $this->load('users');
    }

    public function deUserable(): self
    {
        $this->users()->sync([]);
        return $this->load('users');
    }
    public function reUserable(...$users): self
    {
        $this->decategorize()->categorize(...$users);
        return $this->load('users');
    }

    public function scopeHasUsers(Builder $builder, ...$users): Builder
    {
        return $builder->whereHas('users', function (Builder $query) use ($users) {
            $query->whereIn('user_id', collect($this->normalizeUser($users))->map(function ($user) {
                return User::descendantsAndSelf($user);
            })->flatten()->pluck('id'));
        });
    }

    public function scopeHasStrictUsers(Builder $builder, ...$users): Builder
    {
        return $builder->whereHas('users', function (Builder $query) use ($users) {
            $query->whereIn('user_id', $this->normalizeUser($users));
        });
    }
    /*
     * Convert everything to category ids
     */
    public function normalizeUser(array $users): array
    {
        $ids = collect($users)->map(function ($users) {
            switch (true) {
                case is_integer($users) || is_numeric($users):
                    return $users;
                case is_string($users):
                    return User::firstOrCreate(['name' => $users])->id;
                case $users instanceof User:
                    return $users->id;
                case is_array($users):
                    return $this->normalizeUser($users);
            }
        })->flatten()->toArray();
        // reject ids not exist in database
        return User::whereIn('id', $ids)->pluck('id')->toArray();
    }
    protected function differenceBetweenExistencesUser(array $ids): array
    {
        return array_diff($ids, $this->users->pluck('id')->toArray());
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
