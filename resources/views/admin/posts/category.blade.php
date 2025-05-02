@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Статьи категории</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $category->title }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Добавить статью</a>
                            @if (count($posts))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Наименование</th>
                                            <th>Автор публикации</th>
                                            <th>Разрешил публикацию</th>
                                            <th>Категория</th>
                                            <th>Теги</th>
                                            <th>Дата</th>
                                            <th><i class="fas fa-eye"></i></th>
                                            <th><i class="fas fa-toggle-on"></i></th>
                                            <th><i class="fas fa-pencil-alt"></i></th>
                                            <th><i class="fas fa-trash-alt"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($posts as $post)
                                            <tr>
                                                <td>{{ $post->id }}</td>
                                                <td>{{ $post->title }}</td>
                                                <td>{{ $post->user->name }}</td>
                                                <td>
                                                    @if ($post->editor)
                                                        {{ $post->editor->name }}
                                                    @endif
                                                </td>
                                                <td>{{ $category->title }}</td>
                                                <td>{{ $post->tags->pluck('title')->join(', ') }}</td>
                                                <td>{{ $post->created_at }}</td>
                                                <td>
                                                    @perm('manage-posts')
                                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.show', ['post' => $post->id]) }}"
                                                       title="Предварительный просмотр">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    @endperm
                                                </td>
                                                <td>
                                                    @perm('publish-post')
                                                    @if ($post->isVisible())
                                                        <form action="{{ route('posts.disable', ['post' => $post->id]) }}" method="post" class="float-left">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-toggle-on"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('posts.enable', ['post' => $post->id]) }}" method="post" class="float-left">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                <i class="fas fa-toggle-off"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @endperm
                                                </td>
                                                <td>
                                                    @perm('edit-post')
                                                    <a class="btn btn-primary btn-sm" href="{{ route('posts.edit', ['post' => $post->id]) }}">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    @endperm
                                                </td>
                                                <td>
                                                    @perm('delete-post')
                                                    <form action="{{ route('posts.destroy', ['post' => $post->id]) }}" method="post" class="float-left">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-primary btn-sm" onclick="return confirm('Подтвердите удаление')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    @endperm
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p>Статей пока нет...</p>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $posts->links() }}
                        </div>
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection
