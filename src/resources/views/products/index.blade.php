<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧 - mogitate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .mogitate-logo {
            font-size: 2em;
            font-weight: bold;
            color: #f39c12;
            text-decoration: none;
        }
        .btn-create-product {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .btn-create-product:hover {
            background-color: #218838;
        }
        .search-sort-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 20px;
        }
        .search-form {
            display: flex;
            gap: 10px;
            flex-grow: 1;
        }
        .search-form input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-form button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .sort-dropdown {
            position: relative;
            display: inline-block;
        }
        .sort-button {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .sort-button::after {
            content: '▼';
            font-size: 0.8em;
        }
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            border-radius: 4px;
            right: 0; /* 右揃え */
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            transition: background-color 0.2s ease;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .sort-dropdown:hover .dropdown-content {
            display: block;
        }
        .filter-tags {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .filter-tag {
            background-color: #e2e6ea;
            border: 1px solid #dae0e5;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.9em;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        .filter-tag .clear-button {
            background: none;
            border: none;
            color: #666;
            font-weight: bold;
            cursor: pointer;
            font-size: 1.1em;
            padding: 0 3px;
        }
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        .product-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
            text-decoration: none;
            color: #333;
            transition: transform 0.2s;
        }
        .product-card:hover {
            transform: translateY(-5px);
        }
        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }
        .product-card-body {
            padding: 15px;
        }
        .product-card-body h3 {
            margin-top: 0;
            margin-bottom: 10px;
            font-size: 1.2em;
        }
        .product-card-body p {
            margin: 0;
            color: #666;
            font-size: 0.9em;
        }
        .price {
            font-weight: bold;
            color: #e67e22;
            margin-top: 10px;
        }
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        .pagination nav {
            display: inline-block;
        }
        .pagination ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
        }
        .pagination li {
            margin: 0 5px;
        }
        .pagination li a, .pagination li span {
            display: block;
            padding: 8px 12px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            border-radius: 4px;
        }
        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .pagination li a:hover {
            background-color: #eee;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('products.index') }}" class="mogitate-logo">mogitate</a>
        <a href="{{ route('products.create') }}" class="btn-create-product">+商品を追加</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="search-sort-area">
        <form action="{{ route('products.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="商品名を検索" value="{{ $currentSearch }}">
            {{-- 並び替え条件が現在適用されている場合、検索時にも引き継ぐための隠しフィールド --}}
            @if ($currentSort)
                <input type="hidden" name="sort" value="{{ $currentSort }}">
            @endif
            <button type="submit">検索</button>
        </form>

        <div class="sort-dropdown">
            <button type="button" class="sort-button">並び替え</button>
            <div class="dropdown-content">
                {{-- 高い順に表示 --}}
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}">高い順に表示</a>
                {{-- 低い順に表示 --}}
                <a href="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}">低い順に表示</a>
            </div>
        </div>
    </div>

    {{-- 検索・並べ替えのタグ表示 --}}
    <div class="filter-tags">
        @if ($currentSearch)
            <div class="filter-tag">
                検索: {{ $currentSearch }}
                <a href="{{ route('products.index', request()->except(['search'])) }}" class="clear-button">×</a>
            </div>
        @endif

        @if ($currentSort)
            <div class="filter-tag">
                並び替え:
                @if ($currentSort == 'price_desc')
                    高い順
                @elseif ($currentSort == 'price_asc')
                    低い順
                @endif
                <a href="{{ route('products.index', request()->except(['sort'])) }}" class="clear-button">×</a>
            </div>
        @endif
    </div>

    <div class="product-grid">
        @forelse ($products as $product)
            {{-- 商品カードをクリックすると商品詳細/編集画面へ遷移 --}}
            {{-- ここではproducts.edit（編集画面）へ遷移させるようにしています --}}
            <a href="{{ route('products.edit', $product->id) }}" class="product-card">
                @if ($product->image_path && Storage::disk('public')->exists($product->image_path))
                    <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}">
                @else
                    {{-- 画像がない場合のプレースホルダー。public/images/placeholder.png が必要 --}}
                    <img src="{{ asset('images/placeholder.png') }}" alt="画像なし">
                @endif
                <div class="product-card-body">
                    <h3>{{ $product->name }}</h3>
                    <p class="price">{{ number_format($product->price) }}円</p>
                    <p>季節: {{ implode(', ', $product->seasons) }}</p>
                </div>
            </a>
        @empty
            <p>商品が見つかりませんでした。</p>
        @endforelse
    </div>

    {{-- ページネーションリンク --}}
    <div class="pagination">
        {{-- 検索と並べ替えのクエリパラメータをページネーションリンクに引き継ぐ --}}
        {{ $products->appends(request()->query())->links() }}
    </div>
</body>
</html>