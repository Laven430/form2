<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規商品登録 - mogitate</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 20px; }
        .header { display: flex; align-items: center; margin-bottom: 20px; }
        .mogitate-logo { font-size: 1.8em; font-weight: bold; color: #f39c12; text-decoration: none; margin-right: 20px; }
        .container { max-width: 600px; margin: 20px auto; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #333; margin-bottom: 30px; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: bold; color: #333; }
        .form-group input[type="text"],
        .form-group input[type="number"],
        .form-group textarea { width: calc(100% - 20px); padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 1em; }
        .form-group textarea { resize: vertical; min-height: 100px; }
        .checkbox-group label { margin-right: 20px; font-weight: normal; display: inline-flex; align-items: center; cursor: pointer; }
        .checkbox-group input[type="checkbox"] { margin-right: 5px; }
        .error-message { color: red; font-size: 0.85em; margin-top: 5px; font-weight: bold; }
        .button-area { display: flex; justify-content: space-between; margin-top: 30px; }
        .button-area button, .button-area a { padding: 12px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 1em; font-weight: bold; text-decoration: none; display: inline-block; text-align: center; transition: background-color 0.3s ease; }
        .back-button { background-color: #6c757d; color: #fff; }
        .back-button:hover { background-color: #5a6268; }
        .save-button { background-color: #28a745; color: #fff; }
        .save-button:hover { background-color: #218838; }
        input[type="file"] { display: none; }
        .custom-file-upload { display: inline-block; background-color: #e0e0e0; border: 1px solid #ccc; padding: 8px 15px; border-radius: 4px; cursor: pointer; font-size: 0.9em; }
        .file-name-display { display: inline-block; margin-left: 10px; font-size: 0.9em; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <a href="{{ route('products.index') }}" class="mogitate-logo">mogitate</a>
    </div>
    <div class="container">
        <h1>新規商品登録</h1>

        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="name">商品名:</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">値段:</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}">
                @error('price')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label>季節:</label><br>
                @foreach ($seasons as $season)
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="seasons[]" value="{{ $season }}"
                                {{ in_array($season, old('seasons', [])) ? 'checked' : '' }}>
                            {{ $season }}
                        </label>
                    </div>
                @endforeach
                @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">商品説明:</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
                @error('description')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="image" class="custom-file-upload">ファイルを選択</label>
                <input type="file" id="image" name="image" onchange="displayFileName(this)">
                <span id="file-name-display" class="file-name-display">商品画像を登録してください</span>
                @error('image')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="button-area">
                <a href="{{ route('products.index') }}" class="back-button">戻る</a>
                <button type="submit" class="save-button">登録</button>
            </div>
        </form>
    </div>

    <script>
        function displayFileName(input) {
            const fileNameDisplay = document.getElementById('file-name-display');
            if (input.files && input.files[0]) {
                fileNameDisplay.textContent = input.files[0].name;
            } else {
                fileNameDisplay.textContent = '商品画像を登録してください';
            }
        }
    </script>
</body>
</html>