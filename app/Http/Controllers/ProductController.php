<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Item;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示
     */
    public function index()
    {
        $products = Product::all(); // 商品一覧を取得
        return view('products.index', compact('products'));
    }

    /**
     * 商品詳細画面を表示
     */
    public function show($id)
    {
        $user = auth()->user();
        $product = Product::with(['category', 'comments.user'])->findOrFail($id);
        return view('products.show', compact('product'));
    }

    public function create()
    {
        return view('products.sell');
    }

    public function store(Request $request)
    {
        // バリデーション（画像が必須の場合）
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|integer',
            'image' => 'required|image|max:2048', // 画像ファイル (2MBまで)
            'description' => 'nullable|string',
        ]);

        // 商品インスタンス作成
        $product = new Product();
        $product->name = $request->input('name');
        $product->brand = $request->input('brand');
        $product->price = $request->input('price');
        $product->description = $request->input('description');
        $product->user_id = auth()->id();

        // アップロードされた画像を storage/app/public/images に保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');  // 'images/ファイル名.jpg'
            $product->image = $path;
            // 相対パス（例：images/xxx.jpg）を保存
        }

        $product->save();

        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    public function mypage()
    {
        // ログインユーザーが出品した商品を取得（例）
        $products = Product::where('user_id', auth()->id())->get();
        return view('mypage', compact('products'));
    }

    public function recommended()
    {
        return view('products.index', ['products' => collect()]);
    }

    public function favorites()
    {
        return view('products.index', ['products' => collect()]);
    }
}
