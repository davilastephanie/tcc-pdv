<?php

namespace App\Traits;

use App\Models\ProductModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait StockTrait
{
    public static function validation(array $params = [])
    {
        $productExists = Rule::exists(ProductModel::getTableName(), 'id');
        $userExists    = Rule::exists(UserModel::getTableName(), 'id');

        return [
            'rules'      => [
                'product_id'  => ['required', 'integer', $productExists],
                'user_id'     => ['required', 'integer', $userExists],
                'action'      => ['required', 'string', 'max:1', Rule::in(['e', 's'])],
                'quantity'    => ['required', 'numeric'],
                'description' => ['required', 'string', 'max:190'],
                'active'      => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'product_id'  => 'produto',
                'user_id'     => 'usuário',
                'action'      => 'ação',
                'quantity'    => 'quantidade',
                'description' => 'descrição',
                'active'      => 'ativo',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        $request->request->set('user_id', auth()->id());
    }

    public static function listAll(array $params = [])
    {
        $subQueryProductName = (new ProductModel)
            ->select('name')
            ->whereColumn('id', 'stocks.product_id')
            ->limit(1);

        $subQueryUserName = (new UserModel)
            ->select('name')
            ->whereColumn('id', 'orders.user_id')
            ->limit(1);

        return (new self)
            ->addSelect(['product_name' => $subQueryProductName, 'user_name' => $subQueryUserName])
            ->where(function ($query) use ($params) {
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where(function ($q) use ($params) {
                        foreach ((new self)->getFillable() as $attr) {
                            $q->orWhere($attr, 'LIKE', "%{$params['search']}%");
                        }
                    });
                }
            })
            ->applyStockBy($params)
            ->getResult($params);
    }

    public static function actions()
    {
        return [
            'e' => 'Entrada',
            's' => 'Saída',
        ];
    }
}
