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
                <form action="{{ route('products.like', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="like-button">
                        @if (auth()->check() && auth()->user()->likedProducts->contains($product->id))
                        ★ いいねを取り消す
                        @else
                        ☆ いいねする
                        @endif
                    </button>
                </form>

                <p>{{ optional($product->likes)->count() ?? 0 }}件のいいね</p>
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
                <p>
                    カテゴリー：
                    @if ($product->category)
                    <a href="{{ route('category.show', $product->category->id) }}" class="tag">
                        {{ $product->category->name }}
                    </a>
                    @else
                    <span class="tag">{{ optional($product->category)->name ?? '未設定' }}</span>
                    @endif
                </p>

                <p>商品の状態：{{ $product->condition }}</p>
            </div>
            @auth
            @if (Auth::id() === $product->user_id)
            <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">削除する</button>
            </form>
            @endif
            @endauth

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
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <textarea name="content" placeholder="商品へのコメント" required>{{ old('content') }}</textarea>
                    <button type="submit" class="comment-btn">コメントを送信する</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection