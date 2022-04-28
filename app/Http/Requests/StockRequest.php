<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 在庫編集バリデーションクラス
 */
class StockRequest extends FormRequest
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
            'stock' => 'required|digits_between:1,9|integer|min:0'
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
            'stock' => '在庫数',
        ];
    }
}
