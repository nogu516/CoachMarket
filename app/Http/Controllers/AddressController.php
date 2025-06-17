<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function edit()
    {
        return view('address_edit'); // view ファイルは適宜作成
    }

    public function update(Request $request)
    {
        // バリデーションや保存処理
        $request->validate([
            'postal_code' => 'required',
            'address' => 'required',
        ]);

        $productId = session('product_id');

        if (!$productId) {
            return redirect()->route('products.index')->with('error', '商品が指定されていません');
        }

        return redirect()->route('purchase.show', ['product_id' => session('product_id')])
            ->with('message', '住所を更新しました');
    }
}
