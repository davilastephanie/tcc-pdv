<?php

namespace App\Exports;

use App\Models\ProductModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ProductExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'products-' . date('Ymd-Hi') . '.xlsx');
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
        $products = (new ProductModel)->activated()->orderBy('name', 'asc')->get();
        $records  = new Collection([]);

        foreach ($products as $product) {
            $records->push([
                [
                    'value' => $product->name,
                    'align' => 'left',
                ],
                [
                    'value' => $product->barcode,
                    'align' => 'left',
                ],
                [
                    'value' => $product->category->name,
                    'align' => 'left',
                ],
                [
                    'value' => $product->subcategory->name,
                    'align' => 'left',
                ],
                [
                    'value' => $product->supplier->name,
                    'align' => 'left',
                ],
                [
                    'value' => $product->description,
                    'align' => 'left',
                ],
                [
                    'value' => 'R$ ' . $product->price_show,
                    'align' => 'left',
                ],
                [
                    'value' => $product->image_show,
                    'align' => 'left',
                ],
                [
                    'value' => $product->stock,
                    'align' => 'left',
                ],
                [
                    'value' => $product->created_at_show,
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
                'value' => 'Código de Barras',
                'align' => 'left',
            ],
            [
                'value' => 'Categoria',
                'align' => 'left',
            ],
            [
                'value' => 'Subcategoria',
                'align' => 'left',
            ],
            [
                'value' => 'Fornecedor',
                'align' => 'left',
            ],
            [
                'value' => 'Descrição',
                'align' => 'left',
            ],
            [
                'value' => 'Preço',
                'align' => 'left',
            ],
            [
                'value' => 'Imagem',
                'align' => 'left',
            ],
            [
                'value' => 'Estoque',
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
            'title'    => 'Produtos',
        ]);
    }
}
