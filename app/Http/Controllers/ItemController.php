<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    // 例: 商品一覧用のindexメソッド
    public function index()
    {
        $items = Item::all();
        // おすすめ商品（全商品やおすすめロジックによる）
        $recommendedProducts = Product::latest()->take(10)->get();

        // イイねした商品一覧
        $mylistProducts = auth()->check()
            ? auth()->user()->likedProducts()->get()
            : collect();

        return view('products.index', compact('items', 'recommendedProducts', 'mylistProducts'));
    }

    // 商品詳細用のshowメソッド
    public function show($id)
    {
        $item = Item::with(['comments.user', 'category'])->findOrFail($id);
        $user = auth()->user();
        return view('products.show', ['product' => $item]);
    }

    public function create()
    {
        $categories = Category::all(); // 全カテゴリを取得
        return view('items.create', compact('categories'));
    }

}
