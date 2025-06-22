@extends('layouts.app')

@section('title', '商品一覧画面')

@section('styles')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="product-page">
    <div class="tab-menu">
        <button class="tab active">おすすめ</button>
        <button class="tab">マイリスト</button>
    </div>
</div>

<div class="item-list d-flex flex-wrap gap-3">
    @if(count($products) > 0)
    @foreach ($products as $item)
    <div class="item-card border p-3 rounded shadow-sm" style="width: 200px;">
        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid mb-2" style="width: 100%; height: auto;">
        <div>{{ $item->name }}（出品者：{{ $item->user->name }}）</div>
        @if (!$item->is_sold)
        <span class="btn btn-sm btn-secondary mt-2 disabled">Sold</span>
        @endif
        <a href="{{ route('products.show', $item->id) }}" class="btn btn-sm btn-outline-primary mt-2">{{ $item->name }}</a>
    </div>
    @endforeach
    @else
    <p>商品はありません。</p>
    @endif
</div>

@endsection