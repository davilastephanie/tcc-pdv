@extends('layouts.email')

@section('content')
    <p>
        <strong>Prezado(a) {{ $user->name }}</strong>,
    </p>

    <p>
        Recebemos uma solicitação para redefinir a senha da sua conta.
    </p>

    @include('emails.parts.button', [
        'link'  => route('password.reset', [$token, 'email' => $user->email]),
        'label' => 'REDEFINIR SENHA'
    ])

    <p style="color: darkred;">
        <small>*Caso não tenha feito nenhuma solicitação, ignore este e-mail.</small>
    </p>
@endsection