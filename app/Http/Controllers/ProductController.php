<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $products = Product::latest()->get();

        if ($user) {
            $mylistProducts = $user->likedProducts()->get();
        } else {
            $mylistProducts = collect();
        }

        $products = Product::with(['user', 'purchases'])->latest()->paginate(12);
        $recommendedProducts = Product::where('is_recommended', true)->get();

        $products = Product::latest()->get();

        $likedProductIds = auth()->check()
            ? auth()->user()->likedProducts->pluck('id')->toArray()
            : [];

        return view('products.index', compact('products', 'recommendedProducts', 'mylistProducts', 'likedProductIds'));
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
        $categories = Category::all();
        return view('products.sell', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|integer',
            'image' => 'required|image|max:2048',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = new Product($validated);
        $product->fill($validated);
        $product->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $product->image = $path;
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
            'products' => $listedProducts,
            'listedProducts' => $listedProducts,
            'purchasedProducts' => $purchasedProducts,
        ]);
    }

    public function recommended()
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
        if (auth()->id() !== $product->user_id) {
            abort(403, '削除権限がありません');
        }

        if ($product->image) {
            \Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return redirect()->route('mypage')->with('success', '商品を削除しました');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        if (empty($keyword)) {
            $products = collect();
        } else {
            $products = Product::where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->get();
        }

        return view('products.search_results', ['products' => $products, 'keyword' => $keyword]);
    }
}
