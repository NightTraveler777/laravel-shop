@extends('layouts.user')

@section('title', 'Личный кабинет - Recordsman')

@section('breadcrumb-area')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="breadcrumb-title">Личный кабинет</h2>
                    <ul class="breadcrumb-list">
                        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Главная</a></li>
                        <li class="breadcrumb-item active">Личный кабинет</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
        <div class="tab-pane fade show active" id="dashboard">
            <h4>Ваши публикации</h4>
            @if (count($posts))
                <div class="table-responsive">
{{--                    table-layout: fixed;--}}
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>Наименование</th>
                                <th>Категория</th>
                                <th>Теги</th>
                                <th><i class="fa fa-eye"></i></th>
                                <th><i class="fa fa-toggle-on"></i></th>
                                <th><i class="fa fa-pencil"></i></th>
                                <th><i class="fa fa-trash"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->created_at }}</td>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->title }}</td>
                                <td>{{ $post->tags->pluck('title')->join(', ') }}</td>
                                <td>
                                    @if ($post->isVisible())
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('posts.single', ['slug' => $post->slug]) }}"
                                           title="Предварительный просмотр">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.show', ['post' => $post->id]) }}"
                                           title="Предварительный просмотр">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @if ($post->isVisible())
                                        <i class="fa fa-toggle-on text-success"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-black-50"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (!$post->isVisible())
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.edit', ['post' => $post->id]) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @else
                                        <i class="fa fa-pencil text-black-50"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (!$post->isVisible())
                                        <form action="{{ route('user.post.destroy', ['post' => $post->id]) }}" method="post" class="float-left">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <i class="fa fa-trash text-black-50"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Статей пока нет...</p>
            @endif
            {{ $posts->links() }}
        </div>
    </div>
@endsection
