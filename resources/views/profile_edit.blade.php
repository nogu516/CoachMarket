<!-- resources/views/profile_edit.blade.php -->
@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endsection

@section('content')
<div class="profile-edit-container">
    <h1 class="page-title">プロフィール設定</h1>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-form">
        @csrf

        <div class="image-upload">
            <img src="{{ asset('images/default-profile.png') }}" alt="プロフィール画像" class="profile-img">
            <label class="image-select-btn">
                画像を選択する
                <input type="file" name="image" hidden>
            </label>
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}">
        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" id="postcode" name="postcode" value="{{ old('postcode', $user->postcode) }}">
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}">
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $user->building) }}">
        </div>

        <button type="submit" class="update-btn">更新する</button>
    </form>
</div>
@endsection