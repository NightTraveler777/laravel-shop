@extends('layouts.shop-layout')

@section('title', 'Оформление заказа - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Оформление заказа</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Оформление заказа</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-lg-8 order-lg-last col-md-12 order-md-first">
        <div class="product-area mb-30px">
            <div class="container">

            </div>
        </div>
    </div>
@endsection
