<?php

namespace App\Traits;

use App\Models\ClientModel;
use App\Models\OrderModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait OrderTrait
{
    public static function validation(array $params = [])
    {
        $clientExists  = Rule::exists(ClientModel::getTableName(), 'id');
        $userExists    = Rule::exists(UserModel::getTableName(), 'id');
        $paymentTypeIn = Rule::in(array_keys(OrderModel::paymentTypes()));

        $validation = [
            'rules'      => [
                'client_id'    => ['required', 'integer', $clientExists],
                'user_id'      => ['required', 'integer', $userExists],
                'total'        => ['required', 'numeric', 'between:1,999999.99'],
                'payment_type' => ['nullable', 'string', 'max:20', $paymentTypeIn],
                'status'       => ['required', 'string', 'max:20'],
                'active'       => ['nullable', 'boolean'],

                'products' => ['required', 'array', 'min:1'],
            ],
            'messages'   => [],
            'attributes' => [
                'client_id'    => 'cliente',
                'user_id'      => 'usuário',
                'total'        => 'total',
                'payment_type' => 'forma de pagamento',
                'status'       => 'status',
                'active'       => 'ativo',

                'products' => 'produtos',
            ],
        ];

        if (isset($params['status']) && $params['status'] == 'pay') {
            $validation['rules']['payment_type'] = array_map(function ($rule) {
                if ($rule == 'nullable') {
                    $rule = 'required';
                }

                return $rule;
            }, $validation['rules']['payment_type']);
        }

        return $validation;
    }

    public static function requestIntercept(Request $request)
    {
        $request->request->set('user_id', auth()->id());
    }

    public static function listAll(array $params = [])
    {
        $subQueryClientName = (new ClientModel)
            ->select('name')
            ->whereColumn('id', 'orders.client_id')
            ->limit(1);

        $subQueryUserName = (new UserModel)
            ->select('name')
            ->whereColumn('id', 'orders.user_id')
            ->limit(1);

        return (new self)
            ->addSelect(['client_name' => $subQueryClientName, 'user_name' => $subQueryUserName])
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

    public static function paymentTypes()
    {
        return [
            'dinheiro'       => 'Dinheiro',
            'cheque'         => 'Cheque',
            'cartao-credito' => 'Cartão de crédito',
            'cartao-debito'  => 'Cartão de débito',
        ];
    }

    public static function status()
    {
        return [
            'cancel' => 'Cancelado',
            'budget' => 'Orçamento',
            'pay'    => 'Pago',
        ];
    }

    public static function statusByColor()
    {
        return [
            'cancel' => 'danger',
            'budget' => 'warning',
            'pay'    => 'success',
        ];
    }
}
