@extends('layouts.app')

@section('content')
<div class="search-results">
    <h2>検索結果</h2>

    @if ($products->isEmpty())
    <p>該当する商品が見つかりませんでした。</p>
    @else
    <ul class="product-list">
        @foreach ($products as $product)
        <li class="product-item">
            <a href="{{ route('products.show', $product->id) }}">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" width="100">
                <p>{{ $product->name }}</p>
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</div>
@endsection