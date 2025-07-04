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

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'payment_method' => 'required|in:credit,convenience',
        ]);

        $productId = $request->input('product_id');
        // $product = Product::findOrFail($productId);
        $product = Product::findOrFail($request->input('product_id'));
        $user = auth()->user();

        Purchase::create([
            'user_id' => auth()->id(),
            'product_id' => $request->input('product_id'),
            'total_price' => $product->price,
        ]);

        return redirect()->route('mypage', ['tab' => 'purchased'])->with('success', '購入が完了しました！');
    }
}
