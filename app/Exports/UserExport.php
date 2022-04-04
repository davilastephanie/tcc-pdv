<?php

namespace App\Exports;

use App\Models\UserModel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Facades\Excel;

class UserExport implements FromView, ShouldAutoSize
{
    public static function download()
    {
        return Excel::download(new self, 'users-' . date('Ymd-Hi') . '.xlsx');
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
        $users   = (new UserModel)->activated()->orderBy('name', 'asc')->get();
        $records = new Collection([]);

        foreach ($users as $user) {
            $records->push([
                [
                    'value' => $user->name,
                    'align' => 'left',
                ],
                [
                    'value' => $user->email,
                    'align' => 'left',
                ],
                [
                    'value' => $user->phone,
                    'align' => 'left',
                ],
                [
                    'value' => $user->role->name,
                    'align' => 'left',
                ],
                [
                    'value' => $user->created_at_show,
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
                'value' => 'Telefone',
                'align' => 'left',
            ],
            [
                'value' => 'Perfil',
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
            'title'    => 'Usuários',
        ]);
    }
}
