@extends('layouts.app')

@section('title', '商品一覧画面')

@section('styles')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')

<div class="product-page">
    <div class="tab-menu">
        <a href="#" class="tab active">おすすめ</a>
        <a href="#" class="tab active">マイリスト</a>
    </div>
</div>

<div class="item-list d-flex flex-wrap gap-3">
    @if (isset($products) && $products->isEmpty())
    <p>商品はありません。</p>
    @else
    @foreach ($products as $item)
    <div class="item-card border p-3 rounded shadow-sm" style="width: 200px;">
        @if ($item->image)
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid mb-2" style="width: 100%; height: auto;">
        @endif
        <a href="{{ route('products.show', $item->id) }}" class="btn btn-sm btn-outline-primary mt-2">{{ $item->name }}</a>
    </div>
    @endforeach
    @endif
</div>

@endsection