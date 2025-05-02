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
            <h4>Ваши альбомы</h4>
            @if (count($albums))
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Дата</th>
                            <th>Наименование</th>
                            <th>Жанр</th>
{{--                            <th>Теги</th>--}}
                            <th><i class="fa fa-eye"></i></th>
                            <th><i class="fa fa-toggle-on"></i></th>
                            <th><i class="fa fa-pencil"></i></th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($albums as $album)
{{--                            <pre>{{ var_dump($album) }}</pre>--}}
                            <tr>
                                <td>{{ $album->created_at }}</td>
                                <td>{{ $album->name }}</td>
                                <td>{{ $album->genre->name }}</td>
{{--                                <td>{{ $album->tags->pluck('title')->join(', ') }}</td>--}}
                                <td>
                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('posts.single', ['slug' => $album->slug]) }}"
                                       title="Предварительный просмотр">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    {{--@if ($album->isVisible())
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('posts.single', ['slug' => $album->slug]) }}"
                                           title="Предварительный просмотр">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @else
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.show', ['post' => $album->id]) }}"
                                           title="Предварительный просмотр">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif--}}
                                </td>
                                <td>
                                    <i class="fa fa-toggle-on text-success"></i>
                                    {{--@if ($album->isVisible())
                                        <i class="fa fa-toggle-on text-success"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-black-50"></i>
                                    @endif--}}
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.edit', ['post' => $album->id]) }}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    {{--@if (!$album->isVisible())
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.post.edit', ['post' => $album->id]) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @else
                                        <i class="fa fa-pencil text-black-50"></i>
                                    @endif--}}
                                </td>
                                <td>
                                    <form action="{{ route('user.post.destroy', ['post' => $album->id]) }}" method="post" class="float-left">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                    {{--@if (!$album->isVisible())
                                        <form action="{{ route('user.post.destroy', ['post' => $album->id]) }}" method="post" class="float-left">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <i class="fa fa-trash text-black-50"></i>
                                    @endif--}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>Статей пока нет...</p>
            @endif
            {{ $albums->links() }}
        </div>
    </div>
@endsection
