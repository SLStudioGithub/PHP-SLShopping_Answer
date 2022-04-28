<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * 管理者編集バリデーションクラス
 */
class EditAdminUserRequest extends FormRequest
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
        /**
         * 管理者ID: 必須|admin_users.usernameカラムに重複データ有無(自分以外)|文字列|最大190文字
         * 管理者名: 必須|文字列|最大191文字
         * 役割: 必須|配列|要素は整数
         * 権限: 必須|配列|要素は整数
         */
        return [
            'userId' => "required|unique:admin_users,username,{$this->id},id|string|max:190",
            'userName' => 'required|string|max:191',
            'adminUserRoles' => 'required|array',
            'adminUserRoles.*' => 'integer',
            'adminUserPermissions' => 'required|array',
            'adminUserPermissions.*' => 'integer',
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
            'userId' => '管理者ID',
            'userName' => '名前',
            'adminUserRoles' => '役割',
            'adminUserPermissions' => '権限',
        ];
    }
}
