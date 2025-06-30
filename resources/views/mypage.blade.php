@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')

<div class="mypage-container">
    <div class="profile-header">
        <div class="profile-image">
        @if(Auth::user()->profile_image)
        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}" alt="プロフィール画像" style="width: 80px; height: 80px; border-radius: 50%;">
    @else
        <img src="{{ asset('images/default-profile.png') }}" alt="デフォルト画像" style="width: 80px; height: 80px; border-radius: 50%;">
    @endif
        </div>
        @auth
        <p>{{ Auth::user()->name }}さん</p>
        @endauth
        <a href="{{ route('profile.edit') }}" class="edit-button">プロフィールを編集する</a>
    </div>

    {{-- 商品タブ --}}
    <div class="tab-menu">
        <button class="tab active" data-target="listed">出品した商品</button>
        <button class="tab" data-target="purchased">購入した商品</button>
    </div>

    {{-- 出品した商品 --}}
    <div id="listed" class="product-section active">
        <div class="product-list">
            @forelse ($listedProducts as $product)
            <div class="product-item">
                <a href="{{ route('products.show', $product->id) }}" class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                    <h3 class="product-name">{{ $product->name }}</h3>
                </a>
            </div>
            @empty
            <p>出品された商品はありません。</p>
            @endforelse
        </div>
    </div>
</div>
{{-- 購入した商品 --}}
<div id="purchased" class="product-section">
    <div class="product-list">
        @forelse ($purchasedProducts as $product)
        <div class="product-item">
        <a href="{{ route('products.show', $product->id) }}" class="product-card">
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            <h3 class="product-name">{{ $product->name }}</h3>
            </a>
        </div>
        @empty
        <p>購入した商品はありません。</p>
        @endforelse
    </div>
</div>
@endsection

@section('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.tab');
        const sections = document.querySelectorAll('.product-section');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // ボタンの active クラス切り替え
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // 対応するセクションの表示切り替え
                const targetId = tab.getAttribute('data-target');
                sections.forEach(sec => sec.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            });
        });
    });
</script>

@endsection