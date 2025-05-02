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
            <h4>Ваши комментарии</h4>
            @if (count($comments))
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Дата и время</th>
                            <th>Текст комментария</th>
                            <th><i class="fa fa-eye"></i></th>
                            <th><i class="fa fa-toggle-on"></i></th>
                            <th><i class="fa fa-pencil"></i></th>
                            <th><i class="fa fa-trash"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($comments as $comment)
                            <tr>
                                <td>{{ $comment->created_at }}</td>
                                <td>{{ iconv_substr($comment->content, 0, 100) }}</td>
                                <td>
                                    @php($params = ['comment' => $comment->id, 'page' => $comment->userPageNumber($comment->post->comments)])
                                    <a class="btn btn-primary btn-sm blog-btn"
                                       href="{{ route('user.comment.show', $params) }}#comment-area"
                                       title="Предварительный просмотр">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                <td>
                                    @if ($comment->isVisible())
                                        <i class="fa fa-toggle-on text-success"></i>
                                    @else
                                        <i class="fa fa-toggle-off text-black-50"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (!$comment->isVisible())
                                        <a class="btn btn-primary btn-sm blog-btn" href="{{ route('user.comment.edit', ['comment' => $comment->id]) }}">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                    @else
                                        <i class="fa fa-pencil text-black-50"></i>
                                    @endif
                                </td>
                                <td>
                                    @if (!$comment->isVisible())
                                        <form action="{{ route('user.comment.destroy', ['comment' => $comment->id]) }}" method="post" class="float-left">
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
                <p>Комментариев пока нет...</p>
            @endif
            {{ $comments->links() }}
        </div>
    </div>
@endsection
