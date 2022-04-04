@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Produtos</li>
    <li class="breadcrumb-item"><a href="{{ route('subcategory.index') }}">Subcategorias</a></li>
    <li class="breadcrumb-item active">Nova</li>
@endsection

@section('content')
    <form method="post" action="{{ route('subcategory.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <strong>Subcategoria</strong> <small>Nova</small>
            </div>
            <div class="card-body">
                @include('subcategory._fields')
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('subcategory.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection