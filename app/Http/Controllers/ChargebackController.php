<?php

namespace App\Http\Controllers;

use App\Exports\ChargebackExport;
use App\Models\ChargebackModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use Illuminate\Http\Request;

class ChargebackController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('chargeback');
        $this->setOrderBy('-created_at');
    }

    public function index(Request $request)
    {
        return view('chargeback.index', [
            'chargebacks' => ChargebackModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('chargeback.create', ['chargeback' => new ChargebackModel]);
    }

    public function store(Request $request)
    {
        ChargebackModel::requestIntercept($request);

        $this->validateByModel($request, ChargebackModel::validation($request->all()));

        ChargebackModel::create($request->all());

        $productId = $request->get('product_id');

        StockModel::create([
            'product_id'  => $productId,
            'user_id'     => auth()->id(),
            'quantity'    => $request->get('quantity'),
            'action'      => 'e',
            'description' => 'Devolução',
        ]);

        ProductModel::updateStock($productId);

        return redirect()->route('chargeback.index')->with('status', 'Devolução realizada.');
    }

    public function export()
    {
        return ChargebackExport::download();
    }
}