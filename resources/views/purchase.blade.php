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
                <img src="{{ $product->image ? asset('storage/' . $product->image) : asset('/images/default.png') }}" alt="商品画像" class="product-image">
                <div class="product-info">
                    <h2>{{ $product->name }}</h2>
                    <p class="price">¥{{ number_format($product->price) }}</p>
                </div>
            </div>
            <form action="{{ route('purchase.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="payment-method">
                    <label for="payment">支払い方法</label>
                    <select id="payment" name="payment_method">
                        <option value="">選択してください</option>
                        <option value="credit">クレジットカード</option>
                        <option value="convenience">コンビニ払い</option>
                    </select>
                </div>

                <div class="address-box">
                    <div class="address-header">
                        <span>配送先</span>
                        <a href="{{ route('address.edit') }}">変更する</a>
                    </div>
                    <div class="address-detail">
                        <p>{{ $user->address }}</p>
                    </div>
                </div>
        </div>

        <div class="right-column">
            <div class="summary-box">
                <div class="summary-row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($product->price) }}</span>
                </div>
                <div class="summary-row">
                    <span>支払い方法</span>
                    <span id="selected-payment">コンビニ払い</span>
                </div>
            </div>

            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button type="submit" class="purchase-button">購入する</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('payment');
        const display = document.getElementById('selected-payment');

        const paymentLabels = {
            credit: 'クレジットカード',
            convenience: 'コンビニ払い'
        };

        function updateDisplay() {
            const value = select.value;
            if (paymentLabels[value]) {
                display.textContent = paymentLabels[value];
            } else {
                display.textContent = '未選択';
            }
        }

        select.addEventListener('change', updateDisplay);
        updateDisplay();
    });
</script>
@endsection