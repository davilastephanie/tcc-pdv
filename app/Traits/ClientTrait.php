<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait ClientTrait
{
    public static function validation(array $params = [])
    {
        $clientId  = isset($params['id']) ? $params['id'] : null;
        $cpfUnique = Rule::unique(self::getTableName(), 'cpf')->ignore($clientId);

        return [
            'rules'      => [
                'name'         => ['required', 'string', 'max:190'],
                'cpf'          => ['required', 'string', 'max:14', 'formato_cpf', 'cpf', $cpfUnique],
                'rg'           => ['required', 'string', 'max:10'],
                'birthday'     => ['required', 'date_format:d/m/Y', 'before:today', 'after:1900-01-01'],
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
                'name'         => 'nome',
                'cpf'          => 'cpf',
                'rg'           => 'rg',
                'birthday'     => 'data de nascimento',
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

    public static function listHtmlSelect()
    {
        return self::orderBy('name')->pluck('name', 'id')->toArray();
    }
}
