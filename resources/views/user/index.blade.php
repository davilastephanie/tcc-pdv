@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Administrativo</li>
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuários</a></li>
    <li class="breadcrumb-item active">Todos</li>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <i class="c-icon cil-user mr-1"></i> Usuários
        </div>
        <div class="card-body">
            <form method="get">
                <input type="hidden" name="order_by" value="{{ request('order_by') }}">

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <a href="{{ route('user.create') }}" class="btn btn-primary btn-icon">
                                <i class="c-icon cil-plus"></i> Novo usuário
                            </a>
                            <a href="{{ route('user.export') }}" class="btn btn-dark btn-icon">
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

                @if ($users->count() == 0)
                    <h5 class="my-3">Nenhum usuário encontrado.</h5>
                @else
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-records">
                            <thead class="bg-dark">
                            <tr class="text-nowrap">
                                <th>@linkOrderby(['label' => 'Nome', 'key' => 'name'])</th>
                                <th>@linkOrderby(['label' => 'E-mail', 'key' => 'email'])</th>
                                <th style="width: 140px;">@linkOrderby(['label' => 'Perfil', 'key' => 'role_name'])</th>
                                <th style="width: 1px;">@linkOrderby(['label' => 'Ativo', 'key' => 'active'])</th>
                                <th style="width: 1px;"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        <a href="{{ route('user.edit', $user->id) }}">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        {{ $user->role_name }}
                                    </td>
                                    <td class="text-nowrap">
                                        <label class="c-switch c-switch-label c-switch-opposite-success">
                                            <input type="checkbox"
                                                   class="c-switch-input js-toggle-active"
                                                   data-url="{{ route('user.update', $user->id) }}"
                                                   {{ $user->active ? 'checked' : '' }}
                                                   {{ $user->email == 'admin@admin.com.br' ? 'disabled' : '' }}
                                                   {{ $user->id == auth()->id() ? 'disabled' : '' }}
                                            >
                                            <span class="c-switch-slider"
                                                  data-checked="✓"
                                                  data-unchecked="✕"
                                            ></span>
                                        </label>
                                    </td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('user.edit', $user->id) }}"
                                           class="btn btn-sm btn-outline-success btn-icon"
                                        >
                                            <i class="c-icon cil-pencil"></i> Editar
                                        </a>
                                        <button type="button"
                                                class="btn btn-sm btn-outline-danger btn-icon js-destroy-confirm"
                                                data-url="{{ route('user.destroy', $user->id) }}"
                                                {{ $user->email == 'admin@admin.com.br' ? 'disabled' : '' }}
                                                {{ $user->id == auth()->id() ? 'disabled' : '' }}
                                                {{ $user->stocks->count() ? 'disabled' : '' }}
                                                {{ $user->orders->count() ? 'disabled' : '' }}
                                                {{ $user->chargebacks->count() ? 'disabled' : '' }}
                                        >
                                            <i class="c-icon cil-trash"></i> Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    @paginate(['items' => $users])
                @endif
            </form>
        </div>
    </div>
@endsection