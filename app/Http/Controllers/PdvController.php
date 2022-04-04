<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use Illuminate\Http\Request;

class PdvController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('pdv');
    }

    public function index()
    {
        $paymentTypes = OrderModel::paymentTypes();

        return view('pdv.index', compact('paymentTypes'));
    }

    public function store(Request $request)
    {
        OrderModel::requestIntercept($request);

        $this->validateByModel($request, OrderModel::validation($request->all()));

        $order = OrderModel::create([
            'client_id'    => $request->get('client_id'),
            'user_id'      => $request->get('user_id'),
            'total'        => $request->get('total'),
            'payment_type' => $request->get('payment_type'),
            'status'       => $request->get('status'),
        ]);

        $products = [];

        foreach ((array) $request->get('products') as $key) {
            $id       = $request->get("product_{$key}_id");
            $price    = $request->get("product_{$key}_price");
            $quantity = $request->get("product_{$key}_quantity");
            $total    = $price * $quantity;

            $products[$id] = [
                'price'    => $price,
                'quantity' => $quantity,
                'total'    => $total,
            ];
        }

        $order->products()->attach($products);

        if ($request->get('status') == 'pay') {
            foreach ($products as $id => $values) {
                StockModel::create([
                    'product_id'  => $id,
                    'user_id'     => auth()->id(),
                    'quantity'    => $values['quantity'],
                    'action'      => 's',
                    'description' => 'Venda pelo PDV',
                ]);

                ProductModel::updateStock($id);
            }

            $message = 'Venda concluída.';
        } else {
            $message = 'Venda salva.';
        }

        return response()->json(['status' => 'success', 'message' => $message]);
    }
}