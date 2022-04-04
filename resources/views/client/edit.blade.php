@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Administrativo</li>
    <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Clientes</a></li>
    <li class="breadcrumb-item active">Editar</li>
@endsection

@section('content')
    <form method="post" action="{{ route('client.update', $client->id) }}">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-header">
                <strong>Cliente</strong> <small>Editar</small>

                <div class="card-header-actions">
                    <a href="{{ route('client.create') }}"
                       class="card-header-action"
                       title="Novo cliente"
                       data-toggle="tooltip"
                    >
                        <i class="c-icon cil-plus"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                @include('client._fields')
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('client.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection