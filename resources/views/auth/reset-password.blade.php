@extends('layouts.auth')

@section('title', 'Восстановление пароля - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Восстановление пароля</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Восстановление пароля</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="login-form-container">
                <div class="login-register-form">
                    <form action="{{ route('auth.reset-password') }}" method="post">
                        @csrf
                        <input type="hidden" name="email" value="{{ $email }}">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <input type="password" name="password" class="form-control" placeholder="Пароль">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Повторите пароль">
                        <div class="button-box">
                            <button type="submit"><span>Сбросить</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
