@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Жанры</h1>
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
                            <h3 class="card-title">Список жанров</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('genres.create') }}" class="btn btn-primary mb-3">Добавить жанр</a>
                            @if (count($genres))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Наименование</th>
                                            <th>Slug</th>
                                            <th><i class="fa fa-pencil-alt"></i></th>
                                            <th><i class="fa fa-trash-alt"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($genres as $genre)
                                            <tr>
                                                <td>{{ $genre->id }}</td>
                                                <td>{{ $genre->name }}</td>
                                                <td>{{ $genre->slug }}</td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm blog-btn" href="{{ route('genres.edit', ['genre' => $genre->id]) }}">
                                                        <i class="fa fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('genres.destroy', ['genre' => $genre->id]) }}" method="post" class="float-left">
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
                                <p>Жанров пока нет...</p>
                            @endif
                        </div>
                        <div class="card-footer clearfix">
                            {{ $genres->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
