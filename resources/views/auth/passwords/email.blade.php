@extends('layouts.html')

@section('bodyClass', 'c-app flex-row align-items-center')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card p-sm-4">
                    <div class="card-body">
                        <h3>Recuperar senha</h3>

                        <p class="text-muted">
                            Você receberá um link para criar uma nova senha via e-mail.
                        </p>

                        <form method="post" action="{{ route('password.email') }}">
                            @csrf

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="c-icon cil-user"></i>
                                    </div>
                                </div>
                                <input type="email"
                                       class="form-control @isInvalid(['key' => 'email'])"
                                       name="email"
                                       value="{{ old('email') }}"
                                       placeholder="E-mail"
                                       autofocus
                                >
                                @invalidFeedback(['key' => 'email'])
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-primary px-4">
                                        Obter nova senha
                                    </button>
                                </div>
                                <div class="col-6 text-right">
                                    <a href="{{ route('login') }}" class="btn btn-link px-0">
                                        Login
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
