<?php


namespace App\Traits;

use App\Models\Order;
use App\Models\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model as BaseModel;

trait Orderable
{
    /**
     * The name of the orders model.
     *
     * @return string
     */
    public function orderableModel(): string
    {
        return Order::class;
    }

    /**
     * The orders attached to the model.
     *
     * @return MorphMany
     */
    public function orders(): MorphMany
    {
        return $this->morphMany($this->orderableModel(), 'orderable');
    }

    /**
     * The orders attached to the model.
     *
     * @return MorphMany
     */
    public function publicOrders(): MorphMany
    {
        return $this->orders()->where('status_sl', 'public');
    }

    /**
     * Create a order.
     *
     * @param array $data
     * @param BaseModel $creator
     * @return static
     */
    public function order(array $data, BaseModel $creator)
    {
        $orderableModel = $this->orderableModel();
        return (new $orderableModel())->createOrder($this, $data, $creator);
    }

    /**
     * Update a order.
     *
     * @param $id
     * @param $data
     * @return mixed
     */
    public function updateOrder($id, $data)
    {
        $orderableModel = $this->orderableModel();
        return (new $orderableModel())->updateOrder($id, $data);
    }
    /**
     * Delete a order.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function deleteOrder(int $id): bool
    {
        $orderableModel = $this->orderableModel();
        return (bool) (new $orderableModel())->deleteOrder($id);
    }
    /**
     * The amount of orders assigned to this model.
     *
     * @return mixed
     */
    public function orderCount(): int
    {
        return $this->orders->count();
    }

    public static function bootOrderable() {
        static::deleted(function ($model) {
            $model->orders()->delete();
        });
    }
}
