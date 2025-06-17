@extends('layouts.app')

@section('title', 'ログイン')

@section('styles')
<link href="{{ asset('css/login.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="login-container">
    <h2 class="login-title">ログイン</h2>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="email">メールアドレス</label>
            <input type="email" id="email" name="email" required>
            @error('email')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
            @error('password')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="login-button">ログインする</button>
    </form>

    <div class="register-link">
        <a href="{{ route('register') }}">会員登録はこちら</a>
    </div>
</div>
@endsection