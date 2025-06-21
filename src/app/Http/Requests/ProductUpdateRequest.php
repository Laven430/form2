<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'price' => 'required|numeric|min:0|max:10000',
            'seasons' => 'required|array',
            'seasons.*' => 'in:春,夏,秋,冬',
            'description' => 'required|max:120',
            'image' => 'nullable|file|mimes:png,jpeg',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '値段を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0~10000円以内で入力してください',
            'price.max' => '0~10000円以内で入力してください',
            'seasons.required' => '季節を選択してください',
            'seasons.array' => '季節の選択が不正です。',
            'seasons.*.in' => '有効な季節を選択してください。',
            'description.required' => '商品説明を入力してください',
            'description.max' => '120文字以内で入力してください',
            'image.file' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}