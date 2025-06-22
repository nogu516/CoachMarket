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
                <label for="image" class="image-label" id="imageLabel">画像を選択する</label>
                <div class="preview">
                    <img id="imagePreview" src="#" alt="プレビュー画像" style="display: none; max-width: 300px; margin-top: 10px;">
                </div>
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

            {{-- カテゴリータグ一覧 --}}
            <div class="category-tags">
                @foreach ($categories as $category)
                <span class="category-tag" data-id="{{ $category->id }}">{{ $category->name }}</span>
                @endforeach
            </div>

            {{-- 1つだけの hidden input（← foreach の外） --}}
            <input type="hidden" name="category_id" id="selected-category" value="">
        </div>

        <script>
            const tags = document.querySelectorAll('.category-tag');
            const hiddenInput = document.getElementById('selected-category');

            tags.forEach(tag => {
                tag.addEventListener('click', () => {
                    tags.forEach(t => t.classList.remove('selected')); // 全タグの選択を解除
                    tag.classList.add('selected'); // 選択されたタグだけハイライト
                    hiddenInput.value = tag.dataset.id; // hidden input に値をセット
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const tags = document.querySelectorAll('.category-tag');
                const hiddenInput = document.getElementById('selected-category');

                tags.forEach(tag => {
                    tag.addEventListener('click', () => {
                        // 全タグから選択スタイル削除
                        tags.forEach(t => t.classList.remove('selected'));
                        // 今クリックされたタグだけ選択状態に
                        tag.classList.add('selected');
                        // data-id を hidden input にセット
                        hiddenInput.value = tag.dataset.id;
                        console.log('選択したカテゴリーID:', hiddenInput.value); // デバッグ用
                    });
                });
            });

            // 画像プレビュー処理（そのままでOK）
            document.getElementById('image').addEventListener('change', function(event) {
                const file = event.target.files[0];
                const preview = document.getElementById('imagePreview');

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        document.getElementById('imageLabel').style.display = 'none';
                    }
                    reader.readAsDataURL(file);
                } else {
                    preview.src = '#';
                    preview.style.display = 'none';
                }
            });
        </script>
        </script>

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