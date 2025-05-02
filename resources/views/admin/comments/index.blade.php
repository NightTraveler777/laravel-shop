@extends('admin.layouts.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Комментарии</h1>
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
                            <h3 class="card-title">Список комментариев</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @if (count($comments))
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th style="width: 30px">#</th>
                                            <th>Дата и время</th>
                                            <th>Текст комментария</th>
                                            <th>Автор комментария</th>
                                            <th>Разрешил публикацию</th>
                                            <th><i class="fas fa-eye"></i></th>
                                            <th><i class="fas fa-toggle-on"></i></th>
                                            <th><i class="fas fa-pencil-alt"></i></th>
                                            <th><i class="fas fa-trash-alt"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($comments as $comment)
                                            <tr>
                                                <td>{{ $comment->id }}</td>
                                                <td>{{ $comment->created_at }}</td>
                                                <td>{{ iconv_substr($comment->content, 0, 100) }}</td>
                                                <td>{{ $comment->user->name }}</td>
                                                <td>
                                                    @if ($comment->editor)
                                                        {{ $comment->editor->name }}
                                                    @endif
                                                </td>
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
                                                <td>
                                                    @perm('edit-comment')
                                                        <a class="btn btn-primary btn-sm" href="{{ route('comments.edit', ['comment' => $comment->id]) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endperm
                                                </td>
                                                <td>
                                                    @perm('delete-comment')
                                                        <form action="{{ route('comments.destroy', ['comment' => $comment->id]) }}" method="post" class="float-left">
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
                                <p>Комментариев пока нет...</p>
                            @endif
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer clearfix">
                            {{ $comments->links() }}
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
