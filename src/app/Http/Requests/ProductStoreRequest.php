<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'price' => 'required|integer|min:0|max:10000',
            'image' => 'required|image|mimes:png,jpeg',
            'description' => 'required|string|max:120',
            'season_ids' => 'required|array|min:1',
            'season_ids.*' => 'exists:seasons,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.integer' => '値段は数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'season_ids.required' => '季節を選択してください',
            'season_ids.array' => '季節の形式が不正です',
            'season_ids.min' => '季節を選択してください',
            'season_ids.*.exists' => '選択された季節が存在しません',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.image' => '商品画像は画像ファイルである必要があります',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
