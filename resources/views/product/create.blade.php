@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item">Produtos</li>
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">Produtos</a></li>
    <li class="breadcrumb-item active">Novo</li>
@endsection

@section('content')
    <form method="post" action="{{ route('product.store') }}">
        @csrf

        <div class="card">
            <div class="card-header">
                <strong>Produto</strong> <small>Novo</small>
            </div>
            <div class="card-body">
                @include('product._fields')
            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-icon">
                    <i class="c-icon cil-check-alt"></i> Salvar
                </button>
                <a href="@urlBack(['default' => route('product.index')])" class="btn btn-outline-danger btn-icon">
                    <i class="c-icon cil-x"></i> Cancelar
                </a>
            </div>
        </div>
    </form>
@endsection