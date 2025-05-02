<!DOCTYPE html>
<html lang="zxx" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recordsman</title>
{{--    <title>@yield('title')</title>--}}
    <meta name="robots" content="index, follow" />
    <meta name="description" content="">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front/images/favicon.ico') }}" />
    <link rel="stylesheet" href="{{ asset('assets/front/css/front.css') }}">
</head>

<body>
<div class="main-wrapper">
    @include('layouts.header')
    <div class="product-area pt-50px pb-50px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title text-center">
                        <h2 class="title">Последние альбомы</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row mb-n-30px">
                        @foreach ($albums as $album)
                            <div class="col-lg-4 col-xl-2 col-md-6 col-sm-6 col-xs-6 mb-30px">
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
    <div class="main-blog-area pb-100px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center mb-30px0px">
                        <h2 class="title">Последние посты</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-lg-6 col-sm-6 mb-30px">
                    <div class="single-blog">
                        <div class="blog-image">
                            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}">
                                <img src="{{ $post->getImage() }}" class="img-responsive w-100" alt="">
                            </a>
                        </div>
                        <div class="blog-text">
                            <div class="blog-athor-date line-height-1">
                                <span class="blog-date">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->getPostDate() }}
                                </span>
                                <span>
                                    <a class="blog-author" href="{{ route('author.single', ['user' => $post->user->id]) }}">
                                        <i class="fa fa-user" aria-hidden="true"></i> {{ $post->user->name }}
                                    </a>
                                </span>
                            </div>
                            <h5 class="blog-heading">
                                <a class="blog-heading-link" href="{{ route('posts.single', ['slug' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            {!! Str::limit($post->description, 200, ' (...)') !!}
                            <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" class="btn btn-primary blog-btn mt-30px"> Далее</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
<script src="{{ asset('assets/front/js/front.js') }}"></script>
</body>

</html>
