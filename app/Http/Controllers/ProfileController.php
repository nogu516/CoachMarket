<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function showSetupForm()
    {
        $user = auth()->user();
        return view('profile_edit', ['isEdit' => false, 'user' => $user,]);
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $user->nickname = $request->nickname;
        $user->bio = $request->bio;

        return redirect()->route('home')->with('status', 'プロフィールを設定しました。');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile_edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;

        // バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            //'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user->name = $request->name;
        //$user->email = $request->email;
        $user->bio = $request->bio;

        // 画像がある場合は保存
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('profile_images', 'public');
            $user->profile_image = $path;
        }

        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editAddress()
    {
        $user = Auth::user();
        return view('address_edit', compact('user'));
    }

    public function updateAddress(Request $request)
    {

        $request->validate([
            'postcode' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $user->postcode = $request->postcode;
        $user->address = $request->address;
        $user->building = $request->building;
        $user->save();

        return redirect()->route('profile.edit')->with('success', '住所を更新しました');
    }

    public function purchases()
    {
        $user = auth()->user();
        $purchases = $user->purchases()->with('product')->get();

        return view('purchase', compact('purchases'));
    }

}
