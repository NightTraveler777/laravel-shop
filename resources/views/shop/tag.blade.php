@extends('layouts.shop-layout')

@section('title', 'Маркетплейс - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Каталог альбомов</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('shop.index') }}">Каталог альбомов</a></li>
                        <li class="breadcrumb-item active">Тег: {{ $tag->title }}</li>
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
                <div class="row">
                    <div class="col-12">
                        <div class="section-title text-center">
                            <h1>Тег: {{ $tag->title }}</h1>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="row mb-n-30px">
                            @foreach ($albums as $album)
                                <div class="col-lg-6 col-xl-3 col-md-6 col-sm-6 col-xs-6 mb-30px">
                                    <div class="product">
                                        <div class="thumb">
                                            <a href="{{ route('shop.album', ['slug' => $album->slug]) }}" class="image">
                                                <img src="{{ asset("/storage/{$album->images['cover']['full']}") }}" alt="Product" />
                                                <img class="hover-image" src="{{ asset("/storage/{$album->images['cover']['full']}") }}" alt="Product" />
                                            </a>
                                        </div>
                                        <div class="format-wrap">
                                            @foreach ($album->format as $key => $value)
                                                <p class="format">
                                                    {{ $album->format[$key]['name'] }}
                                                </p>
                                            @endforeach
                                        </div>
                                        <div class="content">
                                            <span class="category">
                                                <a href="{{ route('shop.genre', ['slug' => $album->genre->slug]) }}">{{ $album->genre->name }}</a>
                                            </span>
                                            <h4>
                                                @foreach($album->artists as $artist)
                                                    <a href="{{ route('shop.artist', ['slug' => $artist->slug]) }}">{{ $artist->name }}</a>@if (!$loop->last), @endif
                                                @endforeach
                                            </h4>
                                            <h5>
                                                <a href="{{ route('shop.album', ['slug' => $album->slug]) }}">
                                                    {{ $album->name }}
                                                </a>
                                            </h5>
                                            <h6>
                                                <a href="{{ route('shop.label', ['slug' => $album->label->slug]) }}">
                                                    {{ $album->label->name }}
                                                </a>
                                            </h6>
                                        </div>
                                        <a class="btn" href="{{ route('shop.album', ['slug' => $album->slug]) }}">Подробнее</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pro-pagination-style text-center mt-0 mb-0" data-aos="fade-up" data-aos-delay="200">
            <div class="pages">
                {{ $albums->links('vendor.pagination.bootstrap-4-custom') }}
            </div>
        </div>
    </div>
@endsection
