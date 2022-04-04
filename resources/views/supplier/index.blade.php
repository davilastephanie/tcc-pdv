@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Administrativo</li>
    <li class="breadcrumb-item"><a href="{{ route('supplier.index') }}">Fornecedores</a></li>
    <li class="breadcrumb-item active">Todos</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-truck mr-1"></i> Fornecedores
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('supplier.create') }}" class="btn btn-primary btn-icon">
                                <i class="c-icon cil-plus"></i> Novo fornecedor
                            </a>
                            <a href="{{ route('supplier.export') }}" class="btn btn-dark btn-icon">
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

                @if ($suppliers->count() == 0)
                    <h5 class="my-3">Nenhum fornecedor encontrado.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th>@linkOrderby(['label' => 'Nome Fantasia', 'key' => 'name'])</th>
                                <th>@linkOrderby(['label' => 'CNPJ', 'key' => 'cnpj'])</th>
                                <th>@linkOrderby(['label' => 'E-mail', 'key' => 'email'])</th>
                                <th style="width: 1px;">@linkOrderby(['label' => 'Ativo', 'key' => 'active'])</th>
                                <th style="width: 1px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($suppliers as $supplier)
                                <tr>
                                    <td>
                                        <a href="{{ route('supplier.edit', $supplier->id) }}">
                                            {{ $supplier->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $supplier->cnpj }}
                                    </td>
                                    <td>
                                        {{ $supplier->email }}
                                    </td>
                                    <td class="text-nowrap">
                                        <label class="c-switch c-switch-label c-switch-opposite-success">
                                            <input type="checkbox"
                                                   class="c-switch-input js-toggle-active"
                                                   data-url="{{ route('supplier.update', $supplier->id) }}"
                                                    {{ $supplier->active ? 'checked' : '' }}
                                            >
                                            <span class="c-switch-slider"
                                                  data-checked="✓"
                                                  data-unchecked="✕"
                                            ></span>
                                        </label>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('supplier.edit', $supplier->id) }}"
                                           class="btn btn-sm btn-outline-success btn-icon"
                                        >
                                            <i class="c-icon cil-pencil"></i> Editar
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-icon js-destroy-confirm"
                                                data-url="{{ route('supplier.destroy', $supplier->id) }}"
                                                {{ $supplier->products->count() ? 'disabled' : '' }}
                                        >
                                            <i class="c-icon cil-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $suppliers])
                @endif
            </form>
        </div>
    </div>
@endsection