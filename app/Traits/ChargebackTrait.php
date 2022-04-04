<?php

namespace App\Traits;

use App\Models\ClientModel;
use App\Models\ProductModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ChargebackTrait
{
    public static function validation(array $params = [])
    {
        $clientExists  = Rule::exists(ClientModel::getTableName(), 'id');
        $productExists = Rule::exists(ProductModel::getTableName(), 'id');
        $userExists    = Rule::exists(UserModel::getTableName(), 'id');

        return [
            'rules'      => [
                'client_id'  => ['required', 'integer', $clientExists],
                'product_id' => ['required', 'integer', $productExists],
                'user_id'    => ['required', 'integer', $userExists],
                'quantity'   => ['required', 'numeric', 'min:1'],
                'note'       => ['required', 'string', 'max:1000'],
                'active'     => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'client_id'  => 'cliente',
                'product_id' => 'produto',
                'user_id'    => 'usuário',
                'quantity'   => 'quantidade',
                'note'       => 'observação',
                'active'     => 'ativo',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        $request->request->set('user_id', auth()->id());
    }

    public static function listAll(array $params = [])
    {
        $subQueryClientName = (new ClientModel)
            ->select('name')
            ->whereColumn('id', 'chargebacks.client_id')
            ->limit(1);

        $subQueryProductName = (new ProductModel)
            ->select('name')
            ->whereColumn('id', 'chargebacks.product_id')
            ->limit(1);

        $subQueryUserName = (new UserModel)
            ->select('name')
            ->whereColumn('id', 'chargebacks.user_id')
            ->limit(1);

        return (new self)
            ->addSelect([
                'client_name'  => $subQueryClientName,
                'product_name' => $subQueryProductName,
                'user_name'    => $subQueryUserName,
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
}
