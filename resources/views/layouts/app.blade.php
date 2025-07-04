<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    @yield('styles')
</head>

<body>
    <header>
        <div class="header-bar">
            <div class="logo">
                <a href="{{ route('products.index') }}">
                    <img src="{{ asset('storage/images/coachtech-logo.svg') }}" alt="画像" style="height: 30px;">
                    {{-- 上記はデザイン済みロゴの画像URLに置き換えてください --}}
                </a>
            </div>
            <form action="{{ route('search') }}" method="GET">
                <input type="text" name="keyword" class="search-box" placeholder="なにをお探しですか？" value="{{ request('keyword') }}">
                <button type="submit">検索</button>
            </form>
            <div class="nav-links d-flex align-items-center">

                @auth
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">ログアウト</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                @endauth

                @guest
                <a href="{{ route('login') }}">ログイン</a>
                @endguest

                <a href="{{ route('mypage') }}">マイページ</a>
                <a href="{{ route('products.create') }}" class="btn btn-light">出品</a>
            </div>
        </div>
    </header>

    <main class="container py-4">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Coach Market</p>
    </footer>

    @yield('scripts')
</body>

</html>