<?php

namespace App\Exports;

use App\Models\SubcategoryModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class SubcategoryExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'subcategories-' . date('Ymd-Hi') . '.xlsx');
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
        $subcategories = (new SubcategoryModel)->activated()->orderBy('name', 'asc')->get();
        $records       = new Collection([]);

        foreach ($subcategories as $subcategory) {
            $records->push([
                [
                    'value' => $subcategory->name,
                    'align' => 'left',
                ],
                [
                    'value' => $subcategory->category->name,
                    'align' => 'left',
                ],
                [
                    'value' => $subcategory->created_at_show,
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
                'value' => 'Categoria',
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
            'title'    => 'Subcategorias',
        ]);
    }
}
