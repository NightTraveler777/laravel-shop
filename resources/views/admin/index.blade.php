@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Главная</h1>
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
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Новые посты</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if (count($new_posts))
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>Дата и время</th>
                                <th>Наименование</th>
                                <th>Автор публикации</th>
                                <th><i class="fas fa-eye"></i></th>
                                <th><i class="fas fa-toggle-on"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($new_posts as $post)
                                <tr>
                                    <td>{{ $post->id }}</td>
                                    <td>{{ $post->created_at }}</td>
                                    <td>{{ $post->title }}</td>
                                    <td>{{ $post->user->name }}</td>
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
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Новых постов пока нет...</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Новые комментарии</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                @if (count($new_comments))
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th style="width: 30px">#</th>
                                <th>Дата и время</th>
                                <th>Текст комментария</th>
                                <th>Автор комментария</th>
                                <th><i class="fas fa-eye"></i></th>
                                <th><i class="fas fa-toggle-on"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($new_comments as $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->created_at }}</td>
                                    <td>{{ iconv_substr($comment->content, 0, 100) }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>
                                        @perm('manage-comments')
                                        @php($params = ['comment' => $comment->id, 'page' => $comment->adminPageNumber($comment->post->comments)])
                                        <a class="btn btn-primary btn-sm"
                                           href="{{ route('comments.show', $params) }}#comment-area"
                                           title="Предварительный просмотр">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @endperm
                                    </td>
                                    <td>
                                        @perm('publish-comment')
                                        @if ($comment->isVisible())
                                            <form action="{{ route('comments.disable', ['comment' => $comment->id]) }}" method="post" class="float-left">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-toggle-on"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('comments.enable', ['comment' => $comment->id]) }}" method="post" class="float-left">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-toggle-off"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @endperm
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p>Новых комментариев пока нет...</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Title</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                Start creating your amazing application!
            </div>
            <div class="card-footer">
                Footer
            </div>
        </div>
    </section>
@endsection
