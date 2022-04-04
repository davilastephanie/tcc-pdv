@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">PDV</li>
    <li class="breadcrumb-item active">Vendas</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-calculator mr-1"></i> Vendas
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('order.export') }}" class="btn btn-dark btn-icon">
                                <i class="c-icon cil-data-transfer-down"></i> Exportar
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                    </div>
                </div>

                @if ($orders->count() == 0)
                    <h5 class="my-3">Nenhuma venda encontrada.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th width="120">@linkOrderby(['label' => 'Número', 'key' => 'id'])</th>
                                <th width="200">@linkOrderby(['label' => 'Data', 'key' => 'created_at'])</th>
                                <th>@linkOrderby(['label' => 'Vendedor', 'key' => 'user_name'])</th>
                                <th>@linkOrderby(['label' => 'Cliente', 'key' => 'client_name'])</th>
                                <th width="200">@linkOrderby(['label' => 'Total', 'key' => 'total'])</th>
                                <th width="200">@linkOrderby(['label' => 'Status', 'key' => 'status'])</th>
                                <th width="1"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($orders as $order)
                                <tr>
                                    <td>
                                        {{ $order->id_show }}
                                    </td>
                                    <td>
                                        {{ $order->created_at_show }}
                                    </td>
                                    <td>
                                        {{ $order->user_name }}
                                    </td>
                                    <td>
                                        {{ $order->client_name }}
                                    </td>
                                    <td>
                                        R$ {{ $order->total_show }}
                                    </td>
                                    <td>
                                        {!! $order->status_html !!}
                                    </td>
                                    <td class="text-nowrap">
                                        <button type="button"
                                                class="btn btn-sm btn-outline-info btn-icon js-modal-ajax"
                                                data-target="#modalShow"
                                                data-url="{{ route('order.show', $order->id) }}"
                                        >
                                            <i class="c-icon cil-zoom-in"></i> Visualizar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $orders])
                @endif
            </form>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal" tabindex="-1" id="modalShow"></div>
@endpush