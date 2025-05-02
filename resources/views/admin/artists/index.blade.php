@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Артисты</h1>
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
                            <h3 class="card-title">Список артистов</h3>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('artists.create') }}" class="btn btn-primary mb-3">Добавить артиста</a>
                            @if (count($artists))
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
                                            @foreach($artists as $artist)
                                                <tr>
                                                    <td>{{ $artist->id }}</td>
                                                    <td>{{ $artist->name }}</td>
                                                    <td>{{ $artist->slug }}</td>
                                                    <td>
                                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('artists.edit', ['artist' => $artist->id]) }}">
                                                            <i class="fa fa-pencil-alt"></i>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('artists.destroy', ['artist' => $artist->id]) }}" method="post" class="float-left">
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
                                <p>Артистов пока нет...</p>
                            @endif
                        </div>
                        <div class="card-footer clearfix">
                            {{ $artists->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
