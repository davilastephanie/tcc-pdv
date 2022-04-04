<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuthModel;
use App\Models\UserModel;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $data['role_id'] = 4; // Operador

        $vParams = (object) UserModel::validation();

        return Validator::make($data, $vParams->rules, $vParams->messages, $vParams->attributes);
    }

    protected function create(array $data)
    {
        $data['role_id'] = 4; // Operador

        return AuthModel::create($data);
    }
}
