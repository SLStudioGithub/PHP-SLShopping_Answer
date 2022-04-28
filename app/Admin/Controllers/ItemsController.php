<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateItemRequest;
use App\Http\Requests\EditItemRequest;
use App\Http\Requests\StockRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * 商品画面コントローラー
 *
 * 商品画面の処理について一括で管理する。
 */
class ItemsController extends Controller
{
    /**
     * 商品モデル
     *
     * @var Item $item
     */
    private $item;

    /**
     * カテゴリーモデル
     *
     * @var Category $category
     */
    private $category;

    /**
     * コンストラクタ
     */
    public function __construct()
    {
        $this->item = new Item();
        $this->category = new Category();
    }

    /**
     * 商品一覧＆検索画面
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // 商品の検索＆取得
        $items = $this->item->fetchForAdmin(
            $request->id,
            $request->name,
            $request->lowPrice,
            $request->highPrice,
            $request->brandId,
            $request->categoryId,
            null,
            null
        );
        // 全ブランドの取得
        $brands = Brand::all();
        // 親カテゴリーを取得
        $categories = $this->category->getCategoryFindAll()
            ->get('parents');
        return view('admin.items.index', compact('items', 'brands', 'categories'));
    }

    /**
     * 商品新規登録画面表示
     *
     * @return View
     */
    public function showCreate()
    {
        // 全ブランドの取得
        $brands = Brand::all();
        // 全カテゴリーの取得
        $categories = $this->category->getCategoryFindAll();
        return view('admin.items.create', compact('brands', 'categories'));
    }

    /**
     * 商品新規登録
     *
     * @param CreateItemRequest $request
     * @return RedirectResponse
     */
    public function create(CreateItemRequest $request)
    {
        // 商品の作成
        $item = $this->item->create(
            $request->name,
            $request->mainImage,
            $request->shortDescription,
            $request->price,
            $request->discountPercent,
            $request->brandId,
            $request->categories,
            floatval($request->length),
            floatval($request->width),
            floatval($request->height),
            floatval($request->weight),
            $request->fullDescription
        );
        // 作成した商品の詳細画面へ遷移
        return redirect()
            ->route('admin.items.detail', ['id' => $item->id])
            ->with('completeFlg', true);
    }

    /**
     * 商品詳細画面
     *
     * @param integer $id
     * @return View
     */
    public function detail($id)
    {
        // 商品詳細取得
        $item = $this->item->findById($id);
        // メイン画像取得
        $mainImage = $item->getMainImage();
        return view('admin.items.detail', compact('item', 'mainImage'));
    }

    /**
     * 商品編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showEdit($id)
    {
        // 商品詳細取得
        $item = $this->item->findById($id);
        // 全ブランドの取得
        $brands = Brand::all();
        // 全カテゴリーの取得
        $categories = $this->category->getCategoryFindAll();
        // メイン画像の取得
        $mainImage = $item->getMainImage();
        return view('admin.items.edit', compact('item', 'brands', 'categories', 'mainImage'));
    }

    /**
     * 商品編集
     *
     * @param EditItemRequest $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function edit(EditItemRequest $request, $id)
    {
        // 商品の編集
        $item = $this->item->edit(
            $id,
            $request->name,
            $request->mainImage,
            $request->shortDescription,
            $request->price,
            $request->discountPercent,
            $request->brandId,
            $request->categories,
            floatval($request->length),
            floatval($request->width),
            floatval($request->height),
            floatval($request->weight),
            $request->fullDescription
        );
        return redirect()
            ->route('admin.items.detail', ['id' => $item->id])
            ->with('completeFlg', true);
    }

    /**
     * 商品削除
     *
     * @param integer $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $item = $this->item->deleteById($id);
        // 一覧画面へ遷移
        return redirect()->route('admin.items.index')->with('message', "{$item->name}を削除しました");
    }

    /**
     * 在庫数量一覧画面
     *
     * @param Request $request
     * @return View
     */
    public function stockIndex(Request $request)
    {
        // 商品を検索＆一覧取得
        $items = $this->item->fetchForAdmin(
            $request->id,
            $request->name,
            null,
            null,
            $request->brandId,
            $request->categoryId,
            $request->lowStock,
            $request->highStock
        );
        // 全ブランドの取得
        $brands = Brand::all();
        // 親カテゴリーを取得
        $categories = $this->category->getCategoryFindAll()
            ->get('parents');
        return view('admin.items.stock', compact('items', 'brands', 'categories'));
    }

    /**
     * 商品在庫数量編集画面
     *
     * @param integer $id
     * @return View
     */
    public function showStockEdit($id)
    {
        // 商品詳細情報取得
        $item = $this->item->findById($id);
        return view('admin.items.stock-edit', compact('item'));
    }

    /**
     * 商品在庫数編集
     *
     * @param integer $id
     * @param StockRequest $request
     * @return RedirectResponse
     */
    public function stockEdit($id, StockRequest $request)
    {
        // 在庫数編集
        $item = $this->item->editStock($id, $request->stock);
        return redirect()
            ->route('admin.items.detail', ['id' => $item->id])
            ->with('completeFlg', true);
    }
}