<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Purchase;


class PurchaseController extends Controller
{
    public function show($product_id)
    {

        $product = Product::findOrFail($product_id);
        $user = auth()->user();

        return view('purchase', compact('product', 'user'));
    }

    public function store(Request $request)
    {
        $productId = $request->input('product_id');
        $product = Product::findOrFail($productId);
        $user = auth()->user();

        Purchase::create([
            'user_id' => auth()->id(),
            'product_id' => $request->input('product_id'),
            'total_price' => $product->price,
        ]);

        return redirect()->route('purchases')->with('success', '購入が完了しました！');
    }
}
