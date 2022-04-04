@extends('layouts.html')

@section('bodyClass', 'c-app flex-row align-items-center')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-6">
                <div class="card">
                    <form method="post" action="{{ route('register') }}">
                        @csrf

                        <div class="card-body p-4">
                            <h1>Cadastro</h1>

                            <p class="text-muted">Preencha todos os campos abaixo.</p>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-user"></i>
                                        </div>
                                    </div>
                                    <input type="text"
                                           class="form-control @isInvalid(['key' => 'name'])"
                                           name="name"
                                           value="{{ old('name') }}"
                                           placeholder="Nome"
                                           autofocus=""
                                    >
                                    @invalidFeedback(['key' => 'name'])
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-envelope-open"></i>
                                        </div>
                                    </div>
                                    <input type="email"
                                           class="form-control @isInvalid(['key' => 'email'])"
                                           name="email"
                                           value="{{ old('email') }}"
                                           placeholder="E-mail"
                                    >
                                    @invalidFeedback(['key' => 'email'])
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-phone"></i>
                                        </div>
                                    </div>
                                    <input type="text"
                                           class="form-control @isInvalid(['key' => 'phone'])"
                                           name="phone"
                                           value="{{ old('phone') }}"
                                           placeholder="Telefone"
                                           data-input-mask="phone"
                                    >
                                    @invalidFeedback(['key' => 'phone'])
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
                                           class="form-control @isInvalid(['key' => 'password'])"
                                           name="password"
                                           value="{{ old('password') }}"
                                           placeholder="Senha"
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

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary px-4">
                                            Confirmar
                                        </button>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="form-group">
                                        <a href="{{ route('login') }}" class="btn btn-link px-0">
                                            Já tem cadastro?
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="card-footer py-4">
                        <div class="row">
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <a href="{{ route('socialite.google-redirect') }}" class="btn btn-block btn-google">
                                        <span>Entrar com Google</span>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6">
                                <div class="form-group">
                                    <a href="{{ route('socialite.facebook-redirect') }}" class="btn btn-block btn-facebook">
                                        <span>Entrar com Facebook</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .card-body,
        .card-footer {
            padding-bottom: 10px !important;
        }

        @media (max-width: 578px) {
            .btn-primary {
                display: block;
                width: 100%;
            }
        }
    </style>
@endpush