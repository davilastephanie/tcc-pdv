<?php

namespace App\Http\Controllers;

use App\Exports\SupplierExport;
use App\Models\StateModel;
use App\Models\SupplierModel;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('supplier');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('supplier.index', [
            'suppliers' => SupplierModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('supplier.create', [
            'supplier' => new SupplierModel,
            'states'   => StateModel::listHtmlSelect(),
        ]);
    }

    public function store(Request $request)
    {
        SupplierModel::requestIntercept($request);

        $this->validateByModel($request, SupplierModel::validation($request->all()));

        SupplierModel::create($request->all());

        return redirect()->route('supplier.index')->with('status', 'Fornecedor adicionado.');
    }

    public function edit($id)
    {
        return view('supplier.edit', [
            'supplier' => SupplierModel::findOrFail($id),
            'states'   => StateModel::listHtmlSelect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        SupplierModel::requestIntercept($request);

        $this->validateByModel($request, SupplierModel::validation($request->all()));

        $supplier = SupplierModel::findOrFail($id);
        $supplier->update($request->all());

        return redirect()->route('supplier.index')->with('status', 'Fornecedor atualizado.');
    }

    public function destroy($id)
    {
        $supplier = SupplierModel::findOrFail($id);
        $supplier->delete();

        return redirect()->back()->with('status', 'Fornecedor excluído.');
    }

    public function export()
    {
        return SupplierExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $supplier = SupplierModel::findOrFail($id);

        $active  = !$supplier->active;
        $success = $supplier->update(['active' => $active]);

        if ($active) {
            $message = 'Fornecedor ativado.';
        } else {
            $message = 'Fornecedor inativado.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
