<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Item;

class ItemController extends Controller
{
    // 例: 商品一覧用のindexメソッド
    public function index()
    {
        $items = Item::all();
        return view('products.index', compact('items'));
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
        return view('items.create');
    }
}
