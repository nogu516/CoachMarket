<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function toggleLike($id)
    {
        $product = Product::findOrFail($id);
        $user = Auth::user();

        if ($user->likedProducts()->where('product_id', $id)->exists()) {
            // すでにいいねしてたら外す
            $user->likedProducts()->detach($id);
        } else {
            // いいね追加
            $user->likedProducts()->attach($id);
        }
        return back(); // or return response()->json() if using AJAX
    }
}
