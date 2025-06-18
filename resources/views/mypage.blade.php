@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage-container">
    <div class="profile-header">
        <div class="profile-image"></div>
            @auth
            <p>{{ Auth::user()->name }}さん</p>
            @endauth
                <a href="{{ route('profile.edit') }}" class="edit-button">プロフィールを編集する</a>
        </div>

        {{-- 商品タブ --}}
        <div class="tab-menu">
            <button class="tab active">出品した商品</button>
            <button class="tab">購入した商品</button>
        </div>

        {{-- 商品一覧 --}}
        <div class="product-list">
            @if(count($products) > 0)
            @foreach ($products as $product)
            <div>
                <img src="{{ asset('storage/' . $product->image) }}" width="200">
                <h3>{{ $product->name }}</h3>
            </div>
            @endforeach
            @else
            <p>出品された商品はありません。</p>
            @endif
        </div>
    </div>

    @endsection