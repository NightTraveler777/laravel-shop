@extends('layouts.auth')

@section('title', 'Подтверждение адреса почты - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Подтверждение email</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Подтверждение email</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <p>
        Вам на почту было отправлено письмо. Для подтверждения адреса почты необходимо перейти
        по ссылке, которая будет в письме. Если в течение часа этого не произойдет — аккаунт
        будет удален. Но всегда можно зарегистрироваться еще раз.
    </p>
@endsection
