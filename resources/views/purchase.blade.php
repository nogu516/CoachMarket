@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase-container">
    <h1 class="page-title">商品購入画面</h1>

    <div class="purchase-content">
        <div class="left-column">
            <div class="product-box">
                <img src="{{ $item->image_url ?? '/images/default.png' }}" alt="商品画像" class="product-image">
                <div class="product-info">
                    <h2>{{ $item->name }}</h2>
                    <p class="price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="payment-method">
                <label for="payment">支払い方法</label>
                <select id="payment" name="payment_method">
                    <option value="">選択してください</option>
                    <option value="credit">クレジットカード</option>
                    <option value="convenience">コンビニ払い</option>
                </select>
            </div>

            <hr>

            <div class="address-box">
                <div class="address-header">
                    <span>配送先</span>
                    <a href="{{ route('address.edit') }}">変更する</a>
                </div>
                <div class="address-detail">
                    <p>{{ $user->name }}</p>
                    <p>{{ $user->address }}</p>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="summary-box">
                <div class="summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span>コンビニ払い</span>
                </div>
            </div>

            <form action="{{ route('purchase.complete') }}" method="POST">
                @csrf
                <button type="submit" class="purchase-button">購入する</button>
            </form>
        </div>
    </div>
</div>
@endsection