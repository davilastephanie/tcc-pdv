<?php

namespace App\Traits;

use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\SubcategoryModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ProductTrait
{
    public static function validation(array $params = [])
    {
        $productId         = isset($params['id']) ? $params['id'] : null;
        $barcodeUnique     = Rule::unique(self::getTableName(), 'barcode')->ignore($productId);
        $nameUnique        = Rule::unique(self::getTableName(), 'name')->ignore($productId);
        $categoryExists    = Rule::exists(CategoryModel::getTableName(), 'id');
        $subcategoryExists = Rule::exists(SubcategoryModel::getTableName(), 'id');
        $supplierExists    = Rule::exists(SupplierModel::getTableName(), 'id');

        $validation = [
            'rules'      => [
                'category_id'    => ['required', 'integer', $categoryExists],
                'subcategory_id' => ['required', 'integer', $subcategoryExists],
                'supplier_id'    => ['required', 'integer', $supplierExists],
                'barcode'        => ['required', 'string', 'max:190', $barcodeUnique],
                'name'           => ['required', 'string', 'max:190', $nameUnique],
                'description'    => ['required', 'string', 'max:15000'],
                'image'          => ['required', 'string', 'max:190'],
                'price'          => ['required', 'numeric', 'between:1,999999.99'],
                'stock'          => ['nullable', 'integer', 'between:1,999999'],
                'active'         => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'category_id'    => 'categoria',
                'subcategory_id' => 'subcategoria',
                'supplier_id'    => 'fornecedor',
                'barcode'        => 'código de barras',
                'name'           => 'nome',
                'description'    => 'descrição',
                'image'          => 'imagem',
                'price'          => 'preço',
                'stock'          => 'estoque',
                'active'         => 'ativo',
            ],
        ];

        if (empty($productId)) {
            $validation['rules']['stock'] = array_map(function ($rule) {
                if ($rule == 'nullable') {
                    $rule = 'required';
                }

                return $rule;
            }, $validation['rules']['stock']);
        }

        return $validation;
    }

    public static function requestIntercept(Request $request)
    {
        $price = $request->get('price');
        $price = str_replace(['.', ','], ['', '.'], $price);

        $request->request->set('price', $price);
    }

    public static function listAll(array $params = [])
    {
        $subQueryCategoryName = (new CategoryModel)
            ->select('name')
            ->whereColumn('id', 'products.category_id')
            ->limit(1);

        $subQuerySubcategoryName = (new SubcategoryModel)
            ->select('name')
            ->whereColumn('id', 'products.subcategory_id')
            ->limit(1);

        $subQuerySupplierName = (new SupplierModel)
            ->select('name')
            ->whereColumn('id', 'products.supplier_id')
            ->limit(1);

        return (new self)
            ->addSelect([
                'category_name'    => $subQueryCategoryName,
                'subcategory_name' => $subQuerySubcategoryName,
                'supplier_name'    => $subQuerySupplierName,
            ])
            ->where(function ($query) use ($params) {
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where(function ($q) use ($params) {
                        foreach ((new self)->getFillable() as $attr) {
                            $q->orWhere($attr, 'LIKE', "%{$params['search']}%");
                        }
                    });
                }
            })
            ->applyOrderBy($params)
            ->getResult($params);
    }

    public static function listHtmlSelect()
    {
        return self::orderBy('name')->pluck('name', 'id')->toArray();
    }

    public static function updateStock($id)
    {
        $stockInput  = StockModel::where('product_id', $id)->where('action', 'e')->sum('quantity');
        $stockOutput = StockModel::where('product_id', $id)->where('action', 's')->sum('quantity');
        $stockResult = $stockInput - $stockOutput;

        ProductModel::where('id', $id)->update(['stock' => $stockResult]);
    }
}
