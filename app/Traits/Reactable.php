<?php


namespace App\Traits;
use App\Models\Reaction;
use Dcat\Admin\Models\Administrator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;


trait Reactable
{

    public static function getReactionClassName(): string
    {
        return Reaction::class;
    }

    public function reactions(): MorphToMany
    {
        return $this->morphToMany(static::getReactionClassName(), 'reactable', 'reactable','reactable_id', 'reaction_id')
            ->withTimestamps();
    }

    public function reaction(...$reactions): self
    {
        $user = Auth::user();
        if (!$user) {
            $user = Administrator::first();
        }
        $this->reactions()->attach($this->differenceReactionBetweenExistences($this->normalizeReaction($reactions)), [
            'creator_id' => $user->getAuthIdentifier(),
            'creator_type' =>  $user->getMorphClass()
        ]);
        return $this->load('reactions');
    }

    public function unreaction(...$reactions): self
    {
        $this->reactions()->detach($this->normalizeReaction($reactions));
        return $this->load('reactions');
    }

    public function dereaction(): self
    {
        $this->reactions()->sync([]);
        return $this->load('reactions');
    }
    public function rereaction(...$reactions): self
    {
        $this->dereaction()->reaction(...$reactions);
        return $this->load('reactions');
    }

    public function scopeHasReactions(Builder $builder, ...$reactions): Builder
    {
        return $builder->whereHas('reactions', function (Builder $query) use ($reactions) {
            $query->whereIn('reaction_id', collect($this->normalizeReaction($reactions))->map(function ($reaction) {
                return Reaction::descendantsAndSelf($reaction);
            })->flatten()->pluck('id'));
        });
    }

    public function scopeHasStrictReactions(Builder $builder, ...$reactions): Builder
    {
        return $builder->whereHas('reactions', function (Builder $query) use ($reactions) {
            $query->whereIn('reaction_id', $this->normalizeReaction($reactions));
        });
    }
    /*
     * Convert everything to reaction ids
     */
    public function normalizeReaction(array $reactions): array
    {
        $classReaction = static::getReactionClassName();
        $ids = collect($reactions)->map(function ($reactions) {
            switch (true) {
                case is_integer($reactions) || is_numeric($reactions):
                    return $reactions;
                case is_string($reactions):
                    return Reaction::firstOrCreate(['name' => $reactions])->id;
                case $reactions instanceof Reaction:
                    return $reactions->id;
                case is_array($reactions):
                    return $this->normalizeReaction($reactions);
            }
        })->flatten()->toArray();
        // reject ids not exist in database
        return Reaction::whereIn('id', $ids)->pluck('id')->toArray();
    }
    protected function differenceReactionBetweenExistences(array $ids): array
    {
        return array_diff($ids, $this->reactions->pluck('id')->toArray());
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
