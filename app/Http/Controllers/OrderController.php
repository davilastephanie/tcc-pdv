<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\OrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('order');
        $this->setOrderBy('-id');
    }

    public function index(Request $request)
    {
        return view('order.index', [
            'orders' => OrderModel::listAll($request->all()),
        ]);
    }

    public function show($id)
    {
        return view('order.show', [
            'order' => OrderModel::findOrFail($id),
        ]);
    }

    public function export()
    {
        return OrderExport::download();
    }
}