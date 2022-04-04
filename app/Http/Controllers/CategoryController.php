<?php

namespace App\Http\Controllers;

use App\Exports\CategoryExport;
use App\Models\CategoryModel;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('category');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('category.index', [
            'categories' => CategoryModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('category.create', [
            'category' => new CategoryModel,
        ]);
    }

    public function store(Request $request)
    {
        CategoryModel::requestIntercept($request);

        $this->validateByModel($request, CategoryModel::validation($request->all()));

        CategoryModel::create($request->all());

        return redirect()->route('category.index')->with('status', 'Categoria adicionada.');
    }

    public function edit($id)
    {
        return view('category.edit', [
            'category' => CategoryModel::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        CategoryModel::requestIntercept($request);

        $this->validateByModel($request, CategoryModel::validation($request->all()));

        $category = CategoryModel::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('category.index')->with('status', 'Categoria atualizada.');
    }

    public function destroy($id)
    {
        $category = CategoryModel::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('status', 'Categoria excluída.');
    }

    public function export()
    {
        return CategoryExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $category = CategoryModel::findOrFail($id);

        $active  = !$category->active;
        $success = $category->update(['active' => $active]);

        if ($active) {
            $message = 'Categoria ativada.';
        } else {
            $message = 'Categoria inativada.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
