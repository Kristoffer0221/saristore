<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'image',
        'stock',
    ];

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('images/no-image.jpg');
    }

    // Add these helper methods
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    public function hasEnoughStock(int $quantity): bool
    {
        return $this->stock >= $quantity;
    }

    public function decrementStock(int $quantity): bool
    {
        if (!$this->hasEnoughStock($quantity)) {
            return false;
        }

        $this->decrement('stock', $quantity);
        return true;
    }

    public function incrementStock(int $quantity): void
    {
        $this->increment('stock', $quantity);
    }
}
