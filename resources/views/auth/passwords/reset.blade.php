@extends('layouts.html')

@section('bodyClass', 'c-app flex-row align-items-center')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-6">
                <div class="card p-sm-4">
                    <div class="card-body">
                        <h3>Redefinir senha</h3>

                        <p class="text-muted">
                            Informe a nova senha para concluir sua solicitação.
                        </p>

                        <form method="post" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="c-icon cil-user"></i>
                                    </div>
                                </div>
                                <input type="email"
                                       class="form-control @isInvalid(['key' => 'email'])"
                                       name="email"
                                       value="{{ $email ?? old('email') }}"
                                       placeholder="E-mail"
                                >
                                @invalidFeedback(['key' => 'email'])
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-lock-locked"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                           class="form-control @isInvalid(['key' => 'password'])"
                                           name="password"
                                           value="{{ old('password') }}"
                                           placeholder="Senha"
                                           autofocus
                                    >
                                    @invalidFeedback(['key' => 'password'])
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-lock-locked"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                           class="form-control @isInvalid(['key' => 'password_confirmation'])"
                                           name="password_confirmation"
                                           placeholder="Senha confirmação"
                                    >
                                    @invalidFeedback(['key' => 'password_confirmation'])
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                Redefinir
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
