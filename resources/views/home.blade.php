@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">{{ env('APP_NAME') }}</div>
        <div class="card-body">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="display-3">{{ auth()->user()->name }}</h1>
                    <p class="lead">
                        Seja bem-vindo!
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
