<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品情報編集 - {{ $product->name }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 1.5em;
            color: #333;
        }
        .breadcrumb {
            font-size: 0.9em;
            color: #666;
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: #007bff;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .form-section {
            display: flex;
            gap: 40px;
            margin-top: 20px;
        }
        .left-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .right-panel {
            flex: 2;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            object-fit: contain;
            border: 1px solid #ddd;
            padding: 5px;
            background-color: #f9f9f9;
            margin-bottom: 15px;
        }
        .file-input-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
        .file-input-button {
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
        }
        .file-input-name {
            font-size: 0.9em;
            color: #555;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea {
            width: calc(100% - 20px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1em;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .radio-group label {
            margin-right: 20px;
            font-weight: normal;
        }
        .checkbox-group label {
            margin-right: 20px;
            font-weight: normal;
            display: inline-flex;
            align-items: center;
            cursor: pointer;
        }
        .checkbox-group input[type="checkbox"] {
            margin-right: 5px;
        }
        .error-message {
            color: red;
            font-size: 0.85em;
            margin-top: 5px;
            font-weight: bold;
        }
        .button-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .action-buttons button,
        .action-buttons a {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            transition: background-color 0.3s ease;
        }
        .back-button {
            background-color: #6c757d;
            color: #fff;
        }
        .back-button:hover {
            background-color: #5a6268;
        }
        .save-button {
            background-color: #ffc107;
            color: #333;
        }
        .save-button:hover {
            background-color: #e0a800;
        }
        .delete-button-wrapper {
            margin-left: auto;
        }
        .delete-button {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .delete-button:hover {
            background-color: #c82333;
        }
        .delete-button svg {
            width: 20px;
            height: 20px;
            fill: currentColor;
        }
        .mogitate-logo {
            font-size: 1.8em;
            font-weight: bold;
            color: #f39c12;
            text-decoration: none;
            margin-right: 20px;
        }
        input[type="file"] {
            display: none;
        }
        .custom-file-upload {
            display: inline-block;
            background-color: #e0e0e0;
            border: 1px solid #ccc;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9em;
            text-align: center;
        }
        .file-name-display {
            display: inline-block;
            margin-left: 10px;
            font-size: 0.9em;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('products.index') }}" class="mogitate-logo">mogitate</a>
    </div>

    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('products.index') }}">商品一覧</a> > {{ $product->name }}
        </div>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

            {{-- フォームセクションをformタグの中に移動 --}}
            <div class="form-section">
                <div class="left-panel">
                    @if ($product->image_path && Storage::disk('public')->exists($product->image_path))
                        <img src="{{ Storage::url($product->image_path) }}" alt="{{ $product->name }}" class="image-preview">
                    @else
                        <img src="{{ asset('images/placeholder.png') }}" alt="画像なし" class="image-preview">
                    @endif

                    <div class="form-group">
                        <label for="image" class="custom-file-upload">ファイルを選択</label>
                        <input type="file" id="image" name="image" onchange="displayFileName(this)">
                        <span id="file-name-display" class="file-name-display">
                            @if ($product->image_path)
                                {{ basename($product->image_path) }}
                            @else
                                商品画像を登録してください
                            @endif
                        </span>
                        @error('image')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="right-panel">
                    <div class="form-group">
                        <label for="name">商品名</label>
                        <input type="text" id="name" name="name" placeholder="商品名を入力" value="{{ old('name', $product->name) }}">
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">値段</label>
                        <input type="number" id="price" name="price" placeholder="値段を入力" value="{{ old('price', $product->price) }}">
                        @error('price')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>季節</label><br>
                        @foreach ($seasons as $season)
                            <div class="checkbox-group">
                                <label>
                                    <input type="checkbox" name="seasons[]" value="{{ $season }}"
                                        {{ in_array($season, old('seasons', $productSeasons)) ? 'checked' : '' }}>
                                    {{ $season }}
                                </label>
                            </div>
                        @endforeach
                        @error('seasons')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">商品説明</label>
                        <textarea id="description" name="description" placeholder="商品の説明を入力">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="button-area">
                <div class="action-buttons">
                    <a href="{{ route('products.index') }}" class="back-button">戻る</a>
                    <button type="submit" class="save-button">変更を保存</button>
                </div>
                <div class="delete-button-wrapper">
                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                        onsubmit="return confirm('本当にこの商品を削除しますか？');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13V9.5a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5V4h.5a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V5a1 1 0 0 1 1-1h.5V2a1 1 0 0 1 1-1H10a1 1 0 0 1 1 1v1h2.5zm-1 0H3.5V2a.5.5 0 0 0-.5-.5H2a.5.5 0 0 0-.5.5V3h-.5a.5.5 0 0 0-.5.5V14a.5.5 0 0 0 .5.5h12a.5.5 0 0 0 .5-.5V3.5a.5.5 0 0 0-.5-.5z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </form>
    </div>
</body>
</html>