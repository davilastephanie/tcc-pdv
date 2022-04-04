<?php

use App\Models\UserModel;

function getAppMenu($menuActive, $hasExport = false)
{
    $modules = [
        'user'     => [
            'title'  => 'Usuários',
            'url'    => route('user.index'),
            'icon'   => 'cil-user',
            'export' => true,
        ],
        'client'   => [
            'title'  => 'Clientes',
            'url'    => route('client.index'),
            'icon'   => 'cil-people',
            'export' => true,
        ],
        'supplier' => [
            'title'  => 'Fornecedores',
            'url'    => route('supplier.index'),
            'icon'   => 'cil-truck',
            'export' => true,
        ],

        'product'     => [
            'title'  => 'Produtos',
            'url'    => route('product.index'),
            'icon'   => 'cil-cart',
            'export' => true,
        ],
        'category'    => [
            'title'  => 'Categorias',
            'url'    => route('category.index'),
            'icon'   => 'cil-tag',
            'export' => true,
        ],
        'subcategory' => [
            'title'  => 'Subcategorias',
            'url'    => route('subcategory.index'),
            'icon'   => 'cil-tags',
            'export' => true,
        ],

        'pdv'        => [
            'title' => 'PDV',
            'url'   => route('pdv.index'),
            'icon'  => 'cil-screen-desktop',
        ],
        'order'      => [
            'title'  => 'Vendas',
            'url'    => route('order.index'),
            'icon'   => 'cil-calculator',
            'export' => true,
        ],
        'chargeback' => [
            'title'  => 'Devoluções',
            'url'    => route('chargeback.index'),
            'icon'   => 'cil-loop-circular',
            'export' => true,
        ],

        'report' => [
            'title' => 'Relatórios',
            'url'   => route('report.index'),
            'icon'  => 'cil-print',
        ],
        'graph'  => [
            'title' => 'Gráficos',
            'url'   => route('graph.index'),
            'icon'  => 'cil-chart-line',
        ],
    ];

    $groups = [
        'Administrativo' => [
            'user',
            'client',
            'supplier',
        ],

        'Produtos' => [
            'product',
            'category',
            'subcategory',
        ],

        'PDV' => [
            'pdv',
            'order',
            'chargeback',
        ],

        'Analítico' => [
            'report',
            'graph',
        ],
    ];

    if ($hasExport) {
        $modules = array_filter($modules, function ($module) {
            return isset($module['export']) && $module['export'];
        });
    }

    $user         = UserModel::find(auth()->id());
    $userModules  = explode(',', $user->role->modules);
    $userModules  = array_flip($userModules);
    $allowModules = array_intersect_key($modules, $userModules);

    $result = [];

    foreach ($groups as $title => $mods) {
        foreach ($allowModules as $k => $v) {
            if (in_array($k, $mods)) {
                $v['active'] = ($k == $menuActive);

                $result[$title][$k] = $v;
            }
        }
    }

    return $result;
}
