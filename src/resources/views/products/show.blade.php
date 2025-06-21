<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} 詳細</title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        .container { max-width: 800px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        img { max-width: 100%; height: auto; display: block; margin-bottom: 15px; border: 1px solid #ddd; padding: 5px; }
        h1 { color: #333; }
        p { margin-bottom: 10px; }
        .button-group { margin-top: 20px; }
        .button-group a { display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .button-group a:hover { background-color: #0056b3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>{{ $product->name }}</h1>

        @if ($product->image_path)
            <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}">
        @else
            <img src="{{ asset('images/placeholder.png') }}" alt="画像なし">
        @endif

        <p><strong>価格:</strong> {{ number_format($product->price) }}円</p>
        <p><strong>商品説明:</strong> {{ $product->description }}</p>
        <p><strong>季節:</strong> {{ implode(', ', $product->seasons) }}</p>

        <div class="button-group">
            <a href="{{ route('products.index') }}">商品一覧へ戻る</a>
            {{-- 編集画面へのリンク --}}
            <a href="{{ route('products.edit', $product->id) }}">編集する</a>
        </div>
    </div>
</body>
</html>