@extends('layouts.shop-product-layout')

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
                        <li class="breadcrumb-item active">Альбом: {{ $album->name }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="col-lg-6 col-sm-12 col-xs-12 mb-lm-30px mb-md-30px mb-sm-30px">
        <div class="swiper-container zoom-top">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="{{ asset("/storage/{$album->images['cover']['full']}") }}" alt="">
                    <a class="venobox full-preview" data-gall="myGallery" href="{{ asset("/storage/{$album->images['cover']['full']}") }}">
                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                    </a>
                </div>
                @foreach ($album->images['other'] as $image)
                    <div class="swiper-slide">
                        <img class="img-responsive m-auto" src="{{ asset("/storage/{$image['full']}") }}" alt="">
                        <a class="venobox full-preview" data-gall="myGallery" href="{{ asset("/storage/{$image['full']}") }}">
                            <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="swiper-container mt-20px zoom-thumbs slider-nav-style-1 small-nav">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img class="img-responsive m-auto" src="{{ asset("/storage/{$album->images['cover']['min']}") }}" alt="">
                </div>
                @foreach ($album->images['other'] as $image)
                    <div class="swiper-slide">
                        <img class="img-responsive m-auto" src="{{ asset("/storage/{$image['min']}") }}" alt="">
                    </div>
                @endforeach
            </div>
            <!-- Add Arrows -->
            <div class="swiper-buttons">
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-sm-12 col-xs-12" data-aos="fade-up" data-aos-delay="200">
        <div class="product-details-content quickview-content ml-25px">
            <h2>
                @foreach($album->artists as $artist)
                    <a href="{{ route('shop.artist', ['slug' => $artist->slug]) }}">{{ $artist->name }}</a>@if (!$loop->last), @endif
                @endforeach
            </h2>
            <h3>{{ $album->name }}</h3>
            <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                <span>Жанр:</span>
                <ul class="d-flex">
                    <li>
                        <a href="{{ route('shop.genre', ['slug' => $album->genre->slug]) }}">
                            {{ $album->genre->name }}
                        </a>
                    </li>
                </ul>
            </div>
            <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                <span>Лейбл:</span>
                <ul class="d-flex">
                    <li>
                        <a href="{{ route('shop.label', ['slug' => $album->label->slug]) }}">
                            {{ $album->label->name }}
                        </a>
                    </li>
                </ul>
            </div>

            @if($album->tags()->count())
                <div class="pro-details-categories-info pro-details-same-style d-flex m-0">
                    <span>Теги: </span>
                    <ul class="d-flex">
                        @foreach($album->tags as $tag)
                            <li><a href="{{ route('shop.tag', ['slug' => $tag->slug]) }}">{{ $tag->title }}</a></li>@if (!$loop->last), @endif
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="pro-details-categories-info pro-details-same-style m-0">
                <div class="description-review-wrapper">
                    <div class="description-review-topbar nav">
                        @foreach ($album->format as $key => $value)
                            @if(count($album->format[$key]['format']))
                                <button @if (!$first) class="active" @php $first = true; @endphp @endif data-bs-toggle="tab" data-bs-target="#des-{{ $key }}">{{ $album->format[$key]['name'] }}</button>
                            @endif
                        @endforeach
                        @empty(!$album->description)
                            <button data-bs-toggle="tab" data-bs-target="#des-description">Описание</button>
                        @endempty
                    </div>
                    <div class="tab-content description-review-bottom">
                        @php $first = false; @endphp
                        @foreach ($album->format as $key => $value)
                            @if(count($album->format[$key]['format']))
                                <div id="des-{{ $key }}" class="tab-pane @if (!$first) active @php $first = true; @endphp @endif">
                                @foreach ($album->format[$key]['format'] as $k => $v)
                                    <div class="product-anotherinfo-wrapper text-start">
                                        <div class="product-format-price">
                                            <h4>
                                                <span>{{ $album->format[$key]['format'][$k]['name'] }}</span>
                                            </h4>
                                            <p class="price">{{ $album->format[$key]['format'][$k]['price'] }} ₽</p>

                                            <form action="{{ route('basket.add', ['id' => $album->id]) }}"
                                                  method="post" class="form-inline">
                                                @csrf
                                                <div class="pro-details-quality">
                                                    <label for="input-quantity"></label>
                                                    <div class="cart-plus-minus">
                                                        <div class="dec qtybutton">-</div>
                                                        <input id="input-quantity" class="cart-plus-minus-box" type="text" name="quantity" value="1">
                                                        <div class="inc qtybutton">+</div>
                                                    </div>
                                                    <div class="pro-details-cart">
                                                        <button type="submit" class="btn btn-success add-cart">В корзину</button>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                        @empty(!$album->format[$key]['format'][$k]['description'])
                                            <div class="product-format-description">
                                                {!! $album->format[$key]['format'][$k]['description'] !!}
                                            </div>
                                        @endempty
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        @endforeach
                        @empty(!$album->description)
                            <div id="des-description" class="tab-pane">
                                <div class="product-description-wrapper">
                                    {!! $album->description !!}
                                </div>
                            </div>
                        @endempty
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12 col-sm-12 col-xs-12 mt-30px wrap-tracklist" data-aos="fade-up" data-aos-delay="200">
        @empty(!$album->tracklist)
            {!! $album->tracklist !!}
        @endempty
        {{--<h3>Список треков</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-hover tracklist">
                <thead>
                    <tr>
                        <th><i class="fa fa-play"></i></th>
                        <th>#</th>
                        <th>Название</th>
                        <th>Артисты</th>
                        <th>Длительность</th>
                        @foreach ($tracks as $track)
                            @foreach ($track->format as $key => $value)
                                @if(isset($track->format[$key]) && !Arr::exists($formats, $key))
                                    @php $formats = Arr::add($formats, $key, $track->format[$key]['name']); @endphp
                                    <th colspan="2">{{ $track->format[$key]['name'] }}</th>
                                @endif
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tracks as $track)
                        <tr>
                            <td><i class="fa fa-play"></i></td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $track->name }}</td>
                            <td>
                                @foreach($track->artists as $artist)
                                    <a href="{{ route('shop.artist', ['slug' => $artist->slug]) }}">{{ $artist->name }}</a>@if (!$loop->last), @endif
                                @endforeach
                            </td>
                            <td>{{ seconds_to_words($track->length) }}</td>
                            @foreach ($track->format as $key => $value)
                                @isset($track->format[$key])
                                    <td>{{ $track->format[$key]['price'] }} ₽</td>
                                    <td><i class="fa fa-shopping-basket"></i></td>
                                @endisset
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>--}}
    </div>

    {{--<audio controls>
        <source src="{{ asset("/storage/albums/serenitatis/tracks/mp3/track1.mp3") }}" type="audio/mpeg">
        <source src="{{ asset("/storage/albums/serenitatis/tracks/mp3/track2.mp3") }}" type="audio/mpeg">
    </audio>--}}
@endsection
