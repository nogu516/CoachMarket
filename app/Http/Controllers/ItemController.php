<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Item;

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

        return redirect()->route('products.index', ['tab' => 'mylist']);
    }
}
