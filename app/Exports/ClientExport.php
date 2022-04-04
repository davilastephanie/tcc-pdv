<?php

namespace App\Exports;

use App\Models\ClientModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ClientExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'clients-' . date('Ymd-Hi') . '.xlsx');
    }

    /**
     * Export Excel
     *
     * https://docs.laravel-excel.com/3.1/architecture/
     * https://docs.laravel-excel.com/3.1/exports/mapping.html
     * https://docs.laravel-excel.com/3.1/exports/from-view.html
     */

    public function view(): View
    {
        $clients = (new ClientModel)->activated()->orderBy('name', 'asc')->get();
        $records = new Collection([]);

        foreach ($clients as $client) {
            $records->push([
                [
                    'value' => $client->name,
                    'align' => 'left',
                ],
                [
                    'value' => $client->email,
                    'align' => 'left',
                ],
                [
                    'value' => $client->cpf,
                    'align' => 'left',
                ],
                [
                    'value' => $client->rg,
                    'align' => 'left',
                ],
                [
                    'value' => $client->phone,
                    'align' => 'left',
                ],
                [
                    'value' => $client->birthday,
                    'align' => 'left',
                ],
                [
                    'value' => $client->cep,
                    'align' => 'left',
                ],
                [
                    'value' => $client->address,
                    'align' => 'left',
                ],
                [
                    'value' => $client->number,
                    'align' => 'left',
                ],
                [
                    'value' => $client->neighborhood,
                    'align' => 'left',
                ],
                [
                    'value' => $client->city,
                    'align' => 'left',
                ],
                [
                    'value' => $client->state->name,
                    'align' => 'left',
                ],
                [
                    'value' => $client->created_at_show,
                    'align' => 'left',
                ],
            ]);
        }

        $headings = [
            [
                'value' => 'Nome',
                'align' => 'left',
            ],
            [
                'value' => 'E-mail',
                'align' => 'left',
            ],
            [
                'value' => 'CPF',
                'align' => 'left',
            ],
            [
                'value' => 'RG',
                'align' => 'left',
            ],
            [
                'value' => 'Telefone',
                'align' => 'left',
            ],
            [
                'value' => 'Data de Nascimento',
                'align' => 'left',
            ],
            [
                'value' => 'CEP',
                'align' => 'left',
            ],
            [
                'value' => 'Endereço',
                'align' => 'left',
            ],
            [
                'value' => 'Número',
                'align' => 'left',
            ],
            [
                'value' => 'Bairro',
                'align' => 'left',
            ],
            [
                'value' => 'Cidade',
                'align' => 'left',
            ],
            [
                'value' => 'Estado',
                'align' => 'left',
            ],
            [
                'value' => 'Data de Cadastro',
                'align' => 'left',
            ],
        ];

        return view('exports.default', [
            'headings' => $headings,
            'records'  => $records,
            'title'    => 'Clientes',
        ]);
    }
}
