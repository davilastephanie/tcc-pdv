@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Produtos</li>
    <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Categorias</a></li>
    <li class="breadcrumb-item active">Nova</li>
@endsection

@section('content')
    <form method="post" action="{{ route('category.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <strong>Categoria</strong> <small>Nova</small>
            </div>
            <div class="card-body">
                @include('category._fields')
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('category.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection