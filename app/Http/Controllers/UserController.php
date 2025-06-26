<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $products = Product::where('user_id', auth()->id())->get();
        return view('mypage', compact('products'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function index()
    {
        $user = Auth::user();

        // 出品商品
        $listedProducts = Product::where('user_id', $user->id)->get();

        // 購入商品（Purchase モデルと Product モデルがリレーションしている場合）
        $purchasedProducts = Product::whereHas('purchases', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();

        return view('mypage', compact('listedProducts', 'purchasedProducts'));
    }
}
