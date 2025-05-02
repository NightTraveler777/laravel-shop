@extends('layouts.layout')

@section('title', $category->title . 'Блог - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Блог</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('posts.list') }}">Блог</a></li>
                        <li class="breadcrumb-item active">{{ $category->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        @foreach($posts as $post)
            <div class="col-12 mb-50px">
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
                                <a class="blog-author" href="{{ route('categories.single', ['slug' => $category->slug]) }}">
                                    <i class="fa fa-list" aria-hidden="true"></i> {{ $category->title }}
                                </a>
                            </span>
                            <span>
                                <a class="blog-author" href="{{ route('author.single', ['user' => $post->user->id]) }}">
                                    <i class="fa fa-user" aria-hidden="true"></i> {{ $post->user->name }}
                                </a>
                            </span>
                            <span>
                                <i class="fa fa-eye" aria-hidden="true"></i> {{ $post->views }}</span>
                        </div>
                        <h5 class="blog-heading">
                            <a class="blog-heading-link" href="{{ route('posts.single', ['slug' => $post->slug]) }}">
                                {{ $post->title }}
                            </a>
                        </h5>
                        {!! $post->description !!}
                        <a href="{{ route('posts.single', ['slug' => $post->slug]) }}" class="btn btn-primary blog-btn"> Далее</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pro-pagination-style text-center mt-0 mb-0" data-aos="fade-up" data-aos-delay="200">
        <div class="pages">
            {{ $posts->links('vendor.pagination.bootstrap-4-custom') }}
        </div>
    </div>
@endsection
