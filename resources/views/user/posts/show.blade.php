@extends('layouts.layout')

@section('title', $post->title . ' - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Блог</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('posts.list') }}">Блог</a></li>
                        <li class="breadcrumb-item active">{{ $post->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="blog-posts">
        <div class="single-blog-post blog-grid-post">
            <div class="blog-image single-blog">
                <img class="img-fluid h-auto border-radius-10px" src="{{ $post->getImage() }}" alt="blog" />
            </div>
            <div class="blog-post-content-inner mt-30px">
                <div class="blog-athor-date">
                    <span class="blog-date">
                        <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $post->getPostDate() }}
                    </span>
                    <span>
                        <a class="blog-author" href="{{ route('categories.single', ['slug' => $post->category->slug]) }}">
                            <i class="fa fa-list" aria-hidden="true"></i> {{ $post->category->title }}
                        </a>
                    </span>
                    <span>
                        <a class="blog-author" href="{{ route('author.single', ['user' => $post->user->id]) }}">
                            <i class="fa fa-user" aria-hidden="true"></i> {{ $post->user->name }}
                        </a>
                    </span>
                    <span>
                        <i class="fa fa-eye" aria-hidden="true"></i> {{ $post->views }}
                    </span>
                </div>
                <h4 class="blog-title">
                    @if ( ! $post->isVisible())
                        <i class="fa fa-eye-slash text-danger" title="Предварительный просмотр"></i>
                    @else
                        <i class="fa fa-eye text-success" title="Этот пост опубликован"></i>
                    @endif
                    {{ $post->title }}
                </h4>
            </div>
            <div class="single-post-content">
                <p data-aos="fade-up" data-aos-delay="200">
                    @perm('manage-posts')
                    {!! $post->content !!}
                    @else
                        {!! $post->description !!}
                        @endperm
                </p>
            </div>
        </div>
    </div>
    <div class="blog-single-tags-share d-md-flex justify-content-between">
        @if($post->tags()->count())
            <div class="blog-single-tags d-flex" data-aos="fade-up" data-aos-delay="200">
                <span class="title">Теги:</span>
                <ul class="tag-list">
                    @foreach($post->tags as $tag)
                        <li><a href="{{ route('tags.single', ['slug' => $tag->slug]) }}">{{ $tag->title }}</a></li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="blog-single-share mb-xs-15px d-flex align-items-center" data-aos="fade-up" data-aos-delay="200">
            <span class="title">Share:</span>
            @if (!$post->isVisible())
                <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.edit', ['post' => $post->id]) }}">
                    <i class="fa fa-pencil"></i>
                </a>
                <form action="{{ route('user.post.destroy', ['post' => $post->id]) }}" method="post" class="float-left">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                        <i class="fa fa-trash"></i>
                    </button>
                </form>
            @endif
        </div>
    </div>
    <div class="blog-nav">
        <div class="blog-nav-wrap">
            <div class="nav-left d-flex justify-content-start align-items-center">
                @isset($previous_post)
                    <a class="nav-img" href="{{ route('posts.single', ['slug' => $previous_post->slug]) }}">
                        <img src="{{ $previous_post->getImage() }}" alt="" width="100" height="100" />
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <div class="media-side">
                        <span class="date">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $previous_post->getPostDate() }}
                        </span>
                        <h5>
                            <a href="{{ route('posts.single', ['slug' => $previous_post->slug]) }}">{{ $previous_post->title }}</a>
                        </h5>
                    </div>
                @endisset
            </div>
            <div class="nav-right d-flex justify-content-end flex-row-reverse align-items-center">
                @isset($next_post)
                    <a class="nav-img" href="{{ route('posts.single', ['slug' => $next_post->slug]) }}">
                        <img src="{{ $next_post->getImage() }}" alt="" width="100" height="100" />
                        <i class="fa fa-angle-right"></i>
                    </a>
                    <div class="media-side">
                        <span class="date">
                            <i class="fa fa-clock-o" aria-hidden="true"></i> {{ $next_post->getPostDate() }}
                        </span>
                        <h5>
                            <a href="{{ route('posts.single', ['slug' => $next_post->slug]) }}">{{ $next_post->title }}</a>
                        </h5>
                    </div>
                @endisset
            </div>
        </div>
    </div>
    @isset($comments)
        @include('user.posts.comments', ['comments' => $comments])
    @endisset
@endsection
