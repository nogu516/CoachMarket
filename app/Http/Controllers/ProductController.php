<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Item;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * 商品一覧画面を表示
     */
    public function index()
    {
        $user = auth()->user();
        $products = Product::latest()->get();

        // ログインユーザーがいるか確認
        if ($user) {
            $mylistProducts = $user->likedProducts()->get();
        } else {
            $mylistProducts = collect(); // 空のコレクションを返す
        }

        $products = Product::with(['user', 'purchases'])->latest()->paginate(12);
        $recommendedProducts = Product::where('is_recommended', true)->get();

        $products = Product::latest()->get();

        $likedProductIds = auth()->check()
            ? auth()->user()->likedProducts->pluck('id')->toArray()
            : [];

        return view('products.index', compact('products', 'recommendedProducts', 'mylistProducts' , 'likedProductIds'));
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
        $categories = Category::all(); // カテゴリを全件取得
        return view('products.sell', compact('categories'));
    }

    public function store(Request $request)
    {
        // バリデーション（画像が必須の場合）
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|integer',
            'image' => 'required|image|max:2048', // 画像ファイル (2MBまで)
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        // 商品インスタンス作成
        $product = new Product($validated);
        $product->fill($validated);
        // $product->name = $request->input('name');
        // $product->brand = $request->input('brand');
        // $product->price = $request->input('price');
        // $product->description = $request->input('description');
        // $product->category_id = $request->input('category_id');
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
        $user = auth()->user();

        $listedProducts = \App\Models\Product::where('user_id', $user->id)->get();
        $purchasedProducts = $user->purchases()->with('product')->get()->pluck('product');

        return view('mypage', [
            'products' => $listedProducts, // 任意：共通変数名としても使える
            'listedProducts' => $listedProducts,
            'purchasedProducts' => $purchasedProducts,
        ]);
    }

    public function recommended()
    {
        return view('products.index', ['products' => collect()]);
    }

    public function favorites()
    {
        return view('products.index', ['products' => collect()]);
    }

    public function purchase(Request $request, Product $product)
    {
        if ($product->is_sold) {
            return back()->with('error', 'この商品はすでに購入済みです。');
        }

        $product->update([
            'is_sold' => true,
            'payment_method' => $request->payment_method,
        ]);

        return redirect()->route('products.index')->with('success', '購入が完了しました！');
    }

    public function destroy(Product $product)
    {
        // ログインユーザーが出品者かどうかを確認
        if (auth()->id() !== $product->user_id) {
            abort(403, '削除権限がありません');
        }

        // 画像ファイルをストレージから削除（任意）
        if ($product->image) {
            \Storage::delete('public/' . $product->image);
        }

        // 商品削除
        $product->delete();

        return redirect()->route('mypage')->with('success', '商品を削除しました');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (empty($keyword)) {
            // キーワードがない場合は結果を空に
            $products = collect(); // 空のコレクションを渡す
        } else {
            $products = Product::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->get();
        }

        return view('products.search_results', ['products' => $products, 'keyword' => $keyword]);
    }
}
