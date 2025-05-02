@extends('layouts.auth')

@section('title', 'Регистрация - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Регистрация</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Регистрация</li>
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
                    <form action="{{ route('auth.register') }}" method="post">
                        @csrf
                        <input type="text" name="name" class="form-control" placeholder="Имя" value="{{ old('name') }}">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                               value="{{ old('email') }}">
                        <input type="password" name="password" class="form-control" placeholder="Пароль">
                        <input type="password" name="password_confirmation" class="form-control"
                               placeholder="Повторите пароль">
                        <div class="button-box">
                            <div class="login-toggle-btn">
                                <button type="submit"><span>Регистрация</span></button>
                                <a href="{{ route('auth.login') }}" class="text-center">Я уже зарегистрирован</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
