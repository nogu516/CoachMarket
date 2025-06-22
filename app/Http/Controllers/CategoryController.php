<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * 指定されたカテゴリの商品一覧を表示
     */
    public function show(Category $category)
    {
        // 指定カテゴリに紐づく商品を取得（例：Productにcategory_idがある前提）
        $products = Product::where('category_id', $category->id)->get();

        return view('products.category', compact('category', 'products'));
    }
}
