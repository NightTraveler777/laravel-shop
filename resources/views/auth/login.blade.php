@extends('layouts.auth')

@section('title', 'Авторизация - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Авторизация</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Авторизация</li>
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
                    <form action="{{ route('auth.login') }}" method="post">
                        @csrf
                        <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}">
                        <input type="password" name="password" class="form-control" placeholder="Пароль">
                        <div class="button-box">
                            <div class="login-toggle-btn">
                                <input type="checkbox" name="remember">
                                <a class="flote-none" href="javascript:void(0)">Запомнить меня</a>
                                <a href="{{ route('auth.forgot-form') }}">Забыли пароль?</a>
                            </div>
                            <button type="submit"><span>Авторизация</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
