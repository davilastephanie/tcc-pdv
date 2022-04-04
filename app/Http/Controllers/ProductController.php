<?php

namespace App\Http\Controllers;

use App\Exports\ProductExport;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\StockModel;
use App\Models\SubcategoryModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('product');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('product.index', [
            'products' => ProductModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('product.create', [
            'product'       => new ProductModel,
            'categories'    => CategoryModel::listHtmlSelect(['active' => true]),
            'subcategories' => [],
            'suppliers'     => SupplierModel::listHtmlSelect(['active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        ProductModel::requestIntercept($request);

        $this->validateByModel($request, ProductModel::validation($request->all()));

        $product = ProductModel::create($request->all());

        StockModel::create([
            'product_id'  => $product->id,
            'user_id'     => auth()->id(),
            'quantity'    => $request->get('stock'),
            'action'      => 'e',
            'description' => 'Carga inicial',
        ]);

        return redirect()->route('product.index')->with('status', 'Produto adicionado.');
    }

    public function edit($id)
    {
        $product = ProductModel::findOrFail($id);

        return view('product.edit', [
            'product'       => $product,
            'categories'    => CategoryModel::listHtmlSelect(),
            'subcategories' => SubcategoryModel::listHtmlSelect(['category_id' => $product->category_id]),
            'suppliers'     => SupplierModel::listHtmlSelect(),
            'actions'       => StockModel::actions(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        ProductModel::requestIntercept($request);

        $this->validateByModel($request, ProductModel::validation($request->all()));

        $product = ProductModel::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('product.index')->with('status', 'Produto atualizado.');
    }

    public function destroy($id)
    {
        $product = ProductModel::findOrFail($id);
        $product->delete();

        return redirect()->back()->with('status', 'Produto excluído.');
    }

    public function stock(Request $request, $id)
    {
        $request->merge([
            'product_id'  => $id,
            'user_id'     => auth()->id(),
            'action'      => $request->get('stock_action'),
            'quantity'    => $request->get('stock_quantity'),
            'description' => $request->get('stock_description'),
        ]);

        if (empty($request->description)) {
            $request->request->set('description', 'Movimentação manual');
        }

        $vParams = (object) StockModel::validation($request->all());

        $this->validateByAjax($request, $vParams->rules, $vParams->messages, $vParams->attributes);

        StockModel::create([
            'product_id'  => $id,
            'user_id'     => auth()->id(),
            'quantity'    => $request->get('quantity'),
            'action'      => $request->get('action'),
            'description' => $request->get('description'),
        ]);

        ProductModel::updateStock($id);

        return response()->json([
            'status'  => 'success',
            'message' => 'Estoque atualizado.',
        ]);
    }

    public function export()
    {
        return ProductExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $product = ProductModel::findOrFail($id);

        $active  = !$product->active;
        $success = $product->update(['active' => $active]);

        if ($active) {
            $message = 'Produto ativado.';
        } else {
            $message = 'Produto inativado.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
