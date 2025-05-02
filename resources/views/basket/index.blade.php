@extends('layouts.shop-layout')

@section('title', 'Корзина - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Ваша корзина</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Ваша корзина</li>
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
                @if (count($albums))
                    @php
                        $basketCost = 0;
                    @endphp
                    <table class="table table-bordered">
                        <tr>
                            <th>№</th>
                            <th>Наименование</th>
                            <th>Цена</th>
                            <th>Кол-во</th>
                            <th>Стоимость</th>
                        </tr>
                        @foreach($albums as $album)
                            @php
                                $itemPrice = $album->price;
                                $itemQuantity =  $album->pivot->quantity;
                                $itemCost = $itemPrice * $itemQuantity;
                                $basketCost = $basketCost + $itemCost;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <a href="{{ route('shop.album', [$album->slug]) }}">{{ $album->name }}</a>
                                </td>
                                <td>{{ number_format($itemPrice, 2, '.', '') }}</td>
                                <td>
                                    <i class="fas fa-minus-square"></i>
                                    <span class="mx-1">{{ $itemQuantity }}</span>
                                    <i class="fas fa-plus-square"></i>
                                </td>
                                <td>{{ number_format($itemCost, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <th colspan="4" class="text-right">Итого</th>
                            <th>{{ number_format($basketCost, 2, '.', '') }}</th>
                        </tr>
                    </table>
                @else
                    <p>Ваша корзина пуста</p>
                @endif
            </div>
        </div>
    </div>
@endsection
