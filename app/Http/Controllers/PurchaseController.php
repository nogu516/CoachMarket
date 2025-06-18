<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class PurchaseController extends Controller
{
    public function show($product_id)
    {
        $product = product::findOrFail($product_id);
        $user = auth()->user();

        return view('purchase', compact('product', 'user'));
    }

    public function complete(Request $request)
    {

        $product_id = $request->input('product_id');
        $item = product::findOrFail($product_id);

        return redirect()->route('products.index')->with('success', '購入が完了しました！');
    }
}
