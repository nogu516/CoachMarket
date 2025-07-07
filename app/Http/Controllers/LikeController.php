<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function toggleLike($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if ($user->likedProducts()->where('product_id', $id)->exists()) {
            $user->likedProducts()->detach($id);
        } else {
            $user->likedProducts()->attach($id);
        }
        return back();
    }
}
