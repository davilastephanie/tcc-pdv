<?php

namespace App\Traits;

use App\Models\RoleModel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

trait UserTrait
{
    public static function validation(array $params = [])
    {
        $userId      = isset($params['id']) ? $params['id'] : null;
        $emailUnique = Rule::unique(self::getTableName(), 'email')->ignore($userId);
        $roleExists  = Rule::exists(RoleModel::getTableName(), 'id');

        if (!empty($userId)) {
            $passwordRule = ['nullable'];
        } else {
            $passwordRule = ['required', 'confirmed'];
        }

        return [
            'rules'      => [
                'name'     => ['required', 'string', 'max:190'],
                'email'    => ['required', 'string', 'max:190', 'email', $emailUnique],
                'password' => array_merge(['string', 'max:190'], $passwordRule),
                'phone'    => ['required', 'string', 'max:20'],
                'role_id'  => ['required', 'integer', $roleExists],
                'active'   => ['nullable', 'boolean'],
            ],
            'messages'   => [],
            'attributes' => [
                'name'     => 'nome',
                'email'    => 'e-mail',
                'password' => 'senha',
                'phone'    => 'telefone',
                'role_id'  => 'perfil',
            ],
        ];
    }

    public static function requestIntercept(Request $request)
    {
        $password = $request->get('password');

        if (!empty($password)) {
            $request->request->set('password_confirmation', $password);
        } else {
            $request->request->remove('password');
        }
    }

    public static function listAll(array $params = [])
    {
        $subQueryRoleName = (new RoleModel)
            ->select('name')
            ->whereColumn('id', 'users.role_id')
            ->limit(1);

        return (new self)
            ->addSelect(['role_name' => $subQueryRoleName])
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
