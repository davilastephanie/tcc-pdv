<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class CustomValueBinder extends DefaultValueBinder implements WithCustomValueBinder
{
    public function bindValue(Cell $cell, $value)
    {
        /**
         * https://docs.laravel-excel.com/3.1/exports/custom-formatting-values.html
         */

        $cell->setValueExplicit(trim($value), DataType::TYPE_STRING);

        return true;
    }
}