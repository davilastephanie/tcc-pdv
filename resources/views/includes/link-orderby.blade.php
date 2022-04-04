@php

    $orderBy = request('order_by');
    $type    = isset($type) && $type == 'numeric' ? 'numeric' : 'alpha';
    $arrow   = '';
    $title   = 'Clique para ordenar';

    if ($key === ltrim($orderBy, '-')) {
        if (substr($orderBy, 0, 1) === '-') {
            $arrow = "c-icon cil-sort-{$type}-down";
            $title = 'DESC ';
        } else {
            $arrow = "c-icon cil-sort-{$type}-up";
            $title = 'ASC ';
        }
    }

@endphp
<a href="#"
   class="link-order-by js-search-order-by"
   title="{{ $title }}"
   data-column="{{ $key }}"
   data-toggle="tooltip"
>
    {{ $label }} <i class="{{ $arrow }}"></i>
</a>
