<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
