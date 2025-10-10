<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Diskon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'start_date',
        'end_date'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
