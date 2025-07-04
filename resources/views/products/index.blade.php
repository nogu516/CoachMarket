@extends('layouts.app')

@section('title', '商品一覧画面')

@section('styles')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="product-page">
    <div class="tab-menu" role="tablist">
        <button class="tab active" data-tab="recommend" tabindex="0">おすすめ</button>
        <button class="tab" data-tab="mylist" tabindex="0">マイリスト</button>
    </div>

    {{-- タブ：おすすめ --}}
    <div id="recommend" class="tab-content active">
        @forelse ($recommendedProducts as $item)
        <div class="item-card border p-3 rounded shadow-sm" style="width: 200px;">
            <img src="{{ asset('storage/' . $item->image) }}" class="fixed-image" alt="{{ $item->name }}" style="width: 200px !important; height: auto; object-fit: cover; display: block;">
            <div>{{ $item->name }}（出品者：{{ $item->user->name }}）</div>
        </div>
        @empty
        <p>おすすめの商品はありません。</p>
        @endforelse
    </div>

    {{-- タブ：マイリスト --}}
    <div id="mylist" class="tab-content">
        <div class="item-list">
            @forelse ($mylistProducts as $item)
            <div class="item-card border p-3 rounded shadow-sm" style="width: 200px;">
                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="img-fluid mb-2">
                <div>{{ $item->name }}（出品者：{{ $item->user->name }}）</div>
                @if (!$item->is_sold)
                <span class="btn btn-sm btn-secondary mt-2 disabled">Sold</span>
                @endif
                <a href="{{ route('products.show', $item->id) }}" class="btn btn-sm btn-outline-primary mt-2">{{ $item->name }}</a>
            </div>
            @empty
            <p>マイリストの商品はありません。</p>
            @endforelse
        </div>
    </div>
    @endsection

    @section('scripts')
    <script>
        const tabs = document.querySelectorAll('.tab');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // タブ切替
                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                // コンテンツ表示切替
                const targetId = tab.getAttribute('data-tab');
                contents.forEach(c => c.classList.remove('active'));
                document.getElementById(targetId).classList.add('active');
            });

            // タブキー対応（Enterで選択）
            tab.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    tab.click();
                }
            });
        });
    </script>

    @endsection