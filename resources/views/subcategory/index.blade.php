@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Produtos</li>
    <li class="breadcrumb-item"><a href="{{ route('subcategory.index') }}">Subcategorias</a></li>
    <li class="breadcrumb-item active">Todas</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-tags mr-1"></i> Subcategorias
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('subcategory.create') }}" class="btn btn-primary btn-icon">
                                <i class="c-icon cil-plus"></i> Nova subcategoria
                            </a>
                            <a href="{{ route('subcategory.export') }}" class="btn btn-dark btn-icon">
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

                @if ($subcategories->count() == 0)
                    <h5 class="my-3">Nenhuma subcategoria encontrada.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th>@linkOrderby(['label' => 'Nome', 'key' => 'name'])</th>
                                <th>@linkOrderby(['label' => 'Categoria', 'key' => 'category_name'])</th>
                                <th style="width: 1px;">@linkOrderby(['label' => 'Ativo', 'key' => 'active'])</th>
                                <th style="width: 1px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($subcategories as $subcategory)
                                <tr>
                                    <td>
                                        <a href="{{ route('subcategory.edit', $subcategory->id) }}">
                                            {{ $subcategory->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $subcategory->category->name }}
                                        <a href="{{ route('category.edit', $subcategory->category->id) }}"
                                           target="_blank"
                                           title="Editar categoria"
                                           data-toggle="tooltip"
                                        >
                                            <i class="c-icon cil-external-link c-icon-sm ml-1"></i>
                                        </a>
                                    </td>
                                    <td class="text-nowrap">
                                        <label class="c-switch c-switch-label c-switch-opposite-success">
                                            <input type="checkbox"
                                                   class="c-switch-input js-toggle-active"
                                                   data-url="{{ route('subcategory.update', $subcategory->id) }}"
                                                    {{ $subcategory->active ? 'checked' : '' }}
                                            >
                                            <span class="c-switch-slider"
                                                  data-checked="✓"
                                                  data-unchecked="✕"
                                            ></span>
                                        </label>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('subcategory.edit', $subcategory->id) }}"
                                           class="btn btn-sm btn-outline-success btn-icon"
                                        >
                                            <i class="c-icon cil-pencil"></i> Editar
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-icon js-destroy-confirm"
                                                data-url="{{ route('subcategory.destroy', $subcategory->id) }}"
                                                {{ $subcategory->category ? 'disabled' : '' }}
                                                {{ $subcategory->products->count() ? 'disabled' : '' }}
                                        >
                                            <i class="c-icon cil-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $subcategories])
                @endif
            </form>
        </div>
    </div>
@endsection