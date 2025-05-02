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
                        <li class="breadcrumb-item"><a href="{{ route('user.index') }}">Личный кабинет</a></li>
                        <li class="breadcrumb-item active">Редактирование комментария</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="tab-content dashboard_content" data-aos="fade-up" data-aos-delay="200">
        <div class="tab-pane fade show active" id="dashboard">
            <h4>Редактирование комментария</h4>
            <form role="form" method="post" action="{{ route('user.comment.update', ['comment' => $comment->id]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="content">Текст комментария</label>
                    <textarea class="form-control @error('content') is-invalid @enderror"
                              name="content" id="comment-content" maxlength="500"
                              rows="5">{{ old('content') ?? $comment->content }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary blog-btn">Сохранить</button>
            </form>
        </div>
    </div>
@endsection


