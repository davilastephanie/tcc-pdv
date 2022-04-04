<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class GraphController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('graph');
    }

    public function index()
    {
        $charts = [
            'topProducts'   => [
                'title'  => 'Produtos mais vendidos',
                'yTitle' => 'Qtde vendas',
                'series' => $this->_topProducts(),
            ],
            'monthProducts' => [
                'title'  => 'Produtos mais vendidos em ' . __(date('F')),
                'yTitle' => 'Qtde vendas',
                'series' => $this->_monthProducts(),
            ],
            'topClients'    => [
                'title'  => 'Melhores clientes',
                'yTitle' => 'Qtde vendas',
                'series' => $this->_topClients(),
            ],
            'yearOrders'    => [
                'title'  => 'Vendas por ano',
                'yTitle' => 'Qtde vendas',
                'series' => $this->_yearOrders(),
            ],
            'monthOrders'   => [
                'title'  => 'Vendas por mês',
                'yTitle' => 'Qtde vendas',
                'series' => $this->_monthOrders(),
            ],
        ];

        return view('graph.index', compact('charts'));
    }

    /**
     * Métodos auxiliares
     */

    private function _topProducts()
    {
        $products = DB::table('products', 'p')
            ->join('orders_products AS op', 'op.product_id', '=', 'p.id')
            ->select(['p.name', DB::raw('COUNT(op.order_id) AS total')])
            ->groupBy('p.id')
            ->orderBy('total', 'asc')
            ->orderBy('p.name', 'asc')
            ->limit(5)
            ->get();

        $result = [];

        foreach ($products as $product) {
            $result[] = [
                'label' => $product->name,
                'value' => $product->total,
            ];
        }

        return $result;
    }

    private function _monthProducts()
    {
        $products = DB::table('products', 'p')
            ->join('orders_products AS op', 'op.product_id', '=', 'p.id')
            ->select(['p.name', DB::raw('COUNT(op.order_id) AS total')])
            ->whereRaw('MONTH(op.created_at) = ?', [date('m')])
            ->groupBy('p.id')
            ->orderBy('total')
            ->orderBy('p.name')
            ->limit(5)
            ->get();

        $result = [];

        foreach ($products as $product) {
            $result[] = [
                'label' => $product->name,
                'value' => $product->total,
            ];
        }

        return $result;
    }

    private function _topClients()
    {
        $clients = DB::table('clients', 'c')
            ->join('orders AS o', 'o.client_id', '=', 'c.id')
            ->select(['c.name', DB::raw('COUNT(o.id) AS total')])
            ->groupBy('c.id')
            ->orderBy('total', 'asc')
            ->orderBy('c.name', 'asc')
            ->limit(5)
            ->get();

        $result = [];

        foreach ($clients as $client) {
            $result[] = [
                'label' => $client->name,
                'value' => $client->total,
            ];
        }

        return $result;
    }

    private function _yearOrders()
    {
        $orders = DB::table('orders', 'o')
            ->select([DB::raw('YEAR(o.created_at) AS year'), DB::raw('COUNT(o.id) AS count')])
            ->groupBy('year')
            ->orderBy('year')
            ->get();

        $result = [];

        foreach ($orders as $order) {
            $result[] = [
                'label' => $order->year,
                'value' => $order->count,
            ];
        }

        return $result;
    }

    private function _monthOrders()
    {
        $months = [
            1  => 'Janeiro',
            2  => 'Fevereiro',
            3  => 'Março',
            4  => 'Abril',
            5  => 'Maio',
            6  => 'Junho',
            7  => 'Julho',
            8  => 'Agosto',
            9  => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        $result  = [];
        $current = (int) date('m');

        foreach ($months as $i => $month) {
            if ($i > $current) {
                continue;
            }

            $result[$i] = [
                'label' => $month,
                'value' => 0,
            ];
        }

        $orders = DB::table('orders', 'o')
            ->select([DB::raw('MONTH(o.created_at) AS month'), DB::raw('COUNT(o.id) AS count')])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        foreach ($orders as $order) {
            $result[$order->month]['value'] = $order->count;
        }

        return array_values($result);
    }
}
