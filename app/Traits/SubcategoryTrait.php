<?php

namespace App\Traits;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait SubcategoryTrait
{
    public static function validation(array $params = [])
    {
        $categoryId     = isset($params['id']) ? $params['id'] : null;
        $nameUnique     = Rule::unique(self::getTableName(), 'name')->ignore($categoryId);
        $categoryExists = Rule::exists(CategoryModel::getTableName(), 'id');

        return [
            'rules'      => [
                'category_id' => ['required', 'integer', $categoryExists],
                'name'        => ['required', 'string', 'max:190', $nameUnique],
                'active'      => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'name'        => 'nome',
                'category_id' => 'categoria',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        //
    }

    public static function listAll(array $params = [])
    {
        $subQueryCategoryName = (new CategoryModel)
            ->select('name')
            ->whereColumn('id', 'subcategories.category_id')
            ->limit(1);

        return (new self)
            ->addSelect(['category_name' => $subQueryCategoryName])
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

    public static function listHtmlSelect(array $params = [])
    {
        return (new self)
            ->where(function ($query) use ($params) {
                if (isset($params['category_id'])) {
                    $query->where('category_id', $params['category_id']);
                }

                if (isset($params['active'])) {
                    $query->where('active', $params['active']);
                }
            })
            ->orderBy('name')
            ->pluck('name', 'id')
            ->toArray();
    }
}
