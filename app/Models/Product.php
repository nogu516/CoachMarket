<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
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

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function purchases()
    {
        return $this->hasMany(\App\Models\Purchase::class);
    }
    public function isPurchasedByAuthUser(): bool
    {
        return $this->purchases->contains('user_id', Auth::id());
    }
}
