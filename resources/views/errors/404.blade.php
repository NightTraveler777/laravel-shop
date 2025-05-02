@extends('layouts.main')

@section('title', 'Страница не найдена - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Страница не найдена</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Страница не найдена</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="section-404 section" data-bg-image="{{ asset('assets/front/images/404/bg-404-2.jpg') }}">
        <div class="container">
            <div class="content-404">
                <h1 class="title">Ошибка 404!</h1>
                <h2 class="sub-title">Страница не найдена!</h2>
                <p>Вы можете вернуться назад или перейти на главную страницу</p>
                <div class="buttons">
                    <a class="btn btn-primary btn-outline-hover-dark" href="{{ url()->previous() }}">Назад</a>
                    <a class="btn btn-dark btn-outline-hover-dark" href="{{ route('home.index') }}">На главную</a>
                </div>
            </div>
        </div>
    </div>
@endsection
