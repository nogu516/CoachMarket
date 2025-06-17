<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

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
}
