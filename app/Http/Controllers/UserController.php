<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();
        $products = Product::where('user_id', auth()->id())->get();
        return view('mypage', compact('products'));
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact('user'));
    }

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'listed');
        $user = Auth::user();

        $listedProducts = Product::where('user_id', $user->id)->get();

        $purchasedProducts = Purchase::with('product.purchases')
            ->where('user_id', auth()->id())
            ->get()
            ->pluck('product');

        $user = Auth::user()->load('address');

        $purchases = $user->purchases()->with('product')->get();

        return view('mypage', compact('listedProducts', 'purchasedProducts', 'tab' ));
    }
}
