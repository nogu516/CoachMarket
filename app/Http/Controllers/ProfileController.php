<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = auth()->user();
        return view('profile_edit', ['isEdit' => true, 'user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // バリデーション
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => 'required|email|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:2048',
        ]);

        // ユーザー情報の更新
        //$user->name = $validated['name'.'postcode'.'address'. 'building'];
        //$user->save();

        // プロフィール情報の更新
        //$user->profile()->updateOrCreate(
        //['user_id' => $user->id],['bio' => $validated['bio'] ?? null]);

        // アイコン画像の保存
        //if ($request->hasFile('avatar')) {
        //$path = $request->file('avatar')->store('avatars', 'public');
        //$user->profile()->update(['avatar' => $path]);

        return redirect()->route('profile.edit')->with('message', 'プロフィールを更新しました');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
}
