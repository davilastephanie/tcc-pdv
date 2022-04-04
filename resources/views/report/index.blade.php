@extends('layouts.app')

@section('breadcrumb')
    <li class="breadcrumb-item active">Relatórios</li>
@endsection

@section('content')
    <div class="row">

        @foreach ($items as $group => $modules)
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-header">
                        <strong>{{ $group }}</strong>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($modules as $prefix => $props)
                                <a href="{{ $props['url'] }}" class="list-group-item list-group-item-action">
                                    <span><i class="c-icon {{ $props['icon'] }} mr-2"></i> Exportar {{ $props['title'] }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
