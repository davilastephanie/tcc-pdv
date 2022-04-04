<input type="hidden" name="id" value="{{ $product->id }}">

@if (!$product->id)
    @include('product.tabs.01')
@else
    @php
        $tab  = request('tab', 1);
        $tabs = [
            1 => $tab == 1 ? 'active' : '',
            2 => $tab == 2 ? 'active' : '',
        ];
    @endphp
    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
            <a href="#tab1" class="nav-link {{ $tabs[1] }}" data-toggle="tab">
                <i class="c-icon cil-cart"></i> Produto
            </a>
        </li>
        <li class="nav-item">
            <a href="#tab2" class="nav-link {{ $tabs[2] }}" data-toggle="tab">
                <i class="c-icon cil-layers"></i> Estoque
            </a>
        </li>
    </ul>

    <div class="tab-content pt-3">
        <div id="tab1" class="tab-pane {{ $tabs[1] }}">
            @include('product.tabs.01')
        </div>
        <div id="tab2" class="tab-pane {{ $tabs[2] }}">
            @include('product.tabs.02')
        </div>
    </div>
@endif