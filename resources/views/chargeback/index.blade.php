@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">PDV</li>
    <li class="breadcrumb-item"><a href="{{ route('chargeback.index') }}">Devoluções</a></li>
    <li class="breadcrumb-item active">Todas</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-loop-circular mr-1"></i> Devoluções
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('chargeback.create') }}" class="btn btn-primary btn-icon">
                                <i class="c-icon cil-plus"></i> Nova devolução
                            </a>
                            <a href="{{ route('chargeback.export') }}" class="btn btn-dark btn-icon">
                                <i class="c-icon cil-data-transfer-down"></i> Exportar
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text"
                                       class="form-control"
                                       name="search"
                                       value="{{ request('search') }}"
                                       placeholder="Pesquisar..."
                                >
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="c-icon cil-magnifying-glass m-0"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($chargebacks->count() == 0)
                    <h5 class="my-3">Nenhuma devolução encontrada.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th width="200">@linkOrderby(['label' => 'Data', 'key' => 'created_at'])</th>
                                <th>@linkOrderby(['label' => 'Responsável', 'key' => 'user_name'])</th>
                                <th>@linkOrderby(['label' => 'Cliente', 'key' => 'client_name'])</th>
                                <th>@linkOrderby(['label' => 'Produto', 'key' => 'product_name'])</th>
                                <th width="200">@linkOrderby(['label' => 'Qtde', 'key' => 'quantity'])</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($chargebacks as $chargeback)
                                <tr>
                                    <td>
                                        {{ $chargeback->created_at_show }}
                                    </td>
                                    <td>
                                        {{ $chargeback->user_name }}
                                    </td>
                                    <td>
                                        {{ $chargeback->client_name }}
                                    </td>
                                    <td>
                                        {{ $chargeback->product_name }}
                                    </td>
                                    <td>
                                        {{ $chargeback->quantity }}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $chargebacks])
                @endif
            </form>
        </div>
    </div>
@endsection

@push('modal')
    <div class="modal" tabindex="-1" id="modalShow"></div>
@endpush