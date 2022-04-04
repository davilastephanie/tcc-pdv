<?php

namespace App\Exports;

use App\Models\SupplierModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class SupplierExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'suppliers-' . date('Ymd-Hi') . '.xlsx');
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
        $suppliers = (new SupplierModel)->activated()->orderBy('name', 'asc')->get();
        $records   = new Collection([]);

        foreach ($suppliers as $supplier) {
            $records->push([
                [
                    'value' => $supplier->name,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->company,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->email,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->cnpj,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->phone,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->cep,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->address,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->number,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->neighborhood,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->city,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->state->name,
                    'align' => 'left',
                ],
                [
                    'value' => $supplier->created_at_show,
                    'align' => 'left',
                ],
            ]);
        }

        $headings = [
            [
                'value' => 'Nome Fantasia',
                'align' => 'left',
            ],
            [
                'value' => 'Razão Social',
                'align' => 'left',
            ],
            [
                'value' => 'E-mail',
                'align' => 'left',
            ],
            [
                'value' => 'CNPJ',
                'align' => 'left',
            ],
            [
                'value' => 'Telefone',
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
            'title'    => 'Fornecedores',
        ]);
    }
}
