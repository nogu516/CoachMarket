<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Product extends Model
{
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function isSold(): Attribute
    {
        return Attribute::get(function () {
            return $this->purchases()->exists();
        });
    }

    protected $fillable = [
        'name',
        'brand',
        'price',
        'description',
        'category_id',
        'image',
    ];
}
