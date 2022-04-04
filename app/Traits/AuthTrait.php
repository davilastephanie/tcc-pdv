<?php

namespace App\Traits;

use App\Models\UserModel;
use Illuminate\Validation\Rule;

trait AuthTrait
{
    public static function validation()
    {
        $emailExists = Rule::exists(UserModel::getTableName(), 'email');

        return [
            'rules'      => [
                'email'    => ['required', 'email', $emailExists],
                'password' => ['required'],
            ],
            'messages'   => [],
            'attributes' => [
                'email'    => 'e-mail',
                'password' => 'senha',
            ],
        ];
    }
}
