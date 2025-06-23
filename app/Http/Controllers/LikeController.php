<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LikeController extends Controller
{

    public function toggle(Product $product)
    {
        $user = auth()->user();

        $like = $product->likes()->where('user_id', $user->id)->first();

        if ($like) {
            $like->delete();
        } else {
            $product->likes()->create([
                'user_id' => $user->id
            ]);
        }

        return back(); // or return response()->json() if using AJAX
    }
}
