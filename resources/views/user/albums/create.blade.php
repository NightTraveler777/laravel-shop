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
            <h4>Новый альбом</h4>
            <form id="form-create" role="form" method="post" action="{{ route('user.album.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="genre_id">Жанр</label>
                    <select class="form-control @error('genre_id') is-invalid @enderror" id="genre_id" name="genre_id">
                        @foreach($genres as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                @isset($labels)
                    <div class="form-group">
                        <label for="label_id">Лейбл</label>
                        <select class="form-control @error('label_id') is-invalid @enderror" id="label_id" name="label_id">
                            @foreach($labels as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                @endisset

                @isset($artists)
                    <div class="form-group">
                        <label for="artist_id">Артист</label>
                        <select class="form-control @error('artist_id') is-invalid @enderror" id="artist_id" name="artist_id">
                            @foreach($artists as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                @endisset

                <div class="form-group">
                    <label for="name">Название</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror" id="name"
                           placeholder="Название">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="7" placeholder="Описание..."></textarea>
                </div>

                <div class="form-group">
                    <label for="cover">Обложка</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input id="cover" type="file" class="custom-file-input" name="cover">
                            <label class="custom-file-label" for="cover">Выберите файл</label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Диски</label>
                    <label>CD <a class="add-btn" data-main-format="discs" data-format="cd"><i class="fa fa-plus"></i></a></label>
                    <label>DVD <a class="add-btn" data-main-format="discs" data-format="dvd"><i class="fa fa-plus"></i></a></label>
                </div>

                <div class="form-group">
                    <label>Винил</label>
                    <label>Черный <a class="add-btn" data-main-format="vinyl" data-format="black-vinyl"><i class="fa fa-plus"></i></a></label>
                    <label>Цветной <a class="add-btn" data-main-format="vinyl" data-format="color-vinyl"><i class="fa fa-plus"></i></a></label>
                </div>

                {{--<div class="form-group">
                    <label for="tags">Теги</label>
                    <select name="tags[]" id="tags" class="select2" multiple="multiple" data-placeholder="Выбор тегов" style="width: 100%;">
                        @foreach($tags as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>--}}

                <button type="submit" class="btn btn-primary blog-btn">Сохранить</button>

            </form>
        </div>
    </div>
@endsection


