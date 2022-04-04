@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Produtos</li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item active">Todos</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-cart mr-1"></i> Produtos
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('product.create') }}" class="btn btn-primary btn-icon">
                                <i class="c-icon cil-plus"></i> Novo produto
                            </a>
                            <a href="{{ route('product.export') }}" class="btn btn-dark btn-icon">
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

                @if ($products->count() == 0)
                    <h5 class="my-3">Nenhum produto encontrado.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th>@linkOrderby(['label' => 'Nome', 'key' => 'name'])</th>
                                <th>@linkOrderby(['label' => 'Categoria', 'key' => 'category_name'])</th>
                                <th>@linkOrderby(['label' => 'Subcategoria', 'key' => 'subcategory_name'])</th>
                                <th>@linkOrderby(['label' => 'Fornecedor', 'key' => 'supplier_name'])</th>
                                <th style="width: 150px;">Qtde em Estoque</th>
                                <th style="width: 1px;">@linkOrderby(['label' => 'Ativo', 'key' => 'active'])</th>
                                <th style="width: 1px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id) }}">
                                            {{ $product->name }}
                                        </a>
                                        <small class="d-block pt-1">
                                            Código de barras: <strong>{{ $product->barcode }}</strong>
                                        </small>
                                    </td>
                                    <td>
                                        {{ $product->category->name }}
                                        <a href="{{ route('category.edit', $product->category->id) }}"
                                           target="_blank"
                                           title="Editar categoria"
                                           data-toggle="tooltip"
                                        >
                                            <i class="c-icon cil-external-link c-icon-sm ml-1"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $product->subcategory->name }}
                                        <a href="{{ route('subcategory.edit', $product->subcategory->id) }}"
                                           target="_blank"
                                           title="Editar subcategoria"
                                           data-toggle="tooltip"
                                        >
                                            <i class="c-icon cil-external-link c-icon-sm ml-1"></i>
                                        </a>
                                    </td>
                                    <td>
                                        {{ $product->supplier->name }}
                                        <a href="{{ route('supplier.edit', $product->supplier->id) }}"
                                           target="_blank"
                                           title="Editar fornecedor"
                                           data-toggle="tooltip"
                                        >
                                            <i class="c-icon cil-external-link c-icon-sm ml-1"></i>
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-{{ $product->stock > 0 ? 'success' : 'danger' }}"
                                              style="font-size: 16px; min-width: 40px;"
                                        >
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="text-nowrap">
                                        <label class="c-switch c-switch-label c-switch-opposite-success">
                                            <input type="checkbox"
                                                   class="c-switch-input js-toggle-active"
                                                   data-url="{{ route('product.update', $product->id) }}"
                                                    {{ $product->active ? 'checked' : '' }}
                                            >
                                            <span class="c-switch-slider"
                                                  data-checked="✓"
                                                  data-unchecked="✕"
                                            ></span>
                                        </label>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('product.edit', [$product->id, 'tab' => 2]) }}"
                                           class="btn btn-sm btn-outline-info btn-icon"
                                        >
                                            <i class="c-icon cil-layers"></i> Estoque
                                        </a>
                                        <a href="{{ route('product.edit', $product->id) }}"
                                           class="btn btn-sm btn-outline-success btn-icon"
                                        >
                                            <i class="c-icon cil-pencil"></i> Editar
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-icon js-destroy-confirm"
                                                data-url="{{ route('product.destroy', $product->id) }}"
                                                {{ $product->orders->count() ? 'disabled' : '' }}
                                                {{ $product->chargebacks->count() ? 'disabled' : '' }}
                                        >
                                            <i class="c-icon cil-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $products])
                @endif
            </form>
        </div>
    </div>
@endsection