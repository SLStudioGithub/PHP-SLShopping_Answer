<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 商品編集バリデーションクラス
 */
class EditItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:191',
            'mainImage' => 'file|image',
            'shortDescription' => 'required|string|max:500',
            'price' => 'required|integer|min:1',
            'discountPercent' => 'required|integer|min:1',
            'brandId' => 'required|integer',
            'categories' => 'required|array',
            'categories.*' => 'integer',
            'length' => 'required|numeric|min:0.1',
            'width' => 'required|numeric|min:0.1',
            'height' => 'required|numeric|min:0.1',
            'weight' => 'required|numeric|min:0.1',
            'fullDescription' => 'required|string|max:4000',
        ];
    }

    /**
     * バリデーション項目名定義
     * 
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => '商品名',
            'mainImage' => 'メイン画像',
            'shortDescription' => '省略説明',
            'price' => '説明',
            'discountPercent' => '割引率',
            'brandId' => 'ブランド',
            'categories' => 'カテゴリー',
            'length' => '長辺',
            'width' => '短辺',
            'height' => '高さ',
            'weight' => '重量',
            'fullDescription' => '完全説明',
        ];
    }
}
