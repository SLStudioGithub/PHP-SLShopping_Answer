<?php

namespace App\Admin\Exceptions;

use Exception;
use Illuminate\Http\RedirectResponse;

/**
 * テーブルデータが削除できない時のException
 */
class NotDeletedException extends Exception
{
    /**
     * コンストラクタ
     *
     * @param integer $id
     * @param string $tableName
     */
    public function __construct($id, $tableName)
    {
        parent::__construct("Could not delete data (TableName: {$tableName}, ID: {$id})", 409);
    }

    /**
     * レスポンス指定
     *
     * @return RedirectResponse
     */
    public function render()
    {
        return redirect()->back()->with('notDeletedFlg', true);
    }
}