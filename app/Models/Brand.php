<?php

namespace App\Models;

use App\Models\Item;
use App\Consts\PageConsts;
use App\Admin\Exceptions\NotFoundException;
use App\Admin\Exceptions\NotDeletedException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * ブランド情報モデル
 */
class Brand extends Model
{
    use SoftDeletes;

    /**
     * モデルと関連しているテーブル
     *
     * @var string
     */
    protected $table = 'brands';

    /**
     * テーブルの主キー
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 複数代入する属性
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * itemsとの１対多リレーション定義
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * brandsテーブル全件取得
     *
     * @return Collection
     */
    public function findAll()
    {
        return Brand::all();
    }

    /**
     * brandsテーブルデータ検索＆取得
     *
     * @param integer|null $id
     * @param string|null $name
     * @return LengthAwarePaginator
     */
    public function fetch($id, $name)
    {
        $query = Brand::query();
        if (!is_null($id)) {
            $query->where('id', $id);
        }
        if (!is_null($name)) {
            $query->where('name', 'like', "%$name%");
        }
        return $query->paginate(PageConsts::ADMIN_NUMBER_OF_PER_PAGE);
    }

    /**
     * brandsテーブルからIDでレコードを１件取得
     *
     * @param int $id
     * @return Brand
     */
    public function findById($id)
    {
        $brand = self::find($id);
        if (is_null($brand)) {
            throw new NotFoundException($id, $this->getTable());
        }
        return $brand;
    }

    /**
     * brandsテーブルにレコードを新規登録
     *
     * @param string $name
     * @return Brand
     */
    public function create($name)
    {
        $brand = new self([
            'name' => $name
        ]);
        $brand->save();
        return $brand;
    }

    /**
     * brandsテーブルの該当レコードを更新
     *
     * @param int $id
     * @param string $name
     * @return Brand
     */
    public function edit($id, $name)
    {
        $brand = $this->findById($id);
        $brand->name = $name;
        $brand->save();
        return $brand;
    }

    /**
     * brandsテーブルの該当レコードを削除
     *
     * @param int $id
     * @return Brand
     */
    public function deleteById($id)
    {
        $brand = $this->findById($id);
        if ($brand->isDeletable()) {
            throw new NotDeletedException($id, $this->getTable());
        }
        $brand->delete();
        return $brand;
    }

    /**
     * brandsテーブルの該当レコードが削除可能か判定
     *
     * @return boolean
     */
    private function isDeletable()
    {
        return Item::query()
            ->where('brand_id', $this->id)
            ->exists();
    }
}
