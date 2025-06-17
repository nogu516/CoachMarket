@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="item-detail">
        <div class="image-box">
            <img src="{{ asset('storage/' .$product->image) }}" alt="商品画像">
        </div>

        <div class="info-box">
            <h1 class="item-name">{{ $product->name }}</h1>
            <p class="brand-name">{{ $product->brand }}</p>
            <p class="price">¥{{ number_format($product->price) }} <span>（税込）</span></p>

            <div class="icons">
                <span>☆</span>
                <span>💬</span>
            </div>

            <a href="{{ route('purchase.show', ['product_id' => $product->id]) }}" class="buy-button">購入手続きへ</a>

            <div class="description">
                <h2>商品説明</h2>
                <p>カラー：{{ $product->color }}</p>
                <p>{{ $product->description }}</p>
            </div>

            <div class="details">
                <h2>商品の情報</h2>
                <p>カテゴリー：<span class="tag">{{ optional($product->category)->name ?? '未設定' }}</span></p>
                <p>商品の状態：{{ $product->condition }}</p>
            </div>

            <div class="comments">
                <h2>コメント ({{ $product->comments->count() }})</h2>
                @foreach($product->comments as $comment)
                <div class="comment">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->body }}</p>
                </div>
                @endforeach

                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="item_id" value="{{ $product->id }}">
                    <textarea name="body" placeholder="商品へのコメント" required></textarea>
                    <button type="submit" class="comment-btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection