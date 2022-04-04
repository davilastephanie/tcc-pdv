<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait SupplierTrait
{
    public static function validation(array $params = [])
    {
        $supplierId = isset($params['id']) ? $params['id'] : null;
        $cnpjUnique = Rule::unique(self::getTableName(), 'cnpj')->ignore($supplierId);

        return [
            'rules'      => [
                'name'         => ['required', 'string', 'max:190'],
                'company'      => ['required', 'string', 'max:190'],
                'cnpj'         => ['required', 'string', 'max:19', 'formato_cnpj', 'cnpj', $cnpjUnique],
                'email'        => ['required', 'string', 'max:190', 'email'],
                'phone'        => ['required', 'string', 'max:15', 'celular_com_ddd'],
                'cep'          => ['required', 'string', 'max:9', 'formato_cep'],
                'address'      => ['required', 'string', 'max:190'],
                'number'       => ['required', 'string', 'max:15'],
                'neighborhood' => ['required', 'string', 'max:190'],
                'city'         => ['required', 'string', 'max:190'],
                'uf'           => ['required', 'string', 'max:2'],
                'active'       => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'name'         => 'nome fantasia',
                'company'      => 'razão social',
                'cnpj'         => 'cnpj',
                'email'        => 'e-mail',
                'phone'        => 'telefone',
                'cep'          => 'cep',
                'address'      => 'endereço',
                'number'       => 'número',
                'neighborhood' => 'bairro',
                'city'         => 'cidade',
                'uf'           => 'estado',
                'active'       => 'ativo',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        //
    }

    public static function listAll(array $params = [])
    {
        return (new self)
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
                if (isset($params['active'])) {
                    $query->where('active', $params['active']);
                }
            })
            ->orderBy('name')->pluck('name', 'id')
            ->toArray();
    }
}
