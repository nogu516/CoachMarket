<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class PurchaseController extends Controller
{
    public function show($item_id)
    {
        $item = \App\Models\Item::findOrFail($item_id);
        $user = auth()->user();

        return view('purchase', compact('item', 'user'));
    }

    public function complete(Request $request)
    {
        // バリデーションなど購入処理

        return redirect()->route('products.index')->with('success', '購入が完了しました！');
    }
}
