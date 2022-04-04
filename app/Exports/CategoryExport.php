<?php

namespace App\Exports;

use App\Models\CategoryModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class CategoryExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'categories-' . date('Ymd-Hi') . '.xlsx');
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
        $categories = (new CategoryModel)->activated()->orderBy('name', 'asc')->get();
        $records    = new Collection([]);

        foreach ($categories as $category) {
            $records->push([
                [
                    'value' => $category->name,
                    'align' => 'left',
                ],
                [
                    'value' => $category->created_at_show,
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
                'value' => 'Data de Cadastro',
                'align' => 'left',
            ],
        ];

        return view('exports.default', [
            'headings' => $headings,
            'records'  => $records,
            'title'    => 'Categorias',
        ]);
    }
}
