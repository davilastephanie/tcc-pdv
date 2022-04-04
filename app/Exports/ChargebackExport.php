<?php

namespace App\Exports;

use App\Models\ChargebackModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class ChargebackExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'chargebacks-' . date('Ymd-Hi') . '.xlsx');
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
        $chargebacks = (new ChargebackModel)->activated()->orderBy('created_at', 'desc')->get();
        $records     = new Collection([]);

        foreach ($chargebacks as $chargeback) {
            $records->push([
                [
                    'value' => $chargeback->created_at_show,
                    'align' => 'left',
                ],
                [
                    'value' => $chargeback->user->name,
                    'align' => 'left',
                ],
                [
                    'value' => $chargeback->client->name,
                    'align' => 'left',
                ],
                [
                    'value' => $chargeback->product->name,
                    'align' => 'left',
                ],
                [
                    'value' => $chargeback->quantity,
                    'align' => 'left',
                ],
                [
                    'value' => $chargeback->note,
                    'align' => 'left',
                ],
            ]);
        }

        $headings = [
            [
                'value' => 'Data',
                'align' => 'left',
            ],
            [
                'value' => 'Responsável',
                'align' => 'left',
            ],
            [
                'value' => 'Cliente',
                'align' => 'left',
            ],
            [
                'value' => 'Produto',
                'align' => 'left',
            ],
            [
                'value' => 'Quantidade',
                'align' => 'left',
            ],
            [
                'value' => 'Observação',
                'align' => 'left',
            ],
        ];

        return view('exports.default', [
            'headings' => $headings,
            'records'  => $records,
            'title'    => 'Devoluções',
        ]);
    }
}
