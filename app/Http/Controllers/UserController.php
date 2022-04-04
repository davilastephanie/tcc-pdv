<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use App\Models\RoleModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('user');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('user.index', [
            'users' => UserModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('user.create', [
            'user'  => new UserModel,
            'roles' => RoleModel::listHtmlSelect(),
        ]);
    }

    public function store(Request $request)
    {
        UserModel::requestIntercept($request);

        $this->validateByModel($request, UserModel::validation($request->all()));

        UserModel::create($request->all());

        return redirect()->route('user.index')->with('status', 'Usuário adicionado.');
    }

    public function edit($id)
    {
        return view('user.edit', [
            'user'  => UserModel::findOrFail($id),
            'roles' => RoleModel::listHtmlSelect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        UserModel::requestIntercept($request);

        $this->validateByModel($request, UserModel::validation($request->all()));

        $user = UserModel::findOrFail($id);
        $user->update($request->all());

        return redirect()->route('user.index')->with('status', 'Usuário atualizado.');
    }

    public function destroy($id)
    {
        $user = UserModel::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('status', 'Usuário excluído.');
    }

    public function export()
    {
        return UserExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $user = UserModel::findOrFail($id);

        $active  = !$user->active;
        $success = $user->update(['active' => $active]);

        if ($active) {
            $message = 'Usuário ativado.';
        } else {
            $message = 'Usuário inativado.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
