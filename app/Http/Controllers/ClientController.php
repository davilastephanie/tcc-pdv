<?php

namespace App\Http\Controllers;

use App\Exports\ClientExport;
use App\Models\ClientModel;
use App\Models\StateModel;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('client');
        $this->setOrderBy('name');
    }

    public function index(Request $request)
    {
        return view('client.index', [
            'clients' => ClientModel::listAll($request->all()),
        ]);
    }

    public function create()
    {
        return view('client.create', [
            'client' => new ClientModel,
            'states' => StateModel::listHtmlSelect(),
        ]);
    }

    public function store(Request $request)
    {
        ClientModel::requestIntercept($request);

        $this->validateByModel($request, ClientModel::validation($request->all()));

        ClientModel::create($request->all());

        return redirect()->route('client.index')->with('status', 'Cliente adicionado.');
    }

    public function edit($id)
    {
        return view('client.edit', [
            'client' => ClientModel::findOrFail($id),
            'states' => StateModel::listHtmlSelect(),
        ]);
    }

    public function update(Request $request, $id)
    {
        if ($request->get('active') == 'toggle') {
            return $this->_toggleActive($id);
        }

        ClientModel::requestIntercept($request);

        $this->validateByModel($request, ClientModel::validation($request->all()));

        $client = ClientModel::findOrFail($id);
        $client->update($request->all());

        return redirect()->route('client.index')->with('status', 'Cliente atualizado.');
    }

    public function destroy($id)
    {
        $client = ClientModel::findOrFail($id);
        $client->delete();

        return redirect()->back()->with('status', 'Cliente excluído.');
    }

    public function export()
    {
        return ClientExport::download();
    }

    /**
     * Métodos privados
     */

    public function _toggleActive($id)
    {
        $client = ClientModel::findOrFail($id);

        $active  = !$client->active;
        $success = $client->update(['active' => $active]);

        if ($active) {
            $message = 'Cliente ativado.';
        } else {
            $message = 'Cliente inativado.';
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
