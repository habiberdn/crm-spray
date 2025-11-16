<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'quantity',
        'discount_price',
        'original_price',
        'name',
        'cover'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'discount_price' => 'decimal:2',
        'original_price' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getSubtotalAttribute()
    {
        return $this->discount_price * $this->quantity;
    }

    /**
     * Get original subtotal (without discount)
     */
    public function getOriginalSubtotalAttribute()
    {
        return $this->original_price * $this->quantity;
    }

    /**
     * Get total savings
     */
    public function getSavingsAttribute()
    {
        return $this->original_subtotal - $this->subtotal;
    }

    /**
     * Scope to get cart items for current user
     */
    public function scopeForCurrentUser($query)
    {
        return $query->where('user_id', auth()->id());
    }

    /**
     * Scope to get cart with product details
     */
    public function scopeWithProduct($query)
    {
        return $query->with(['product', 'product.category', 'product.creator']);
    }

    private function getCartCount()
    {
        $cart = session()->get('cart', []);
        return array_sum(array_column($cart, 'quantity'));
    }

    
}
