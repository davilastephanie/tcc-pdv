<?php

namespace App\Http\Controllers;

use App\Exports\SubcategoryExport;
use App\Models\CategoryModel;
use App\Models\SubcategoryModel;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('subcategory');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('subcategory.index', [
            'subcategories' => SubcategoryModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('subcategory.create', [
            'subcategory' => new SubcategoryModel,
            'categories'  => CategoryModel::listHtmlSelect(['active' => true]),
        ]);
    }

    public function store(Request $request)
    {
        SubcategoryModel::requestIntercept($request);

        $this->validateByModel($request, SubcategoryModel::validation($request->all()));

        SubcategoryModel::create($request->all());

        return redirect()->route('subcategory.index')->with('status', 'Subcategoria adicionada.');
    }

    public function edit($id)
    {
        return view('subcategory.edit', [
            'subcategory' => SubcategoryModel::findOrFail($id),
            'categories'  => CategoryModel::listHtmlSelect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        SubcategoryModel::requestIntercept($request);

        $this->validateByModel($request, SubcategoryModel::validation($request->all()));

        $subcategory = SubcategoryModel::findOrFail($id);
        $subcategory->update($request->all());

        return redirect()->route('subcategory.index')->with('status', 'Subcategoria atualizada.');
    }

    public function destroy($id)
    {
        $subcategory = SubcategoryModel::findOrFail($id);
        $subcategory->delete();

        return redirect()->back()->with('status', 'Subcategoria excluída.');
    }

    public function export()
    {
        return SubcategoryExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $subcategory = SubcategoryModel::findOrFail($id);

        $active  = !$subcategory->active;
        $success = $subcategory->update(['active' => $active]);

        if ($active) {
            $message = 'Subcategoria ativada.';
        } else {
            $message = 'Subcategoria inativada.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
