<?php

namespace App\Exports;

use App\Models\OrderModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class OrderExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'orders-' . date('Ymd-Hi') . '.xlsx');
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
        $orders  = (new OrderModel)->activated()->orderBy('id', 'desc')->get();
        $records = new Collection([]);

        foreach ($orders as $order) {
            $records->push([
                [
                    'value' => $order->id_show,
                    'align' => 'left',
                ],
                [
                    'value' => $order->created_at_show,
                    'align' => 'left',
                ],
                [
                    'value' => $order->user->name,
                    'align' => 'left',
                ],
                [
                    'value' => $order->client->name,
                    'align' => 'left',
                ],
                [
                    'value' => 'R$ ' . $order->total_show,
                    'align' => 'left',
                ],
                [
                    'value' => $order->status_show,
                    'align' => 'left',
                ],
            ]);
        }

        $headings = [
            [
                'value' => 'Número',
                'align' => 'left',
            ],
            [
                'value' => 'Data',
                'align' => 'left',
            ],
            [
                'value' => 'Vendedor',
                'align' => 'left',
            ],
            [
                'value' => 'Cliente',
                'align' => 'left',
            ],
            [
                'value' => 'Total',
                'align' => 'left',
            ],
            [
                'value' => 'Status',
                'align' => 'left',
            ],
        ];

        return view('exports.default', [
            'headings' => $headings,
            'records'  => $records,
            'title'    => 'Vendas',
        ]);
    }
}
