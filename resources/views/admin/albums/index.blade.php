@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Альбомы</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Список альбомов</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('albums.create') }}" class="btn btn-primary mb-3">Добавить альбом</a>
                            @if (count($albums))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">#</th>
                                                <th>Наименование</th>
                                                <th>Автор публикации</th>
                                                <th>Жанр</th>
                                                <th>Теги</th>
                                                <th>Дата</th>
                                                <th><i class="fa fa-eye"></i></th>
                                                <th><i class="fa fa-toggle-on"></i></th>
                                                <th><i class="fa fa-pencil-alt"></i></th>
                                                <th><i class="fa fa-trash-alt"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($albums as $album)
                                            <tr>
                                                <td>{{ $album->id }}</td>
                                                <td>{{ $album->name }}</td>
                                                <td>{{ $album->profile->user->name }}</td>
                                                <td>{{ $album->genre->name }}</td>
                                                <td>{{ $album->tags->pluck('title')->join(', ') }}</td>
                                                <td>{{ $album->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('shop.album', ['slug' => $album->slug]) }}"
                                                       title="Просмотр" target="_blank">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <i class="fa fa-toggle-on text-success"></i>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('albums.edit', ['album' => $album->id]) }}">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('albums.destroy', ['album' => $album->id]) }}" method="post" class="float-left">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-primary btn-sm blog-btn" onclick="return confirm('Подтвердите удаление')">
                                                            <i class="fa fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>Альбомов пока нет...</p>
                            @endif
                        </div>
                        <div class="card-footer clearfix">
                            {{ $albums->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
