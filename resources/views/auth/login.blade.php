@extends('layouts.html')

@section('bodyClass', 'c-app flex-row align-items-center')

@section('body')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-xl-10">
                <div class="card-group">
                    <div class="card-left card p-sm-4">
                        <div class="card-body">
                            <h1>Login</h1>

                            <p class="text-muted">
                                Identifique-se abaixo.
                            </p>

                            <form method="post" action="{{ route('login') }}">
                                @csrf

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-user"></i>
                                        </div>
                                    </div>
                                    <input type="email"
                                           class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                           name="email"
                                           value="{{ old('email', request('email')) }}"
                                           placeholder="E-mail"
                                           autofocus
                                    >

                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="c-icon cil-lock-locked"></i>
                                        </div>
                                    </div>
                                    <input type="password"
                                           class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                           name="password"
                                           value="{{ old('password') }}"
                                           placeholder="Senha"
                                    >

                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4">
                                            Entrar
                                        </button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <a href="{{ route('password.request') }}" class="btn btn-link px-0">
                                            Esqueceu a senha?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer pt-4">
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

                    <div class="card-right card text-white bg-primary py-5">
                        <div class="card-body d-flex align-items-center justify-content-center text-center">
                            <div>
                                <h2>Não tem cadastro?</h2>
                                <p>
                                    Faça seu cadastro agora mesmo,
                                    <br>através do botão logo abaixo.
                                </p>
                                <a href="{{ route('register') }}" class="btn btn-lg btn-outline-light mt-3">
                                    Fazer meu cadastro
                                </a>
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
        @media (max-width: 992px) {
            .card-group {
                flex-flow: column;
                flex-wrap: wrap;
                margin: 15px auto;
            }

            .card-group .card {
                border-radius: 0.25rem !important;
                width: 100%;
            }

            .card-left {
                margin-bottom: 15px !important;
            }
        }
    </style>
@endpush