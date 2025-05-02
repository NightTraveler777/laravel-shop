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
            <h4>Новая публикация</h4>
            <form role="form" method="post" action="{{ route('user.post.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" name="title"
                           class="form-control @error('title') is-invalid @enderror" id="title"
                           placeholder="Название">
                </div>

                <div class="form-group">
                    <label for="description">Цитата</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Цитата..."></textarea>
                </div>

                <div class="form-group">
                    <label for="content">Контент</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="7" placeholder="Контент..."></textarea>
                </div>

                <div class="form-group">
                    <label for="category_id">Категория</label>
                    <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id">
                        @foreach($categories as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="tags">Теги</label>
                    <select name="tags[]" id="tags" class="select2" multiple="multiple" data-placeholder="Выбор тегов" style="width: 100%;">
                        @foreach($tags as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Изображение</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="thumbnail" id="thumbnail">
                            <label class="custom-file-label" for="thumbnail">Выберите файл</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary blog-btn">Сохранить</button>

            </form>
        </div>
    </div>
@endsection
