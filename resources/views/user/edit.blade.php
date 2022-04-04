@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Administrativo</li>
    <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Usuários</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <form method="post" action="{{ route('user.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <strong>Usuário</strong> <small>Editar</small>

                <div class="card-header-actions">
                    <a href="{{ route('user.create') }}"
                       class="card-header-action"
                       title="Novo usuário"
                       data-toggle="tooltip"
                    >
                        <i class="c-icon cil-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('user._fields')
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('user.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection