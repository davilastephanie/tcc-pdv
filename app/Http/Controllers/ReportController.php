<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->setMenuActive('report');
    }

    public function index()
    {
        $items = getAppMenu('export', true);

        foreach ($items as $group => $modules) {
            foreach ($modules as $prefix => $props) {
                $route = "{$prefix}.export";
                $url   = '#';

                if (Route::has($route)) {
                    $url = route($route);
                }

                $items[$group][$prefix]['url'] = $url;
            }
        }

        return view('report.index', compact('items'));
    }
}
