@extends('layouts.app')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell-container">
    <h1>商品の出品</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-section">
            <label>商品画像</label>
            <div class="image-upload-box">
                <input type="file" name="image" id="image" hidden>
                <label for="image" class="image-label">画像を選択する</label>
            </div>

            {{-- プレビュー表示用 --}}
            <div class="preview">
                <img id="imagePreview" src="#" alt="プレビュー画像" style="display: none; max-width: 300px; margin-top: 10px;">
            </div>
        </div>

        {{-- バリデーションエラー --}}
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- 商品の詳細 --}}
        <div class="form-section">
            <h2>商品の詳細</h2>

            <label>カテゴリー</label>
            <div class="category-tags">
                @foreach (['ファッション', '家電', 'インテリア', 'レディース', 'メンズ', 'コスメ', 'ゲーム', 'スポーツ', 'キャラクター', 'ハンドメイド', 'アクセサリー', 'おもちゃ', 'ベビー・キッズ'] as $category)
                <span class="category-tag">{{ $category }}</span>
                @endforeach
            </div>

            <div class="form-group">
                <label for="condition">商品の状態</label>
                <select name="condition" id="condition">
                    <option value="">選択してください</option>
                    <option value="new">良好</option>
                    <option value="like_new">目立った傷や汚れなし</option>
                    <option value="used">やや傷や汚れあり</option>
                    <option value="used">状態が悪い</option>
                </select>
            </div>

            <div class="form-group">
                <label for="name">商品名</label>
                <input type="text" name="name" id="name">
            </div>

            <div class="form-group">
                <label for="brand">ブランド名</label>
                <input type="text" name="brand" id="brand">
            </div>

            <div class="form-group">
                <label for="description">商品の説明</label>
                <textarea name="description" id="description" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="price">販売価格</label>
                <input type="text" name="price" id="price" placeholder="¥">
            </div>
        </div>

        {{-- 出品ボタン --}}
        <div class="form-group">
            <button type="submit" class="submit-button">出品する</button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('imagePreview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });
</script>
@endsection