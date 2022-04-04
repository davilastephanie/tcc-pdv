<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function setMenuActive($key)
    {
        view()->share('menuActive', $key);
    }

    protected function setOrderBy($column = '-created_at')
    {
        request()->merge(['order_by' => request('order_by', $column)]);
    }

    protected function setPerPage($quantity = null)
    {
        request()->merge(['per_page' => $quantity]);
    }

    protected function validateByModel(Request $request, array $params)
    {
        $this->validate($request, $params['rules'], $params['messages'], $params['attributes']);
    }

    protected function validateByAjax(Request $request, array $rules, array $messages = [], array $attributes = [])
    {
        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'status'    => 'error',
                'message'   => $validator->getMessageBag()->first(),
                'attribute' => $validator->getMessageBag()->keys()[0],
            ], 422));
        }
    }
}
